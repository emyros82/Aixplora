<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Traitements : récupérer les category
$placeModel = new placeModel();
$places = $placeModel->getAllPlaces();

//var_dump(Database::getCountPDO());

// Affichage : inclusion du template
// require_once '../src/Core/Environnement.php';

$template = 'admin_places';

include '../templates/base.phtml';
