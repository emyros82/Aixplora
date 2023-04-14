<?php
// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Validation et récupération de l'id de la category à supprimer dans l'URL
if (!array_key_exists('idCategory', $_GET) || !$_GET['idCategory']) {
    http_response_code(404);
   header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'id dans l'URL => message d'erreur et on arrête tout !
}

// On récupère l'id de la category à afficher depuis la chaîne de requête
$idCategory = $_GET['idCategory'];

// On va chercher de la category  correspondant
$categoryModel = new CategoryModel();
$place = $categoryModel->getOneCategory($idCategory);

// On vérifie qu'on a bien récupéré une category, sinon => 404
if (!$place) {
    http_response_code(404);
    header('Location:'.buildUrl('admin_categories'));
    exit(); // Si pas de lieu de visite => message d'erreur et on arrête tout !
}

// Suppression de la category
$delete = $categoryModel->deleteCategory($idCategory);

// On retourne l'id de la category qui a été supprimé en JSON
// echo json_encode(['idCategory' => $idCategory]);
// Redirection vers le dashboard admin
header('Location:'.buildUrl('admin_categories'));
exit();
