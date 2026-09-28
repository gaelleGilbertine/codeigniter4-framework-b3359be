<?php

/**
 * À ajouter dans app/Config/Routes.php (après la route par défaut).
 */

// Étape A : endpoint écrit à la main
$routes->get('api/manuel/livres/(:num)', 'Api\LivresManuel::show/$1');

// Étape B : la ressource complète (new et edit servent des formulaires HTML, inutiles pour une API)
$routes->resource('api/livres', ['except' => 'new,edit']);
