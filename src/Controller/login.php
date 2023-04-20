<?php //MODIFIER MOI
 //require('../src/Model/UserModel.php');

// je ne devrais pas être ici si je suis connecté
// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['idUser'])) {
    //Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil
    header('Location: /home.php');
    exit;
  }

// Initialisations
$emailUser = '';
$passwordUser =''; 
//A VOIR S'IL FAUT PAS LE METTRE EN COMMENTAIRE?

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $emailUser = $_POST['emailUser'];
    $passwordUser = $_POST['passwordUser'];

    //on créé un nouveau objet de la classe Session en le stockant dans la variable $user
//    $user = new Session();//ORIGINALE CODE
    $userSession = new Session();
    
    // On vérifie les identifiants
//    $user->checkUser($emailUser, $passwordUser);//ORIGINALE CODE
    $user = $userSession->checkUser($emailUser, $passwordUser);
    
   

    // On a trouvé l'utilisateur, les identifiants sont corrects...
    if ($user) {

        // Enregistrement de l' user en session
//        $user->registerUser('idUser', 'firstnameUser', 'lastnameUser', 'emailUser','roleUser');//ORIGINALE CODE QUI MARCHE$$$$$$$$$$$$$$$$$$$
        $user = $userSession->registerUser($user['idUser'], $user['firstnameUser'], $user['lastnameUser'], $user['emailUser'],$user['roleUser']);
//        $user = $userSession->registerUser('idUser', 'firstnameUser', 'lastnameUser', 'emailUser','roleUser');
        var_dump($user);
    
        // Redirection pour le moment vers la page d'accueil du site
         header('Location: ' . buildUrl('home'));
         exit;

       
    } 
        
    $error = 'Identifiants incorrects';
}

// Inclusion du template
$template = 'login';
include "../templates/base.phtml";

