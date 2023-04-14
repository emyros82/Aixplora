<?php
// Traitements : récupérer les category
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();
//var_dump($categories);
//var_dump(Database::getCountPDO());

// Affichage : inclusion du template
// require_once '../src/Core/Environnement.php';

$template = 'home';

include '../templates/base.phtml';


// class HomeController extends AbstractController {

//     /**
//      * Action responsable de l'affichage de la page d'accueil
//      */
//     public function index()
//     {
//         // Récupérer des données dans la BDD
//         $categoryModel = new CategoryModel();
//         $categories = $categoryModel->getAllCategories();
//         // Affichage : inclusion du fichier de template
//         $template = 'home';
//         include '../templates/base.phtml';
//         ]);
//     }

// }