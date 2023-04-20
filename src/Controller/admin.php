<?php

//  require '../src/Core/Environnement.php';
// $env = new Environnement('../app/config.php');


// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// var_dump(UserModel::hasRole(ROLE_ADMIN));



// Traitements : récupérer les lieux
$placeModel = new PlaceModel();
$places = $placeModel->getAllPlaces();

// Traitements : récupérer les categories
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

// Affichage : inclusion du fichier de template
$template = 'admin';
// $script = $env->getPathScript('admin.js');
include '../templates/base.phtml';
