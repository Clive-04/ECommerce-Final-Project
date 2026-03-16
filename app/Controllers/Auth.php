<?php

namespace App\Controllers;

use App\Models\UserModel;

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


    public function saveUser()
    {

        $userModel = new UserModel();

        $password = password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );

        $data = [

            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => $password,
            'role'       => 'user'

        ];

        $userModel->insert($data);

        return redirect()->to('/login')
        ->with('success','Registration successful. Please login.');
    }



    public function authenticate()
    {

        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel
        ->where('email',$email)
        ->first();


        if($user)
        {

            if(password_verify($password,$user['password']))
            {

                session()->set([

                    'user_id' => $user['id'],
                    'user_name' => $user['first_name'],
                    'role' => $user['role'],
                    'logged_in' => true

                ]);


                if($user['role'] == 'admin')
                {
                    return redirect()->to('/admin');
                }
                else
                {
                    return redirect()->to('/');
                }

            }

        }

        return redirect()->back()
        ->with('error','Invalid email or password');

    }



    public function logout()
    {

        session()->destroy();

        return redirect()->to('/login');

    }

}
