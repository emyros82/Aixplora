<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// On récupère l'id de la category 
$idCategory = (int) $_GET['idCategory'];
// Traitements : récupérer les category
$placeModel = new placeModel();
$places = $placeModel->getAllPlacesByCategories();

//var_dump(Database::getCountPDO());
// Affichage : inclusion du template
// require_once '../src/Core/Environnement.php';

$template = 'admin_placesByCategory';

include '../templates/base.phtml';