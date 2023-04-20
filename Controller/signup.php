<?php 
// tester tous les cas d’erreurs et d’ajouter des messages d’erreurs dans une variable au fur-et-à-mesure. 
// Initialisations d'un tableau $erreurs  vide
$errors = [];
// Initialisations des variables correspondantes aux données que l'on veut recuperer du formulaire
$firstnameUser = '';
$lastnameUser = '';
$emailUser = '';
$userModel = new UserModel();
$getEmail = $userModel->getUserByEmail($emailUser);

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['idUser'])) {
    // Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil
    header('Location: /home.php');
    exit;
}

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $firstnameUser = htmlspecialchars(strip_tags(trim($_POST['firstnameUser'])));
    $lastnameUser = htmlspecialchars(strip_tags(trim($_POST['lastnameUser'])));
    $emailUser = htmlspecialchars(strip_tags(trim($_POST['emailUser'])));
    $passwordUser = htmlspecialchars(strip_tags(trim($_POST['passwordUser'])));
    $confirmPasswordUser = htmlspecialchars(strip_tags(trim($_POST['confirmPasswordUser'])));

    
    // On valide les données (tous les champs sont obligatoires)
    if (!strlen($firstnameUser)) {
        $errors['firstnameUser'] = 'Le champ "Prénom" est obligatoire';
    }

    if (!strlen($lastnameUser)) {
        $errors['lastnameUser'] = 'Le champ "Nom" est obligatoire';
    }

    if (!strlen($emailUser)) {
        $errors['emailUser'] = 'Le champ "Email" est obligatoire';
    }
    elseif (!filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
        $errors['emailUser'] = 'Email invalide';
    }
    elseif ($userModel->getUserByEmail($emailUser)) {
        $errors['emailUser'] = 'Un compte existe déjà avec cet email';
    }

    if (strlen($passwordUser) < 8) {
        $errors['passwordUser'] = 'Le mot de passe doit comporter au moins 8 caractères';
    }
  

    elseif ($passwordUser != $confirmPasswordUser) {
        $errors['confirmPasswordUser'] = 'Le mot de passe de confirmation ne correspond pas';
    }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {

        // Hashage du mot de passe
        $hashPassUser = password_hash($passwordUser, PASSWORD_DEFAULT);

        // On enregistre le user
        $users = $userModel->addUser($firstnameUser, $lastnameUser, $emailUser,$hashPassUser/*, 'USER' CA PAS BESOIN*/);
        
        // On redirige l'internaute (pour l'instant vers une page de confirmation)
        header('Location: ' . buildUrl('login'));
        exit;
    }
}

// Inclusion du template
$template = 'signup';
include "../templates/base.phtml";
