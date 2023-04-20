<?php
// Vérification du rôle, seulement l'ADMIN a le droit de 
// acceder à cette page
//Le code commence par vérifier si l'utilisateur qui tente d'accéder à la page a le rôle "administrateur". Si ce n'est pas le cas, l'utilisateur sera redirigé vers une page d'erreur 403.

if (!Session::hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    header('Location:' . buildUrl('page403'));
    exit();
}

// Initialisations  une variable $errors[], qui sera utilisée pour stocker les erreurs éventuelles rencontrées lors de la validation des données du formulaire.
$errors = [];


// Si le formulaire est soumis...
if (!empty($_POST)) {

// On récupère les autres données du formulaire à l'aide de la méthode $_POST
    $titleCategory = strip_tags(trim($_POST['titleCategory']));
    $descriptionCategory = strip_tags(trim($_POST['descriptionCategory']));
    $actifCategory = strip_tags(trim($_POST['actifCategory']));

// Si des champs obligatoires sont manquants, des messages d'erreur sont stockés dans la variable $errors.
    if (!$titleCategory) {
        $errors['titleCategory'] = 'Le champ "Titre" est obligatoire';
    }

    if (!$descriptionCategory) {
        $errors['descriptionCategory'] = 'Le champ "Description" est obligatoire';
    }

    if (!$actifCategory) {
        $errors['actifCategory'] = 'Le champ "Visibilité" est obligatoire';
    }


    // Vérification de l'existence et de l'upload de l'image
    if (isset($_FILES['imgCategory']) && is_uploaded_file($_FILES['imgCategory']['tmp_name'])) {
        // Récupération des informations sur l'image
        $imgCategory_tmp_name = strip_tags(trim($_FILES['imgCategory']['tmp_name']));
        $imgCategory_name = strip_tags(trim($_FILES['imgCategory']['name']));
        $imgCategory_size = $_FILES['imgCategory']['size'];
        $imgCategory_type = $_FILES['imgCategory']['type'];
        $error = $_FILES['imgCategory']['error'];

        $tabExtension = explode('.', $imgCategory_name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $maxSize = 400000;


        $path_img = "../public/img/categoryimages/";
        // Enregistrement de l'image dans son dossier
        if (in_array($extension, $extensions) && $imgCategory_size <= $maxSize && $error == 0) {
            $newImgCategory_name = uniqid() . '.' . $extension;
        move_uploaded_file($imgCategory_tmp_name,  $path_img . $newImgCategory_name );
        } else {
            echo "Une erreur est survenue lors du télechargement de l'image associée au parcours";
        }

    }

    // Vérification de l'existence et de l'upload de l'icone
    if (isset($_FILES['iconeCategory']) && is_uploaded_file($_FILES['iconeCategory']['tmp_name'])) {
        // Récupération des informations sur l'icone
        $iconeCategory_tmp_name = strip_tags(trim($_FILES['iconeCategory']['tmp_name']));
        $iconeCategory_name = strip_tags(trim($_FILES['iconeCategory']['name']));
        $iconeCategory_size = $_FILES['iconeCategory']['size'];
        $iconeCategory_type = $_FILES['iconeCategory']['type'];

        $tabExtension = explode('.', $iconeCategory_name);
        $extension = strtolower(end($tabExtension));
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $maxSize = 400000;


        $path_img = "../public/img/iconeCategory/";
        // Enregistrement de l'icone sur le serveur
        if (in_array($extension, $extensions) && $iconeCategory_size <= $maxSize && $error == 0) {
            $newIconeCategory_name = uniqid() . '.' . $extension;
            move_uploaded_file($iconeCategory_tmp_name,  $path_img . $newIconeCategory_name);
        } else {
            echo "Une erreur est survenue lors du télechargement de l'icone associée au parcours";
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
        $path_img = "../public/img/markers/";
        // Enregistrement de l'icone sur le serveur
        if (in_array($extension, $extensions) && $markerCategory_size <= $maxSize && $error == 0) {
            $newMarkerCategory_name = uniqid() . '.' . $extension;
        move_uploaded_file($markerCategory_tmp_name,  $path_img . $newMarkerCategory_name);
        } else {
            echo "Une erreur est survenue lors du télechargement du marqueur associé au parcours";
        }

    }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {
        //on créé un nouveau objet de la classe CategoryModel 
        $categoryModel = new CategoryModel();
        // On enregistre le parcours méthode addCategory
        $categories = $categoryModel->addCategory(
            $titleCategory,
            $descriptionCategory,
            $newImgCategory_name,
            $newMarkerCategory_name,
            $newIconeCategory_name,
            $actifCategory
        );

        // On redirige l'administrateur sur la page des categories 
        header('Location:' . buildUrl('admin_categories'));
        exit();
    }
}

// Inclusion du template
$template = 'admin_addCategory';
include '../templates/baseAdmin.phtml';
