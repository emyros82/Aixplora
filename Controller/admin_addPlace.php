<?php
// Vérification du rôle, seulement l'ADMIN a le droit de  sinon renvoie une erreur 403 et redirige l'utilisateur vers une page d'erreur.
// acceder à cette page
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Initialisations tableau $errors
$errors = [];
// instance de la classe CategoryModel 
$categoryModel = new CategoryModel();
// on fait appel à la méthode getAllCategories () 
$categories = $categoryModel->getAllCategories();


// Si le formulaire est soumis...
if (!empty($_POST)) {
    // On récupère les données du formulaire la méthode $_POST
    // la fonction htmlspecialchars pour nettoyer les données et éviter les attaques XSS. La fonction strip_tags est utilisée pour supprimer toutes les balises HTML et PHP des données. La fonction trim est utilisée pour supprimer les espaces en début et fin de chaîne.
    $titlePlace = htmlspecialchars(strip_tags(trim($_POST['titlePlace'])));
    $adressPlace = htmlspecialchars(strip_tags(trim($_POST['adressPlace'])));
    $abstractPlace = htmlspecialchars(strip_tags(trim($_POST['abstractPlace'])));
    $descriptionPlace = htmlspecialchars(strip_tags(trim($_POST['descriptionPlace']))); 
    $longPlace = htmlspecialchars(strip_tags(trim($_POST['longPlace']))); 
    $latPlace =htmlspecialchars(strip_tags(trim($_POST['latPlace']))); 
    $actifPlace = htmlspecialchars(strip_tags(trim($_POST['actifPlace'])));
    $selectedCategories= array_map(function($value) {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $value = strip_tags($value);
        $value = intval($value);
        return $value;
    }, $_POST['category']);
   
    //Si une des données obligatoires est manquante, une erreur est ajoutée à la variable $errors qui contient toutes les erreurs rencontrées lors de la validation du formulaire.
    if (!$titlePlace) {
        $errors['titlePlace'] = 'Le champ "Titre" est obligatoire';
    }

    if (!$adressPlace) {
        $errors['adressPlace'] = 'Le champ "Adresse" est obligatoire';
    }
    if (!$abstractPlace) {
        $errors['abstractPlace'] = 'Le champ "Résumé" est obligatoire';
    }
    if (!$descriptionPlace) {
        $errors['descriptionPlace'] = 'Le champ "Description" est obligatoire';
    }
    if (!$longPlace) {
        $errors['longPlace'] = 'Le champ "Longitude" est obligatoire';
    }
    if (!$latPlace) {
        $errors['latPlace'] = 'Le champ "Latitude" est obligatoire';
    }
    if ($actifPlace!=0  && $actifPlace!=1) {
        $errors['actifPlace'] = 'Le champ "Visibilité" est obligatoire';
    }
    if (!$selectedCategories) {
        $errors['category'] = 'Le champ "Categorie associée" est obligatoire';
    }


 // Vérification de l'existence et de l'upload de l'image
 if (isset($_FILES['imagePlace']) && is_uploaded_file($_FILES['imagePlace']['tmp_name'])) {
    // Récupération des informations sur l'image
    $imagePlace_tmp_name = strip_tags(trim($_FILES['imagePlace']['tmp_name']));
    $imagePlace_name = strip_tags(trim($_FILES['imagePlace']['name']));
    $imagePlace_size = $_FILES['imagePlace']['size'];
    $imagePlace_type = $_FILES['imagePlace']['type'];
    $error = $_FILES['imagePlace']['error'];

    $tabExtension = explode('.', $imagePlace_name);
    $extension = strtolower(end($tabExtension));
    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 400000;


    $path_img="../public/img/imagePlace/";
    // Enregistrement de l'image dans son dossier 
    if(in_array($extension, $extensions) && $imagePlace_size <= $maxSize && $error == 0){
    move_uploaded_file($imagePlace_tmp_name,  $path_img . $imagePlace_name);
    }
    else{
        echo "Une erreur est survenue lors du télechargement de l'image associée au lieu de visite";
    }
    
  }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {
        //Instance de la classe PlaceModel()
        $placeModel = new PlaceModel();
//Appel à la méthode addPlace 
        $places= $placeModel->addPlace(
            $titlePlace,
            $adressPlace,
            $abstractPlace,
            $descriptionPlace,
            $longPlace,
            $latPlace,
            $imagePlace_name ,
            $actifPlace,
            $selectedCategories
        );

        // On redirige l'admin vers la page des lieux 
         header('Location:' . buildUrl('admin_places'));
//        exit();
    }

    
}

// Inclusion du template
$template = 'admin_addPlace';
include '../templates/base.phtml';
