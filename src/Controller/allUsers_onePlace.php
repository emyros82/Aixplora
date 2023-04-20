<?php

// Vérification du rôle
// if (!Session::hasRole(ROLE_ADMIN)) {
//     http_response_code(403);
//     header('Location:' . buildUrl('page403'));
//     exit();
// }
//////////////////////////////////////////////////////////////////////////
// Récupération de l'id du lieux de visite dans l'URL                   //
//////////////////////////////////////////////////////////////////////////

// Validation du paramètre id de l'URL : si le paramètre n'existe pas, n'a pas de valeur ou a une valeur qui comporte autre chose que des chiffres...
if (!array_key_exists('idPlace', $_GET) || !$_GET['idPlace'] || !ctype_digit($_GET['idPlace'])) {

    // ... on fait une erreur 404 NOT FOUND
    http_response_code(404);
    echo 'Lieu de visite introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}


// On récupère l'id de l'article à afficher depuis la chaîne de requête
$idPlace = (int) $_GET['idPlace'];





// Création d'un nouveau objet PlaceModel
$placeModel = new PlaceModel();

////////////////////////////////////////////////
// Affichage de la categorie (parcours)
////////////////////////////////////////////////

$place = $placeModel->getOnePlace($idPlace);

// Affichage : inclusion du fichier de template
$template = 'allUsers_onePlace';
include '../templates/base.phtml';