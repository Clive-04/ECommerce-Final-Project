<?php

namespace App\Controllers;

use App\Models\CustomerInformationModel;
use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    protected $customerInfoModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::initController($request, $response, $logger);

        // Models used across this controller
        $this->productModel = new ProductModel();
        $this->customerInfoModel = new CustomerInformationModel();
    }

    protected function getCheckoutMode(): string
    {
        // Determine checkout mode from query parameter (preferred) or stored session state.
        $mode = $this->request->getVar('source') ?? $this->session->get('checkoutMode') ?? 'cart';
        if (! in_array($mode, ['cart', 'buyNow'])) {
            $mode = 'cart';
        }

        // If explicit cart checkout requested, clear any buy-now state.
        if ($mode === 'cart') {
            $this->session->remove('buyNowItem');
        }

        // If buy now mode is requested but no buy-now item exists, fall back to cart.
        if ($mode === 'buyNow' && ! $this->session->get('buyNowItem')) {
            $mode = 'cart';
        }

        $this->session->set('checkoutMode', $mode);
        return $mode;
    }

    protected function buildOrderSummary(): array
    {
        $mode = $this->getCheckoutMode();
        $orderSummary = [];
        $total = 0;
        $productModel = new ProductModel();

        if ($mode === 'buyNow') {
            $buyNowItem = $this->session->get('buyNowItem');
            if ($buyNowItem) {
                $product = $productModel->find($buyNowItem['product_id']);
                if ($product) {
                    $quantity = (int) ($buyNowItem['quantity'] ?? 1);
                    $itemTotal = $product['price'] * $quantity;
                    $orderSummary[] = [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $quantity,
                        'total' => $itemTotal,
                    ];
                    $total = $itemTotal;
                }
            }
        } else {
            $userId = session()->get('user_id');
            $cartModel = new \App\Models\CartModel();
            $cartItemModel = new \App\Models\CartItemModel();
            $cartId = $cartModel->getOrCreateCart($userId);
            $cartItems = $cartItemModel->getCartItems($cartId);

            foreach ($cartItems as $item) {
                $product = $productModel->find($item['product_id']);
                if (! $product) {
                    continue;
                }
                $itemTotal = $product['price'] * $item['quantity'];
                $orderSummary[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
                $total += $itemTotal;
            }
        }

        return ['orderSummary' => $orderSummary, 'orderTotal' => $total];
    }

    public function index()
    {
        $data['title'] = "Product Catalog";

        // Filter by category query param (e.g. /products?category=Headphones)
        $category = $this->request->getVar('category');
        $normalized = $category ? strtolower(preg_replace('/\s+/', '', $category)) : '';

        // Map normalized values to the user-facing label (used for active button state)
        $categoryLabelMap = [
            'headphones' => 'Headphones',
            'powerbanks' => 'Powerbanks',
            'phonecases' => 'Phone Cases',
            'earbuds' => 'Earbuds',
        ];

        $data['selectedCategory'] = $normalized !== '' && isset($categoryLabelMap[$normalized])
            ? $categoryLabelMap[$normalized]
            : '';

        $query = $this->productModel;
        if ($normalized !== '') {
            // Compare with normalized db value (lowercase, without spaces) so "Phone Cases" matches "Phonecases".
            // We build an expression to allow using SQL functions on the left and still bind the value safely.
            $query = $query->where("REPLACE(LOWER(category), ' ', '') =", $normalized);
        }

        $data['products'] = $query->findAll();

        return view('products_view', $data);
    }

    public function details()
    {
        $id = $this->request->getVar('id');

        if ($id) {
            $product = $this->productModel->find($id);
            if ($product) {
                $data['product'] = $product;
            } else {
                // product not found, redirect to products
                return redirect()->to('/products');
            }
        } else {
            // no id provided, redirect to products
            return redirect()->to('/products');
        }

        $data['title'] = "Product Details";

        return view('productDetails_view', $data);
    }

    protected function addProductToCart(int $id, int $quantity): array
    {
        if (! session()->get('logged_in')) {
            return ['success' => false, 'message' => 'Please log in to add items to your cart.'];
        }

        if ($quantity <= 0) {
            return ['success' => false, 'message' => 'Invalid quantity.'];
        }

        $product = $this->productModel->find($id);
        if (! $product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($product['stock'] < $quantity) {
            return ['success' => false, 'message' => 'Not enough stock for the requested quantity.'];
        }

        // Deduct stock in database
        $this->productModel->update($id, ['stock' => $product['stock'] - $quantity]);

        // Store cart item in DB
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItemModel->addItem($cartId, $id, $quantity);

        // Keep session cart for UI (if used elsewhere)
        $cart = $this->session->get('cart') ?? [];
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
            $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
        } else {
            $cart[$id] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'image'    => $product['image'],
                'quantity' => $quantity,
                'total'    => $product['price'] * $quantity,
            ];
        }

        $this->session->set('cart', $cart);

        return ['success' => true, 'message' => 'Added to cart.'];
    }

    public function addToCart()
    {
        $id = $this->request->getVar('id');
        $quantity = (int) $this->request->getVar('quantity');

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to add items to your cart.');
        }

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock for the requested quantity.');
        }

        // Deduct stock in database
        $this->productModel->update($id, ['stock' => $product['stock'] - $quantity]);

        // Store cart item in DB
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItemModel->addItem($cartId, $id, $quantity);

        return redirect()->back()->with('success', 'Added to cart.');
    }

    public function buyNow()
    {
        $id = $this->request->getVar('id');
        $quantity = (int) $this->request->getVar('quantity');

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to continue.');
        }

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Invalid quantity.');
        }

        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock for the requested quantity.');
        }

        // Deduct stock in database
        $this->productModel->update($id, ['stock' => $product['stock'] - $quantity]);

        // Store only the buy-now item in session (so it doesn't merge with cart)
        $this->session->set('buyNowItem', [
            'product_id' => $id,
            'quantity'   => $quantity,
        ]);

        return redirect()->to('/checkout?source=buyNow')->with('success', 'Proceeding to checkout for this item.');
    }

    public function cart()
    {
        // Require login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to view your cart.');
        }

        $data['title'] = "Shopping Cart";

        // Get user cart from DB
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);

        // Fetch product details for each cart item
        $productModel = new \App\Models\ProductModel();
        $cart = [];
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $item['quantity'],
                    'total' => $product['price'] * $item['quantity']
                ];
            }
        }
        $data['cart'] = $cart;

        return view('cart_view', $data);
    }

    public function updateCart()
    {
        $id = $this->request->getVar('id');
        $newQuantity = (int) $this->request->getVar('quantity');

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to update your cart.');
        }
        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $item = $cartItemModel->where(['cart_id' => $cartId, 'product_id' => $id])->first();
        if (! $item) {
            return redirect()->back()->with('error', 'Product not found in your cart.');
        }
        $oldQuantity = $item['quantity'];
        if ($newQuantity <= 0) {
            // Remove item
            $cartItemModel->removeItem($cartId, $id);
            // Return quantity to stock
            $product = $this->productModel->find($id);
            if ($product) {
                $this->productModel->update($id, ['stock' => $product['stock'] + $oldQuantity]);
            }
            return redirect()->back()->with('success', 'Product removed from cart.');
        }
        $delta = $newQuantity - $oldQuantity;
        if ($delta === 0) {
            return redirect()->back()->with('success', 'Quantity unchanged.');
        }
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->back()->with('error', 'Product no longer exists.');
        }
        if ($delta > 0 && $product['stock'] < $delta) {
            return redirect()->back()->with('error', 'Not enough stock to increase quantity.');
        }
        // Adjust stock
        $this->productModel->update($id, ['stock' => $product['stock'] - $delta]);
        $cartItemModel->updateItem($cartId, $id, $newQuantity);
        return redirect()->back()->with('success', 'Cart updated.');
    }

    public function removeFromCart()
    {
        $id = $this->request->getVar('id');

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to update your cart.');
        }
        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $item = $cartItemModel->where(['cart_id' => $cartId, 'product_id' => $id])->first();
        if (! $item) {
            return redirect()->back()->with('error', 'Product not found in your cart.');
        }
        $quantity = $item['quantity'];
        // Return quantity to stock
        $product = $this->productModel->find($id);
        if ($product) {
            $this->productModel->update($id, ['stock' => $product['stock'] + $quantity]);
        }
        $cartItemModel->removeItem($cartId, $id);
        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    public function checkout()
    {
        $data['title'] = "Checkout";
        $data['customer'] = $this->session->get('customerInfo') ?? [];
        $data['errors'] = $this->session->getFlashdata('errors') ?? [];
        $data['success'] = $this->session->getFlashdata('success');

        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to checkout.');
        }

        // Determine whether we are in "cart" or "buy now" mode and build the order summary.
        $data['checkoutMode'] = $this->getCheckoutMode();
        $summary = $this->buildOrderSummary();
        $data['orderSummary'] = $summary['orderSummary'];
        $data['orderTotal'] = $summary['orderTotal'];

        return view('checkout_view', $data);
    }

    // Place order logic
    public function placeOrder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to place your order.');
        }

        $userId = session()->get('user_id');
        $productModel = new \App\Models\ProductModel();
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();

        $checkoutMode = $this->getCheckoutMode();
        $summary = $this->buildOrderSummary();
        $orderSummary = $summary['orderSummary'];
        $total = $summary['orderTotal'];

        // Create order
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'status'  => 'Pending',
            'total'   => $total,
        ]);

        // Add order items
        if ($checkoutMode === 'buyNow') {
            $buyNowItem = $this->session->get('buyNowItem');
            if ($buyNowItem) {
                $product = $productModel->find($buyNowItem['product_id']);
                if ($product) {
                    $orderItemModel->insert([
                        'order_id'   => $orderId,
                        'product_id' => $buyNowItem['product_id'],
                        'quantity'   => $buyNowItem['quantity'],
                        'price'      => $product['price'],
                    ]);
                }
            }
        } else {
            $cartModel = new \App\Models\CartModel();
            $cartItemModel = new \App\Models\CartItemModel();
            $cartId = $cartModel->getOrCreateCart($userId);
            $cartItems = $cartItemModel->getCartItems($cartId);

            foreach ($cartItems as $item) {
                $product = $productModel->find($item['product_id']);
                if ($product) {
                    $orderItemModel->insert([
                        'order_id'   => $orderId,
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $product['price'],
                    ]);
                }
            }

            // Clear cart (database + session) so user starts fresh.
            foreach ($cartItems as $item) {
                $cartItemModel->removeItem($cartId, $item['product_id']);
            }
            $this->session->remove('cart');
        }

        // Keep the last order details for displaying on confirmation
        $this->session->set('lastOrderSummary', $orderSummary);
        $this->session->set('lastOrderTotal', $total);
        $this->session->set('lastOrderShipping', $this->session->get('shipping'));
        $this->session->set('lastOrderPaymentMethod', $this->session->get('paymentMethod'));

        // Optionally clear checkout session data (so next checkout starts clean)
        $this->session->remove(['shipping', 'paymentMethod', 'customerInfo', 'buyNowItem', 'checkoutMode']);

        return redirect()->to('/confirmation')->with('success', 'Order placed successfully!');
    }

    public function saveCustomerInfo()
    {
        helper(['form']);

        $rules = [
            'first_name'     => 'required|max_length[100]',
            'last_name'      => 'required|max_length[100]',
            'email'          => 'required|valid_email|max_length[255]',
            'phone_number'   => 'required|max_length[50]',
            'street_address' => 'required|max_length[255]',
            'city'           => 'required|max_length[100]',
            'state_province' => 'required|max_length[100]',
            'postal_code'    => 'required|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $payload = $this->request->getVar([
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'street_address',
            'city',
            'state_province',
            'postal_code',
        ]);

        // Save to session for later steps
        $this->session->set('customerInfo', $payload);

        // Persist to database (update if already stored)
        $existingId = $this->session->get('customerInfoId');
        if ($existingId) {
            $this->customerInfoModel->update($existingId, $payload);
        } else {
            $insertId = $this->customerInfoModel->insert($payload);
            if ($insertId) {
                $this->session->set('customerInfoId', $insertId);
            }
        }

        return redirect()->to('/shipping')->with('success', 'Customer information saved.');
    }

    public function shipping()
    {
        $data['title'] = "Shipping";
        $data['cart'] = $this->session->get('cart') ?? [];
        $data['shipping'] = $this->session->get('shipping') ?? 'standard';
        $data['errors'] = $this->session->getFlashdata('errors') ?? [];
        $data['success'] = $this->session->getFlashdata('success');

        // Build order summary based on current checkout mode (cart vs buy now).
        $data['checkoutMode'] = $this->session->get('checkoutMode') ?? 'cart';
        $summary = $this->buildOrderSummary();
        $data['orderSummary'] = $summary['orderSummary'];
        $data['orderTotal']   = $summary['orderTotal'];
        $data['subtotal']     = $summary['orderTotal'];

        // Keep shipping prices available for display and calculation.
        $data['shippingPrices'] = [
            'standard'  => 120,
            'express'   => 220,
            'overnight' => 350,
        ];

        return view('shipping_view', $data);
    }

    public function saveShipping()
    {
        $shippingOptions = [
            'standard'  => 120,
            'express'   => 220,
            'overnight' => 350,
        ];

        $shipping = $this->request->getVar('shipping_method');
        if (! isset($shippingOptions[$shipping])) {
            return redirect()->back()->with('errors', ['Please select a valid shipping option.']);
        }

        $this->session->set('shipping', $shipping);

        return redirect()->to('/payment')->with('success', 'Shipping method selected.');
    }

    public function payment()
    {
        $data['title'] = "Payment";
        $data['cart'] = $this->session->get('cart') ?? [];
        $data['shipping'] = $this->session->get('shipping') ?? 'standard';
        $data['errors'] = $this->session->getFlashdata('errors') ?? [];
        $data['success'] = $this->session->getFlashdata('success');

        // Build order summary based on current checkout mode (cart vs buy now).
        $data['checkoutMode'] = $this->session->get('checkoutMode') ?? 'cart';
        $summary = $this->buildOrderSummary();
        $data['orderSummary'] = $summary['orderSummary'];
        $data['orderTotal']   = $summary['orderTotal'];
        $data['subtotal']     = $summary['orderTotal'];
        $data['shippingPrices'] = [
            'standard'  => 120,
            'express'   => 220,
            'overnight' => 350,
        ];

        return view('payment_view', $data);
    }

    public function confirmation()
    {
        $data['title'] = "Order Confirmation";
        $data['shipping'] = $this->session->get('shipping') ?? 'standard';
        $data['errors'] = $this->session->getFlashdata('errors') ?? [];
        $data['success'] = $this->session->getFlashdata('success');

        // Read and save selected payment method (if submitted)
        if ($this->request->getMethod() === 'post') {
            $paymentMethod = $this->request->getVar('payment_method') ?? 'Cash on Delivery';
            $this->session->set('paymentMethod', $paymentMethod);
        }

        $data['paymentMethod'] = $this->session->get('paymentMethod') ?? 'Cash on Delivery';

        // Load customer info from session (saved during checkout)
        // If an order was just placed, show the stored order details.
        $orderSummary = $this->session->get('lastOrderSummary');
        $total = $this->session->get('lastOrderTotal');
        $data['shipping'] = $this->session->get('lastOrderShipping') ?? $data['shipping'];
        $data['paymentMethod'] = $this->session->get('lastOrderPaymentMethod') ?? $data['paymentMethod'];

        // Otherwise, fall back to current cart or buy-now item.
        if (empty($orderSummary)) {
            $data['customer'] = $this->session->get('customerInfo') ?? [];

            $summary = $this->buildOrderSummary();
            $orderSummary = $summary['orderSummary'];
            $total = $summary['orderTotal'];
        }

        $data['cart'] = $orderSummary;
        $data['orderSummary'] = $orderSummary;
        $data['orderTotal'] = $total;
        $data['subtotal'] = $total;
        $data['shippingPrices'] = [
            'standard'  => 120,
            'express'   => 220,
            'overnight' => 350,
        ];

        return view('confirmation_view', $data);
    }
}