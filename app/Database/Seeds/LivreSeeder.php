<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LivreSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('livres')->insertBatch([
            ['titre' => 'Clean Code', 'auteur' => 'Robert C. Martin', 'annee' => 2008],
            ['titre' => 'The Pragmatic Programmer', 'auteur' => 'Andrew Hunt, David Thomas', 'annee' => 1999],
            ['titre' => 'Refactoring', 'auteur' => 'Martin Fowler', 'annee' => 1999],
        ]);
    }
}
