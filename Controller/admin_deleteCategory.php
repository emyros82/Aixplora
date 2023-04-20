<?php
// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// On récupère l'id du lieu à afficher depuis la chaîne de requête
$idCategory = $_GET['idCategory'];


// Validation et récupération de l'id de la categorie à supprimer dans l'URL
if (!array_key_exists('idCategory', $_GET) || !$_GET['idCategory']) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'id dans l'URL => message d'erreur et on arrête tout !
}


$categoryModel= new CategoryModel;
// On va chercher la category correspondante
$category = $categoryModel->getOneCategory($idCategory);

// On vérifie qu'on a bien récupéré la category, sinon => 404
if (!$category) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'article => message d'erreur et on arrête tout !
}

// Suppression de la category

$categoryModel->deleteCategory($idCategory);

// Redirection vers le dashboard admin
header('Location:'.buildUrl('admin_categories'));
exit();
