<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'usuari1',
                'password' => password_hash('password1', PASSWORD_BCRYPT),
                'email' => 'usuari1@example.com',
                'age' => 25,
                'country' => 'España',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'usuari2',
                'password' => password_hash('password2', PASSWORD_BCRYPT),
                'email' => 'usuari2@example.com',
                'age' => 30,
                'country' => 'França',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}