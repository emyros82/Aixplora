<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
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
