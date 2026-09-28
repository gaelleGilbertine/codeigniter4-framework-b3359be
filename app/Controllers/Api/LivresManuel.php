<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LivreModel;

/**
 * Étape A : un endpoint écrit « à la main », sans ResourceController.
 * Route : GET api/manuel/livres/(:num)
 */
class LivresManuel extends BaseController
{
    public function show($id)
    {
        $livre = model(LivreModel::class)->find($id);

        // TODO 1 : si le livre n'existe pas, renvoyer un 404
        //          avec un corps JSON {"erreur": "Livre ... introuvable"}.
        if ($livre === null) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'erreur' => "Livre {$id} introuvable"
                ]);
        }

        // TODO 2 : sinon, renvoyer le livre en JSON avec le code 200.
        return $this->response
            ->setStatusCode(200)
            ->setJSON($livre);
    }
}