<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;

class Admin extends BaseController
{
    public function __construct()
    {
        if(!session()->get('logged_in') || session()->get('role') != 'admin')
        {
            header("Location: /login");
            exit;
        }
    }

    public function index()
    {
        $productModel = new ProductModel();
        $orderModel = new OrderModel();

        $data['title'] = "VIZIO Admin";

        $data['products_count'] = $productModel->countAll();

        $data['orders_count'] = $orderModel->countAll();

        $revenue = $orderModel->selectSum('total')->first();
        $data['revenue'] = $revenue['total'] ?? 0;

        $data['recent_orders'] = $orderModel
            ->orderBy('order_date','DESC')
            ->findAll(5);

        $data['products'] = $productModel
            ->orderBy('created_at','DESC')
            ->findAll(4);

        return view('admin_view', $data);
    }

    public function products()
    {
        $productModel = new ProductModel();

        $data['title'] = "VIZIO Admin Products";

        $data['products'] = $productModel
            ->orderBy('created_at','DESC')
            ->findAll();

        return view('adminproducts_view', $data);
    }

    public function orders()
    {
        $orderModel = new OrderModel();

        $data['title'] = "VIZIO Admin Orders";

        $data['orders'] = $orderModel
            ->orderBy('order_date','DESC')
            ->findAll();

        return view('adminorders_view', $data);
    }
}
