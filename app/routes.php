<?php
// Ce fichier va servir à associer la clef de la page avec le controller ex: 'home' = 'home.php'.
$routes=[
    'home' => 'home.php',
    'admin_addPlace' => 'admin_addPlace.php',
    'admin_addCategory' => 'admin_addCategory.php',
    'admin_addImage' => 'admin_addImage.php',
    'admin' => 'admin.php',
    'admin_categories' => 'admin_categories.php',
    'admin_places' => 'admin_places.php',
    'admin_images' => 'admin_images.php',
    'admin_deletePlace' => 'admin_deletePlace.php',
    'admin_deletePlaceAjax' => 'admin_deletePlaceAjax.php',
    'admin_deleteCategory' => 'admin_deleteCategory.php',
    'admin_deleteCategoryAjax' => 'admin_deleteCategoryAjax.php',
    'admin_editPlace' => 'admin_editPlace.php',
    'admin_editCategory' => 'admin_editCategory.php',
    'admin_oneCategory' => 'admin_oneCategory.php',
    'admin_onePlace' => 'admin_onePlace.php',
    'login' => 'login.php',
    'logout' => 'logout.php',
    'signup' => 'signup.php',
    'map' => 'baseMap.php', 
    'profileUser' => 'profileUser.php',
    'page404'=> 'page404.php',
    'page403'=> 'page403.php',
    ];
return $routes; // En général on ne fait des return qu'en fin de fonction. Ici, c'est un cas particulier.