<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Traitements
$categorieModel = new CategoryModel();
$categories = $categorieModel->getAllCategories();

$environnement = new Environnement('../app/config.php');

/////////////////////
// STEP #1 : on va chercher les données de l'article pour pré remplir le formulaire

// Validation du paramètre id de l'URL
if (!array_key_exists('idCategory', $_GET) || !$_GET['idCategory']) {

    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}


// On récupère l'id du parcours à afficher depuis la chaîne de requête
$idCategory = $_GET['idCategory'];

// On va chercher la categorie correspondant
$categorie = $categorieModel->getOneCategory($idCategory);
// var_dump([$categorie]);


// On vérifie qu'on a bien récupéré un parcours, sinon => 404
if (!$idCategory) {

    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit; // Si pas de parcours => message d'erreur et on arrête tout !
}

// Initialisation des variables qui vont servir à pré remplir le formulaire
$titleCategory = $categorie['titleCategory'];
$descriptionCategory = $categorie['descriptionCategory'];
$imgCategory = $categorie['imgCategory'];
$markerCategory = $categorie['markerCategory'];
$iconeCategory = $categorie['iconeCategory'];

/////////////////////
// STEP #2 : Traitements des données du formulaire en cas de soumission
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $titleCategory = strip_tags(trim($_POST['titleCategory']));
    // var_dump( $titleCategory );
    $descriptionCategory = strip_tags(trim($_POST['descriptionCategory']));
    // var_dump($descriptionCategory);
    $actifCategory=strip_tags(trim($_POST['actifCategory']));
    // var_dump($actifCategory);

    // On valide les données 
    if (!$titleCategory) {
        $errors['titleCategory'] = 'Le champ "Titre" est obligatoire';
    }

    if (!$descriptionCategory) {
        $errors['descriptionCategory'] = 'Le champ "Description" est obligatoire';
    }

    if ($actifCategory!=0 || $actifCategory!=1 ) {
        $actifCategory=$categorie['actifCategory'];
    }
 // Vérification de l'existence et de l'upload de l'image
 if (isset($_FILES['imgCategory']) && is_uploaded_file($_FILES['imgCategory']['tmp_name'])) {
    // Récupération des informations sur l'image
    $imgCategory_tmp_name = strip_tags(trim($_FILES['imgCategory']['tmp_name']));
    // var_dump($imgCategory_tmp_name);
    // var_dump($imgCategory);
    $imgCategory_name = strip_tags(trim($_FILES['imgCategory']['name']));
    $imgCategory_size = $_FILES['imgCategory']['size'];
    $imgCategory_type = $_FILES['imgCategory']['type'];
    $error = $_FILES['imgCategory']['error'];

    $tabExtension = explode('.', $imgCategory_name);
    $extension = strtolower(end($tabExtension));
    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 400000;


    $path_img="../public/img/categoryimages/";
    // Enregistrement de l'image dans son dossier 
    if(in_array($extension, $extensions ) && $imgCategory_size <= $maxSize && $error == 0){
    move_uploaded_file($imgCategory_tmp_name,  $path_img . $imgCategory_name);
    $imgCategory=$_FILES['imgCategory']['name'];
    }
    else{
        $errors['imgCategory'] = "Une erreur est survenue lors du télechargement de l'image associée au parcours";
    }
    

  }

  // Vérification de l'existence et de l'upload de l'icone
  if (isset($_FILES['iconeCategory']) && is_uploaded_file($_FILES['iconeCategory']['tmp_name'])) {
    // Récupération des informations sur l'icone
    $iconeCategory_tmp_name = strip_tags(trim($_FILES['iconeCategory']['tmp_name']));
    // var_dump($iconeCategory_tmp_name);
    $iconeCategory_name = strip_tags(trim($_FILES['iconeCategory']['name']));
    // var_dump($iconeCategory_name);
    $iconeCategory_size = $_FILES['iconeCategory']['size'];
    // var_dump($iconeCategory_size);
    $iconeCategory_type = $_FILES['iconeCategory']['type'];
    // var_dump($iconeCategory_type);

    $tabExtension = explode('.', $iconeCategory_name);
    $extension = strtolower(end($tabExtension));
    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 400000;


    $path_img="../public/img/iconeCategory/";
    // Enregistrement de l'icone sur le serveur
  if(in_array($extension, $extensions) && $iconeCategory_size <= $maxSize && $error == 0){
    move_uploaded_file($iconeCategory_tmp_name,  $path_img . $iconeCategory_name);
    $iconeCategory=$_FILES['iconeCategory']['name'];
    }
    else{
        $errors['iconeCategory'] = "Une erreur est survenue lors du télechargement de l'icone associée au parcours";
    }

  }

// Vérification de l'existence et de l'upload du marqueur
if (isset($_FILES['markerCategory']) && is_uploaded_file($_FILES['markerCategory']['tmp_name'])) {
    // Récupération des informations sur le marqueur
    $markerCategory_tmp_name = strip_tags(trim($_FILES['markerCategory']['tmp_name']));
    $markerCategory_name = strip_tags(trim($_FILES['markerCategory']['name']));
    $markerCategory_size = $_FILES['markerCategory']['size'];
    $markerCategory_type = $_FILES['markerCategory']['type'];

    $tabExtension = explode('.', $markerCategory_name);
    $extension = strtolower(end($tabExtension));
    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 400000;
    // Enregistrement du marqueur sur le serveur
    $path_img="../public/img/markers/";
    // Enregistrement de l'icone sur le serveur
    if(in_array($extension, $extensions) && $markerCategory_size <= $maxSize && $error == 0){
        move_uploaded_file($markerCategory_tmp_name,  $path_img . $markerCategory_name);
        $markerCategory=$_FILES['markerCategory']['name'];
        }
        else{
            $errors['markerCategory'] = "Une erreur est survenue lors du télechargement du marqueur associé au parcours";
        }
    
  }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {

        // On modifie l'article
        $categorieModel = new CategoryModel();
        $categorie = $categorieModel->editCategory($idCategory,$titleCategory, $descriptionCategory, $imgCategory, $markerCategory,$iconeCategory, $actifCategory);
        // var_dump($imgCategory,$markerCategory,$iconeCategory);

        // On redirige l'internaute (pour l'instant vers une page de confirmation)
        header('Location:'.buildUrl('admin_categories'));
        exit;
    }
}
// Affichage : inclusion du fichier de template
$template = 'admin_editCategory';
include '../templates/baseAdmin.phtml';