<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        $data['title'] = "VIZIO Login";

        return view('login_view', $data);
    }

    public function register()
    {
        $data['title'] = "VIZIO Register";

        return view('register_view', $data);
    }
}
