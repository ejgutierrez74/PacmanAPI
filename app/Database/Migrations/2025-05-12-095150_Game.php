<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Game extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'played_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'won' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
            ],

            'score' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'duration' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('game');
    }

    public function down()
    {
        $this->forge->dropTable('game');
    }
}
