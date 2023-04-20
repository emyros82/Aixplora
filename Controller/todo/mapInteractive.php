<?php
// Traitements : récupérer les categories
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();

// Traitements : récupérer les lieux de visites
$placeModel = new PlaceModel();
$places = $placeModel->getAllPlaces();


// Convertir $places en chaîne de caractères JSON et l'afficher
echo json_encode($places);

// Headers requis


//On va aller effectuer la lecture des lieux et les renvoyer à l utilisateur 
// Headers requis necessaires pour effectuer des controls ou pour faire des autorisations

//header("Access-Control-Allow-Origin: *"); permet d'autoriser ou pas l'accès à l'API en fonction de l'origin de l'utilisateurs 
//imaginons que l'on souhaite faire un APi qui puisse être exploitée seulement par le un site specifique 
//à la place de l'* on va mettre l'url du site. Donc l'api ne repondra que si la requete viendra
//de ce site. Ave l* l'api est entierement publique et il n y a aucun filtrage


// header("Access-Control-Allow-Origin: *");


//header("Content-Type: application/json; charset=UTF-8"); il va nous donner la possibilité de definir le contenu 
//de la reponse, dans ce cas on a une reponse de type JSON => Le type JSON perlmet de repondre à la norme 
//API REST de repondre à n'importe quel type d appareil étant le JSON un format de données presque universelle
//charset=UTF-8 est la norme actuelle qui contient tous les caracteres accentuées permettant de s'assurer que tous les appareils
//puissent afficher correctemet les données 


// header("Content-Type: application/json; charset=UTF-8");



// header("Access-Control-Allow-Methods: GET"); indique les méthodes utilisées pour la requete en question 
// notre requete veut lire les données et donc dans la norme REST pour lire on utilise la méthode GET


// header("Access-Control-Allow-Methods: GET");


//header("Access-Control-Max-Age: 3600"); Max-Age est la durée de vie de la requete 


// header("Access-Control-Max-Age: 3600");


//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//permet d'empecher certains headers 


// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



//maintenant il va falloir traiter les données et faire en sorte que notre requete soit traitée par le serveur 
//et qu'on renvoie les bonnes données par rapport à sa requete 


// 1. La premiere choses à faire pour s'assurer que notre API soit une API REST et qu'il respecte le standard)
//est de verifier si la requete du client est la bonne donc on fait une condition:

// 1.1 On vérifie que la méthode utilisée est correcte: REQUEST_METHOD = méthode de la requete 
//on verifie donc si elle est bien GET 
// if($_SERVER['REQUEST_METHOD'] == 'GET'){
//     //si l utilisateur a bien utilisé la méthode get on lui permet d acceder aux données 
//     // et donc on inclut les fichiers de configuration et d'accès aux données
//     include_once '../src/Core/Database.php';
//     include_once '../src/Model/PlaceModel.php';




//     // On instancie la base de données
//     $database = new Database();
//     //on créé notre connexion en utilisant la méthode getPDOConnection qui se trouve 
//     //dans le fichier Database.php
//     $db = $database->getPDOConnection();

//     // On instancie les lieux de visite
//     $place = new PlaceModel($db);

//     // On récupère les données
//     //statement 
//     $stmt = $place->getAllPlaces();

//    // On vérifie si on a au moins 1 produit parce que ca ne sert à rien d envoyer une reponse 
//     // si on a rien donc il faudre le verifier 
//     //on va chercher dans stmt la methode rowCount et on lui dit de verifier si il est >0
//     if($this->$stmt->rowCount() > 0){
//        // On initialise un tableau associatif
//         $tableauLieux = [];
//         // on va lui integrer un sous ensemble places qui va etre initialiser vide egalement
//         $tableauLieux['places'] = [];

//         // On parcourt les lieux on utilise le fetch à la place de fetchALL parce que il a été prouvé que
//         // en utilisant autant de fois un fetch pour aller chercher une seule  ligne à chaquye fois ca va aller plus vite 
//         // que faire un fetchAll qui lit toute les lignes. Donc on va faire une boucle pour parcouyrir les lignes de notre tableau 
//         // la boucle on la fait sur notre $stmt et on le fait sur le fetch au meme temps 
//         //$row  pour les lignes 
//         while($row = $this->$stmt->fetch(PDO::FETCH_ASSOC)){
//              //la méthode extract permet de recuperer notre ligne sous forme de variable chaqune des colonnes de nos données 
//             //donc par exemple la conne id s'appelera $id, nom $nom
//             extract($row);
//  //tableau associatif php 
//             $pl = [
//                 "id" => $id,
//                 "adressPlace" => $adressPlace,
//                 "abstractPlace" =>  $abstractPlace,
//                 "descriptionPlace" => $descriptionPlace,
//                 "lonPlace" => $lonPlace,
//                 "latPlace" => $latPlace
//             ];
// // on va ajouter le tableau $pl; au tableau $tableauLieux
// //au lieu de faire  un array push, à partir de php 7.2 on peut faire directement  $tableauLieux['places'] et en mettant des [] juste après on fait un push
// // en lui passant directment $prod qui va donc s'ajouter au sous ensemble places du tableau $tableauLieux
//             $tableauLieux['places'][] = $pl;
//         }

//        // On envoie le code réponse 200 pour dire que c'est OK que ca a bien fonctionné 
//         http_response_code(200);

//         // On encode en json et on envoie
//         echo json_encode($tableauLieux);
//     }

// }else{
//     // Si la méthode n 'est pas correcte on renvoi un code d erreur : On gère l'erreur en utilisant la méthode http_response_code(405);
//     // le code 405 corresponde à l erreur "La méthode n'est pas autorisée"
//     //On envoie egalement un essage ecrit au client en json un tableau, en json  parce que on l a defini dans notre header   echo json_encode(["message" => "La méthode n'est pas autorisée"]);
//     //donc on indique à l utilisateur qui n'as pas choisi la bonne méthode pour interroger le  serveur. 
//     http_response_code(405);
//     echo json_encode(["message" => "La méthode n'est pas autorisée"]);
// }




$template = 'mapInteractive';

include '../templates/base.phtml';