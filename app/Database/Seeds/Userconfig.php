<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Userconfig extends Seeder
{
   public function run()
    {
        $data = [
            [
                'user_id' => 1, 
                'theme' => 'dark',
                'music' => 'on',
                'difficulty' => 'medium',
            ],
            [
                'user_id' => 2, 
                'theme' => 'light',
                'music' => 'off',
                'difficulty' => 'hard',
            ],
        ];

  
        $this->db->table('userconfig')->insertBatch($data);
    }
}