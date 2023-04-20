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

//instance de la classe Environnement en paramètre le chemin relatif vers le fichier de configuration de l'application config.php.
// En créant une instance de la classe Environnement et en passant le fichier config.php en paramètre, le constructeur de la classe lit les constantes définies dans le fichier et les stocke dans un objet. Cet objet peut alors être utilisé dans l'ensemble de l'application pour accéder à ces paramètres de configuration.

$env = new Environnement('../app/config.php');

//instance de la classe Session 
$session = new Session();

//la variable $userSession stocke l'état de la connexion de l'utilisateur en appelant la méthode isConnected() de l'objet Session précédemment instancié.
$userSession=$session->isConnected();

//////////////////////////////////
///////////// ROUTING ////////////
//////////////////////////////////

// Inclusion du fichier de routes
$routes = include '../app/routes.php';


//Récuperation de la page demandée par l'utilisateur à partir de l'URL en utilisant l'opérateur de fusion NULL pour fournir une valeur par défaut 'home' si le paramètre 'page' est manquant dans l'URL.
$page = $_GET['page'] ?? 'home';
//$url = $_SERVER['REDIRECT_URL'];
//$page = $env->getUrl($url);
//if(!isset($page) || $page == '') {
//    $page = 'home';
//}
// Routing : appeler un contrôleur spécifique à la page qu'on souhaite afficher en fonction de l'information contenue dans l'URL

//Le routage est géré avec une structure de contrôle conditionnelle :

//Si la page demandée n'existe pas dans la liste des routes définies, l'application renvoie une erreur 404.

if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit;
}

//Sinon, le contrôleur correspondant à la page demandée est appelé en incluant le fichier de contrôleur correspondant, et il se charge d'afficher la page demandée.
// On va chercher le contrôleur associé à la page
$controllerFile = $routes[$page];
include '../Controller/' . $controllerFile;

