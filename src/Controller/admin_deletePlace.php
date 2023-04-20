<?php
// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Validation et récupération de l'id du lieu à supprimer dans l'URL
if (!array_key_exists('idPlace', $_GET) || !$_GET['idPlace']) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'id dans l'URL => message d'erreur et on arrête tout !
}

// On récupère l'id du lieu à afficher depuis la chaîne de requête
$idPlace = $_GET['idPlace'];

$placeModel= new PlaceModel();
// On va chercher le lieu correspondant
$place = $placeModel->getOnePlace($idPlace);

// On vérifie qu'on a bien récupéré un article, sinon => 404
if (!$place) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'article => message d'erreur et on arrête tout !
}

// Suppression de le lieu
$placeModel->deletePlace($idPlace);

// Redirection vers le dashboard admin
// header('Location: admin.php');
header('Location:' . buildUrl('admin'));
exit();
