<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Traitements : récupérer les lieux
$placeModel = new PlaceModel();
$places = $placeModel->getAllPlaces();

// Traitements : récupérer les categories
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

// Affichage : inclusion du fichier de template
$template = 'admin';
include '../templates/baseAdmin.phtml';
