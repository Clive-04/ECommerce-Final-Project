<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        $data['title'] = "Product Catalog";

        return view('products_view', $data);
    }
    public function details()
    {
        $data['title'] = "Product Details";

        return view('productDetails_view', $data);
    }

    public function cart()
    {
        $data['title'] = "Shopping Cart";

        return view('cart_view', $data);
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