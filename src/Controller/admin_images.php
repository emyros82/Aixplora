<?php
// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Traitements : récupérer les category
$imageModel = new ImageModel();
$images = $imageModel->getAllImages();

//var_dump(Database::getCountPDO());

// Affichage : inclusion du template
// require_once '../src/Core/Environnement.php';

$template = 'admin_images';

include '../templates/base.phtml';
