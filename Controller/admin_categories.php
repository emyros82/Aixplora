<?php

// Vérification du rôle "admin" en utilisant la méthode statique "hasRole()" de la classe Session. Si l'utilisateur n'a pas ce rôle, la réponse HTTP 403 (interdit) est renvoyée, l'utilisateur est redirigé vers la page 403 et le script est terminé avec la fonction "exit()".
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

//  instance de la classe "CategoryModel"
$categoryModel = new CategoryModel();
//récupérer toutes les catégories à partir de la base de données en utilisant la méthode "getAllCategories()"
$categories = $categoryModel->getAllCategories();

$template = 'admin_categories';

include '../templates/baseAdmin.phtml';

