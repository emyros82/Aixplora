<?php
//   $placeModel = new PlaceModel();
//   $places = $placeModel->getAllPlaces();
// var_dump($places);
// print_r($places);
// echo $places;
// Traitements : récupérer les category
$session = new Session();
$userSessionName = $session->getUserFirstname();

$userSessionHasRole = $session-> getUserRole();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();


  $template = 'map';
  
  include '../templates/baseMap.phtml';