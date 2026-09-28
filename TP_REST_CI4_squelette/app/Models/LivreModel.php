<?php

namespace App\Models;

use CodeIgniter\Model;

class LivreModel extends Model
{
    protected $table         = 'livres';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['titre', 'auteur', 'annee'];

    // Les règles de validation produisent les erreurs renvoyées en 400.
    protected $validationRules = [
        'titre'  => 'required|max_length[200]',
        'auteur' => 'required|max_length[120]',
        'annee'  => 'permit_empty|integer|greater_than[1400]',
    ];

    protected $validationMessages = [
        'titre'  => ['required' => 'Le titre est obligatoire.'],
        'auteur' => ['required' => "L'auteur est obligatoire."],
        'annee'  => ['integer' => "L'année doit être un entier."],
    ];
}
