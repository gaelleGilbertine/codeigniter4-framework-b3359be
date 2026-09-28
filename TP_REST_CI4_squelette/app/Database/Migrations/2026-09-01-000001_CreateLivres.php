<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLivres extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'     => ['type' => 'INTEGER', 'unsigned' => true, 'auto_increment' => true],
            'titre'  => ['type' => 'VARCHAR', 'constraint' => 200],
            'auteur' => ['type' => 'VARCHAR', 'constraint' => 120],
            'annee'  => ['type' => 'INTEGER', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('livres');
    }

    public function down()
    {
        $this->forge->dropTable('livres');
    }
}
