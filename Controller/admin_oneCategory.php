<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}
//////////////////////////////////////////////////////////////////////////
// Récupération de l'id de la categorie (parcours) dans l'URL           //
//////////////////////////////////////////////////////////////////////////

// Validation du paramètre id de l'URL : si le paramètre n'existe pas, n'a pas de valeur ou a une valeur qui comporte autre chose que des chiffres...
if (!array_key_exists('idCategory', $_GET) || !$_GET['idCategory'] || !ctype_digit($_GET['idCategory'])) {

    // ... on fait une erreur 404 NOT FOUND
    http_response_code(404);
    echo 'Parcours introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}


// On récupère l'id de l'article à afficher depuis la chaîne de requête
$idCategory = (int) $_GET['idCategory'];





// Création d'un nouveau objet CategoryModel
$categoryModel = new CategoryModel();

////////////////////////////////////////////////
// Affichage de la categorie (parcours)
////////////////////////////////////////////////

$category = $categoryModel->getOneCategory($idCategory);

// Affichage : inclusion du fichier de template
$template = 'admin_oneCategory';
include '../templates/baseAdmin.phtml';