<?php

// Vérification du rôle
if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}
// Traitements

/////////////////////
// STEP #1 : on va chercher les données du lieu pour pré remplir le formulaire

// Validation du paramètre id de l'URL
if (!array_key_exists('idPlace', $_GET) || !$_GET['idPlace']) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas d'id dans l'URL => message d'erreur et on arrête tout !
}

// On récupère l'id du lieu à afficher depuis la chaîne de requête
$idPlace = $_GET['idPlace'];
// var_dump([$idPlace]);
// var_dump([$_POST]);

// On va chercher le lieu de visite correspondant
$placeModel = new PlaceModel();
$place = $placeModel->getOnePlace($idPlace);
// var_dump([$place]);

// On vérifie qu'on a bien récupéré un lieu de visite, sinon => 404
if (!$place) {
    http_response_code(404);
    header('Location:' . buildUrl('page404'));
    exit(); // Si pas de lieu de visite=> message d'erreur et on arrête tout !
}

// Initialisation des variables qui vont servir à pré remplir le formulaire
$titlePlace = $place['titlePlace'];
$adressPlace = $place['adressPlace'];
$abstractPlace = $place['abstractPlace']; 
$descriptionPlace = $place['descriptionPlace']; 
$longPlace = $place['longPlace']; 
$latPlace = $place ['latPlace']; 
$imagePlace = $place ['imagePlace']; 
$actifPlace = $place['actifPlace']; 
 

/////////////////////
// STEP #2 : Traitements des données du formulaire en cas de soumission
if (!empty($_POST)) {
    // On récupère les données du formulaire
    $titlePlace = strip_tags(trim($_POST['titlePlace']));
    $adressPlace = strip_tags(trim($_POST['adressPlace']));
    $abstractPlace = strip_tags(trim($_POST['abstractPlace'])); 
    $descriptionPlace = strip_tags(trim($_POST['descriptionPlace'])); 
    $longPlace = strip_tags(trim($_POST['longPlace'])); 
    $latPlace = strip_tags(trim($_POST['latPlace'])); 
    $actifPlace = strip_tags(trim($_POST['actifPlace']));

   

    // On valide les données (tous les champs sont obligatoires)
    if (!$titlePlace) {
        $errors['titlePlace'] = 'Le champ "Titre" est obligatoire';
    }

    if (!$adressPlace) {
        $errors['adressPlace'] = 'Le champ "Adresse postale" est obligatoire';
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
//    if (!$imagePlace) {
//        $errors['imagePlace'] = 'Le champ "Image" est obligatoire';
//    }
    if (!$actifPlace) {
        $errors['actifPlace'] = 'Le champ "Visibilité" est obligatoire';
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


        $path_img = "../public/img/imagePlace/";
        // Enregistrement de l'image dans son dossier
        if (in_array($extension, $extensions) && $imagePlace_size <= $maxSize && $error == 0){
            $newImageName = uniqid() . '.' . $extension;
            move_uploaded_file($imagePlace_tmp_name,  $path_img . $newImageName);
        } else {
            echo "Une erreur est survenue lors du télechargement de l'image associée au lieu de visite";
        }


    }
    // var_dump($imagePlace);
   

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {
        // On modifie l'article
        $placeModel = new PlaceModel();
        $place = $placeModel->editPlace(
            $titlePlace,
            $adressPlace,
            $abstractPlace,
            $descriptionPlace,
            $longPlace,
            $latPlace,
            $newImageName,
            $actifPlace,
            $idPlace,
        );

        // On redirige l'internaute (pour l'instant vers une page de confirmation)
        // header('Location: admin.php');
        header('Location:' . buildUrl('admin_places'));
        exit();
    }
}
// Affichage : inclusion du fichier de template
$template = 'admin_editPlace';
include '../templates/baseAdmin.phtml';
