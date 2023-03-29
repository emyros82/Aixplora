<?php
// On démarre la session pour être certain qu'elle est démarrée
session_start();

// Inclusion du fichier d'autoload de composer
require '../vendor/autoload.php';

// Inclusion des dépendances
include '../lib/functions.php';
include '../app/config.php';
include '../app/routes.php';
include '../src/Core/Environnement.php';
include '../src/Core/Database.php';
include '../src/Core/AbstractController.php';
include '../src/Core/AbstractModel.php';
include '../src/Core/AbstractSession.php';
include '../src/Model/CategoryModel.php';
include '../src/Model/PlaceModel.php';
include '../src/Model/ImageModel.php';
include '../src/Model/UserModel.php';
include '../src/Session/Session.php';
// include '../Controller/signup.php';
// include '../Controller/logout.php';
// include '../Controller/login.php';
// include '../Controller/home.php';
// include '../Controller/edit_place.php';
// include '../Controller/delete_place_ajax.php';
// include '../Controller/delete_place.php';
// include '../Controller/delete_category.php';
// include '../Controller/admin.php';
// include '../Controller/add_place.php';
// include '../Controller/add_category.php';



$env = new Environnement('../app/config.php');

$session = new Session();
$userSession=$session->getSessionStart();

//////////////////////////////////
///////////// ROUTING

// Inclusion du fichier de routes
$routes = include '../app/routes.php';

// // On initialise une variable $page avec une valeur par défaut 'home'
// $page = 'home';

// // On regarde si dans l'URL (dans la chaîne de requête) il existe un paramètre 'page' 
// if (isset($_GET['page'])) {
//     $page = $_GET['page'];
// }

// On peut écrire les 3 lignes ci-dessus de la manière suivante :
$page = $_GET['page'] ?? 'home'; // ?? est l'opérateur de fusion NULL : https://www.php.net/manual/fr/language.operators.comparison.php

// Routing : appeler un contrôleur spécifique à la page qu'on souhaite afficher en fonction de l'information contenue dans l'URL

// Si la page n'existe pas on fait une erreur 404
if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    echo 'Page introuvable';
    exit;
}

// On va chercher le contrôleur associé à la page
$controllerFile = $routes[$page];
include '../Controller/' . $controllerFile;
