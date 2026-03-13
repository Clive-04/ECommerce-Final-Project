<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        $data['title'] = "Product Catalog";

        return view('products_view', $data);
    }
}