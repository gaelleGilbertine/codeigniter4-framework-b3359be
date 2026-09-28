<?php

namespace App\Controllers\Api;

use App\Models\LivreModel;
use CodeIgniter\RESTful\ResourceController;

/**
 * Étape B : la ressource « livres » avec ResourceController.
 * Route : $routes->resource('api/livres', ['except' => 'new,edit']);
 * Lancez « php spark routes » pour voir quelle méthode répond à quel verbe.
 *
 * Méthodes utiles du ResponseTrait :
 *   respond($data, $code)       respondCreated($data)     respondNoContent()
 *   respondDeleted($data)       failNotFound($message)    failValidationErrors($erreurs)
 *   fail($message, $code)
 * Le Model est disponible dans $this->model ; ses erreurs dans $this->model->errors().
 */
class Livres extends ResourceController
{
    protected $modelName = LivreModel::class;
    protected $format    = 'json';

    // GET /api/livres
    public function index()
    {
        // TODO : renvoyer les livres (200) au format du contrat :
        //        {"donnees": [ ...livres... ]}
         $livres = $this->model->findAll();

        return $this->respond([
            'donnees' => $livres
        ], 200);
        // Bonus : pagination avec ?page=2&par_page=10, et les clés page, par_page, total.
    }

    // GET /api/livres/{id}
    public function show($id = null)
    {
        // TODO : 200 avec le livre, ou 404 s'il n'existe pas.
        $livre = $this->model->find($id);

        if ($livre === null) {
            return $this->failNotFound("Livre {$id} introuvable");
        }

        return $this->respond($livre, 200);
    }

    // POST /api/livres
    public function create()
    {
        // TODO 1 : lire le corps JSON. Attention : getPost() ne marche pas ici.
        //          Indice : $this->request->getJSON(true)
        $data = $this->request->getJSON(true);
        // TODO 2 : insérer ; si la validation échoue, répondre 400 avec les erreurs.
        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        // TODO 3 : répondre 201 avec la ressource créée
        //          ET un en-tête Location vers /api/livres/{id}.
        //          respondCreated() ajoute-t-il cet en-tête ? Vérifiez avec curl -i.
         $id = $this->model->getInsertID();
        $livre = $this->model->find($id);

        return $this->response
            ->setStatusCode(201)
            ->setHeader('Location', site_url("api/livres/{$id}"))
            ->setJSON($livre);
    }

    // PUT et PATCH /api/livres/{id} arrivent ici tous les deux.
    public function update($id = null)
{
    // TODO 1 : vérifier que le livre existe
    $livre = $this->model->find($id);

    if ($livre === null) {
        return $this->failNotFound("Livre {$id} introuvable");
    }

    // Lire le JSON envoyé par le client
    $data = $this->request->getJSON(true);

    // Vérifier le verbe HTTP
    $methode = strtoupper($this->request->getMethod());

    if ($methode === 'PUT') {
        // PUT : remplacement complet
        $dataFinale = $data;
    } else {
        // PATCH : modification partielle
        $dataFinale = array_merge($livre, $data);
    }

    // Ne jamais envoyer l'id dans les données à modifier
    unset($dataFinale['id']);

    // Mise à jour
    if (!$this->model->update($id, $dataFinale)) {
        return $this->failValidationErrors($this->model->errors());
    }

    // Récupérer la ressource mise à jour
    $livreMisAJour = $this->model->find($id);

    return $this->respond($livreMisAJour, 200);
}

    // DELETE /api/livres/{id}
    public function delete($id = null)
    {
        // TODO : 404 si le livre n'existe pas, sinon supprimer.
        //        200 ou 204 ? Choisissez et justifiez en commentaire.
        if ($this->model->find($id) === null) {
            return $this->failNotFound("Livre {$id} introuvable");
        }

        $this->model->delete($id);

        // 204 : suppression réussie, aucune donnée à retourner.
        return $this->respondNoContent();
    }
    }

