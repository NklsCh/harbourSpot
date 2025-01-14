<?php
namespace App\Controllers;

class Registration extends BaseController
{
    public function submit()
    {
        $userData = $this->request->getPost();
        
        $data = [
            'user' => $userData['user'],
            'password' => $userData['password'] // wird für die Anzeige benötigt
        ];
        
        return view('confirmation', $data);
    }
}