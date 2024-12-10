<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'email' => $session->get('email')
        ];

        return view('index', $data);
    }
}