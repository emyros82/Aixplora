<?php

// Constantes
const PLACES_FILENAME = '../data/places.json';
const USERS_FILENAME = '../data/users.json';
const ROLE_USER = 'user';
const ROLE_ADMIN = 'ADMIN';

/////////////////////////////////////////
///////// FONCTIONS UTILITAIRES /////////
/////////////////////////////////////////
/**
 * Récupère des données stockées dans un fichier JSON
 * @param string $filepath - Le chemin vers le fichier qu'on souhaite lire
 * @return mixed - Les données stockées dans le fichier JSON désérialisées
 */
function loadJSON(string $filepath)
{
    // Si le fichier spécifié n'existe pas on retourne false
    if (!file_exists($filepath)) {
        return false;
    }

    // On récupère le contenu du fichier
    $jsonData = file_get_contents($filepath);

    // On retourne les données désérialisées
    return json_decode($jsonData, true);
}

/**
 * Ecrit des données dans un fichier au format JSON
 * @param string $filepath - Le chemin vers le fichier qu'on souhaite lire
 * @param $data - Les données qu'on souhaite enregistrer dans le fichier JSON
 * @return void
 */
function saveJSON(string $filepath, $data)
{
    // On sérialise les données en JSON
    $jsonData = json_encode($data);

    // On écrit le JSON dans le fichier
    file_put_contents($filepath, $jsonData);
}

/**
 * Construit l'URL d'une page à partir du nom de la page et d'un tableau de paramètres
 * @param string $page Le nom de la page dont on veut construire l'URL
 * @param array $params Un tableau associatif de paramètres à ajouter dans la chaîne de requête
 * @return string L'URL de la page avec les éventuels paramètres
 */

function buildUrl(string $page, array $params = []): string
{
    // return $page . '?' . http_build_query($params);
    return 'index.php?' . http_build_query(['page' => $page, ...$params]);
    //en chaine de caractere on va mettre ce qu'il sera tjs present
    //'index.php?page=' pour ensuit concaterner pa suite
    //urlencode() est un fnction pour
    // $url =
    //     'index.php?page=' . urlencode($page) . '&' . http_build_query($params);
    // $params = tableau , $paramName clé du tableau et $paramValue valeur associées
    // foreach ($params as $paramName=>$paramValue){

    //     $url.='&'.urlencode($paramName).'='.urlencode($paramValue);

    // }
    //le foreach peut être remplacé par la fonction native http_build_query($params)
    // $url.=http_build_query($params);
    // return $url;
    
}

