<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function register()
    {
        $db = \Config\Database::connect();
        
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        
        try {
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $builder = $db->table('users');
            $result = $builder->insert($data);
            
            if ($result) {
                return redirect()->to('/login');
            } else {
                echo "Registration failed!";
            }
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}