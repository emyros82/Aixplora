<?php
// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Validation et récupération de l'id du lieu de visite à supprimer dans l'URL
if (!array_key_exists('idPlace', $_GET) || !$_GET['idPlace']) {
    http_response_code(404);
   header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'id dans l'URL => message d'erreur et on arrête tout !
}

// On récupère l'id du lieu à afficher depuis la chaîne de requête
$idPlace = $_GET['idPlace'];

// On va chercher le lieu de visite correspondant
$placeModel = new PlaceModel();
$place = $placeModel->getOnePlace($idPlace);

// On vérifie qu'on a bien récupéré un lieu de visite, sinon => 404
if (!$place) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas de lieu de visite => message d'erreur et on arrête tout !
}

// Suppression du Lieu de visite 
$delete = $placeModel->deletePlace($idPlace);

// On retourne l'id du lieu de visite qui a été supprimé en JSON
echo json_encode(['idPlace' => $idPlace]);
exit();
