<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Game extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'played_at' => '2025-05-01 12:00:00',
                'won' => 1,
                'score' => 100,
                'duration' => 3600,
            ],
            [
                'user_id' => 1,
                'played_at' => '2025-05-02 14:30:00',
                'won' => 0,
                'score' => 50,
                'duration' => 2400,
            ],
            [
                'user_id' => 2,
                'played_at' => '2025-05-03 16:00:00',
                'won' => 1,
                'score' => 120,
                'duration' => 3000,
            ],
        ];

        $this->db->table('game')->insertBatch($data);
    }
}