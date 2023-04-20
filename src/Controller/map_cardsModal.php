<?php

// Validation du paramètre id de l'URL : si le paramètre n'existe pas, n'a pas de valeur ou a une valeur qui comporte autre chose que des chiffres...
if (!array_key_exists('idPlace', $_GET) || !$_GET['idPlace'] || !ctype_digit($_GET['idPlace'])) {

    // ... on fait une erreur 404 NOT FOUND
    http_response_code(404);
    echo 'Lieu de visite introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}


// On récupère l'id de l'article à afficher depuis la chaîne de requête
$idPlace = (int) $_GET['idPlace'];

$place = $placeModel->getOnePlace($idPlace);

$template = 'map_cardsModal.phtml';

include '../templates/base_map.phtml';