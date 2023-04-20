<?php


// Traitements : récupérer les category
$session = new Session();
$userSessionName = $session->getUserFirstname();

$userSessionHasRole = $session-> getUserRole();

//var_dump(Database::getCountPDO());

// Affichage : inclusion du template
// require_once '../src/Core/Environnement.php';

$template = 'base';

include '../templates/base.phtml';