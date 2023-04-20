<?php
// Headers requis

// en-tête HTTP pour autoriser les requêtes provenant de n'importe quelle origine (CORS).
header("Access-Control-Allow-Origin: *");
// en-tête HTTP pour spécifier que la réponse est en format JSON.
header("Content-Type: application/json; charset=UTF-8");
// en-tête HTTP pour autoriser uniquement les requêtes de type GET (CORS).
header("Access-Control-Allow-Methods: GET");
// en-tête HTTP pour spécifier la durée pendant laquelle les en-têtes de requête peuvent être mises en cache (CORS).
header("Access-Control-Max-Age: 3600");
// en-tête HTTP pour autoriser les en-têtes de requête spécifiques (CORS).
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte = GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    include_once '../app/config.php';
    include_once '../src/Core/Environnement.php';
    include_once '../src/Core/Database.php';
    include_once '../src/Core/AbstractController.php';
    include_once '../src/Core/AbstractModel.php';
    include_once '../src/Model/CategoryModel.php';
    include_once '../src/Model/PlaceModel.php';

    $categoryModel = new CategoryModel();
    $categories = $categoryModel->getAllCategories();

    $placeModel = new PlaceModel();
    $places = $placeModel->getAllPlacesWithCategories();


    // On envoie le code réponse 200 OK
    http_response_code(200);

    // On encode en json et on envoie
    echo json_encode($places);
}
