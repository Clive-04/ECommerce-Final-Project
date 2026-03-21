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


        if ($user)
        {
            $storedPassword = $user['password'];

            // Accept both hashed passwords (the normal case) and legacy plaintext values (from older seed data).
            $passwordMatches = false;

            if (password_verify($password, $storedPassword)) {
                $passwordMatches = true;
            } else {
                // If the stored password is not a bcrypt/argon hash, allow plaintext match and upgrade it.
                $isProbablyHashed = preg_match('/^\$(2y|2a|2b|argon2i|argon2id)\$/', $storedPassword);
                if (! $isProbablyHashed && trim($storedPassword) === $password) {
                    $passwordMatches = true;

                    // Upgrade to a hashed password so the account is secure going forward.
                    $userModel->update($user['id'], [
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                    ]);
                }
            }

            if ($passwordMatches) {
                $role = strtolower($user['role'] ?? '');

                session()->set([
                    'user_id'   => $user['id'],
                    'user_name' => $user['first_name'],
                    'role'      => $role,
                    'logged_in' => true,
                ]);

                if ($role === 'admin') {
                    return redirect()->to('/admin');
                }

                return redirect()->to('/');
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
