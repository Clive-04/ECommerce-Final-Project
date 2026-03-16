<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
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