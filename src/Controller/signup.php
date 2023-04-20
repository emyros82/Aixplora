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




// To check if a user is already logged in to your PHP application, we can use the isset() function to check if a session variable that represents the user's login status is set.
// the isset() function is used to check if the $_SESSION["idUser"] variable is set and has a value of true. If this is the case, then the user is considered to be logged in. Otherwise, the user is not logged in.
// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['idUser'])) {
    // Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil
    header('Location: /home.php');
    exit;
}

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $firstnameUser = strip_tags(trim($_POST['firstnameUser']));
    $lastnameUser = strip_tags(trim($_POST['lastnameUser']));
    $emailUser = strip_tags(trim($_POST['emailUser']));
    $passwordUser = strip_tags(trim($_POST['passwordUser']));
    $confirmPasswordUser = strip_tags(trim($_POST['confirmPasswordUser']));

    
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
        header('Location: ' . buildUrl('home'));
        exit;
    }
}

// Inclusion du template
$template = 'signup';
include "../templates/base.phtml";




// class SignupController extends AbstractController {

//     public function signup()
//     {
//         // Si le formulaire est soumis... 
//         if (!empty($_POST)) {

//             // Récupérer les données du formulaire 
//             $firstname = trim($_POST['firstname']);
//             $lastname = trim($_POST['lastname']);
//             $email = trim($_POST['email']);
//             $password = $_POST['password'];

//             // Création d'un objet UserModel
//             $userModel = new UserModel();

//             // Valider les données du formulaire
//             $errors = [];

//             if (!$firstname){
//                 $errors[] = 'Le champ "Prénom" est obligatoire';
//             }

//             if (!$lastname){
//                 $errors[] = 'Le champ "Nom" est obligatoire';
//             }

//             if (!$email){
//                 $errors[] = 'Le champ "Email" est obligatoire';
//             } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//                 $errors[] =  "\"$email\" n'est pas un email valide";
//             } 

//             if (strlen($password) < 8) {
//                 $errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
//             }

//             // Si tout est ok... 
//             if (empty($errors)) {    

//                 // Hashage du mot de passe
//                 $hash = password_hash($password, PASSWORD_DEFAULT);

//                 try {

//                     // ...on insert les données dans la base
//                     $userModel->createUser($firstname, $lastname, $email, $hash); 

//                     // Message flash de confirmation 
//                     $this->addFlash('Votre compte a bien été créé, vous pouvez vous connecter !');

//                     // Redirection vers la page de connexion
//                     header('Location: ' . url('/login'));
//                     exit;
//                 }
//                 catch(UserAlreadyExistsException $exception) {
//                     $errors[] = $exception->getMessage();
//                 }
//             }
//         }

//         // Affichage : inclusion du fichier de template
//         $template = 'signup'; 
//         require '../templates/base.phtml';
//     }
// }