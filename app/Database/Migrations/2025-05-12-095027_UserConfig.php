<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserConfig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
                
            ],
            'theme' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'music' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'difficulty' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('userconfig');
    }

    public function down()
    {
        $this->forge->dropTable('userconfig');
    }
}