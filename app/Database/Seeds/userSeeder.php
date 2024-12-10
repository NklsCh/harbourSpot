<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class userSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email' => 'admin@admin.com',
            'password' => '$2y$10$lOyscMX.Iup5T5DqOHqoleGz8yLn60Yjd0ivB7UcFfM08mvnk7lbK',
        ];

        $this->db->query('INSERT INTO users (email, password) VALUES(:email:, :password:)', $data);
        $this->db->table('users')->insert($data);
    }
}