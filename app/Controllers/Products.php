<?php

namespace App\Controllers;

use App\Models\CustomerInformationModel;
use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    protected $customerInfoModel;
    protected $session;
    /**
     * Instance of the main Request object.
     *
     * @var \CodeIgniter\HTTP\IncomingRequest
     */
    protected $request;

    public function __construct()
    {
        $this->request = service('request'); // Returns IncomingRequest
        $this->productModel = new ProductModel();
        $this->customerInfoModel = new CustomerInformationModel();
        $this->session = session();
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

        // Add/update session cart
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

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $result = $this->addProductToCart((int) $id, $quantity);
        if (! $result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/checkout')->with('success', $result['message']);
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

        // Get cart items for user
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to checkout.');
        }
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);

        $productModel = new \App\Models\ProductModel();
        $orderSummary = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $orderSummary[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'total' => $product['price'] * $item['quantity']
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $data['orderSummary'] = $orderSummary;
        $data['orderTotal'] = $total;

        return view('checkout_view', $data);
    }

    // Place order logic
    public function placeOrder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to place your order.');
        }
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);
        $productModel = new \App\Models\ProductModel();
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();

        $total = 0;
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $total += $product['price'] * $item['quantity'];
            }
        }
        // Create order
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'status' => 'Pending',
            'total' => $total
        ]);

        // Add order items
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $orderItemModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product['price']
                ]);
            }
        }

        // Clear cart
        foreach ($cartItems as $item) {
            $cartItemModel->removeItem($cartId, $item['product_id']);
        }

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

        // Link order summary
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);
        $productModel = new \App\Models\ProductModel();
        $orderSummary = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $orderSummary[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'total' => $product['price'] * $item['quantity']
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $data['orderSummary'] = $orderSummary;
        $data['orderTotal'] = $total;

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

        // Link order summary
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);
        $productModel = new \App\Models\ProductModel();
        $orderSummary = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $orderSummary[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'total' => $product['price'] * $item['quantity']
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $data['orderSummary'] = $orderSummary;
        $data['orderTotal'] = $total;

        return view('payment_view', $data);
    }

    public function confirmation()
    {
        $data['title'] = "Order Confirmation";
        $data['cart'] = $this->session->get('cart') ?? [];
        $data['shipping'] = $this->session->get('shipping') ?? 'standard';
        $data['errors'] = $this->session->getFlashdata('errors') ?? [];
        $data['success'] = $this->session->getFlashdata('success');

        // Link order summary
        $userId = session()->get('user_id');
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();
        $cartId = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartItemModel->getCartItems($cartId);
        $productModel = new \App\Models\ProductModel();
        $orderSummary = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $orderSummary[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'total' => $product['price'] * $item['quantity']
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $data['orderSummary'] = $orderSummary;
        $data['orderTotal'] = $total;

        return view('confirmation_view', $data);
    }
}