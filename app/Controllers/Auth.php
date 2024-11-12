<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function register()
    {
        return view('register');
    }

    public function processRegister()
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'terms' => $this->request->getPost('terms'),
            'form_type' => 'registration'
        ];
        
        return view('result', $data);
    }

    public function login()
    {
        return view('login');
    }

    public function processLogin()
    {
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'remember' => $this->request->getPost('remember'),
            'form_type' => 'login'
        ];
        
        return view('result', $data);
    }
}