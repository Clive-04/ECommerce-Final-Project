<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data['title'] = "VIZIO Admin";

        return view('admin_view', $data);
    }

    public function products()
    {
        $data['title'] = "VIZIO Admin Products";

        return view('adminproducts_view', $data);
    }

    public function orders()
    {
        $data['title'] = "VIZIO Admin Orders";

        return view('adminorders_view', $data);
    }
}
