<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'user_name',
        'user_surname',
        'user_password',
        'user_email',
        'user_role',
    ];
    
    public function getUserByEmail($email)
    {
        return $this->where('user_email', $email)->first();
    }
    
    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]'
    ];
}