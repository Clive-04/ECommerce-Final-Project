<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "VIZIO Home";

        return view('homepage_view', $data);
    }
}
