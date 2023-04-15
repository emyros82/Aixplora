<?php

// //  Si il y a un problème avec l'id de l'user...
//  if ( !array_key_exists('idUser', $_GET) 
//  || !isset($_GET['idUser']) 
//  || !ctype_digit($_GET['idUser'])
// ) {
//  return false;
// }
// On récupère l'id de l'user à afficher depuis la chaîne de requête


// Traitements : récuperation de l'id
$session = new Session();
// var_dump($userModel);
$profile = $session->getUserId();

$profileFirstname = $session->getUserFirstname();
// var_dump($profile);
// var_dump(Session::getUserFirstname());
$profileLastname = $session->getUserLastname();
// var_dump($_SESSION['users']);
$profileEmail = $session->getUserEmail();


$template = 'profileUser';

include '../templates/base.phtml';