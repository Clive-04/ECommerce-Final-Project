<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->session = session();
    }

    public function index()
    {
        $data['title'] = "Product Catalog";
        $data['products'] = $this->productModel->findAll();

        return view('products_view', $data);
    }

    public function details()
    {
        $id = $this->request->getGet('id');

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
        $id = $this->request->getPost('id');
        $quantity = (int) $this->request->getPost('quantity');

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $result = $this->addProductToCart((int) $id, $quantity);
        if (! $result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/cart')->with('success', $result['message']);
    }

    public function buyNow()
    {
        $id = $this->request->getPost('id');
        $quantity = (int) $this->request->getPost('quantity');

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
        $data['title'] = "Shopping Cart";
        $data['cart'] = $this->session->get('cart') ?? [];

        return view('cart_view', $data);
    }

    public function updateCart()
    {
        $id = $this->request->getPost('id');
        $newQuantity = (int) $this->request->getPost('quantity');

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $cart = $this->session->get('cart') ?? [];
        if (! isset($cart[$id])) {
            return redirect()->back()->with('error', 'Product not found in your cart.');
        }

        $oldQuantity = $cart[$id]['quantity'];

        if ($newQuantity <= 0) {
            return $this->removeFromCart();
        }

        $delta = $newQuantity - $oldQuantity;
        if ($delta === 0) {
            return redirect()->back()->with('success', 'Quantity unchanged.');
        }

        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->back()->with('error', 'Product no longer exists.');
        }

        // If increasing quantity, make sure stock is available
        if ($delta > 0 && $product['stock'] < $delta) {
            return redirect()->back()->with('error', 'Not enough stock to increase quantity.');
        }

        // Adjust stock based on quantity delta
        $this->productModel->update($id, ['stock' => $product['stock'] - $delta]);

        $cart[$id]['quantity'] = $newQuantity;
        $cart[$id]['total'] = $newQuantity * $cart[$id]['price'];
        $this->session->set('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated.');
    }

    public function removeFromCart()
    {
        $id = $this->request->getPost('id');

        if (! $id) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $cart = $this->session->get('cart') ?? [];
        if (! isset($cart[$id])) {
            return redirect()->back()->with('error', 'Product not found in your cart.');
        }

        $quantity = $cart[$id]['quantity'];

        // Return quantity back to stock
        $product = $this->productModel->find($id);
        if ($product) {
            $this->productModel->update($id, ['stock' => $product['stock'] + $quantity]);
        }

        unset($cart[$id]);
        $this->session->set('cart', $cart);

        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    public function checkout()
    {
        $data['title'] = "Checkout";

        return view('checkout_view', $data);
    }

    public function shipping()
    {
        $data['title'] = "Shipping";

        return view('shipping_view', $data);
    }

    public function payment()
    {
        $data['title'] = "Payment";

        return view('payment_view', $data);
    }

    public function confirmation()
    {
        $data['title'] = "Confirmation";

        return view('confirmation_view', $data);
    }
}