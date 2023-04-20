<?php

// Récupération du nom du fichier à télécharger à partir de la variable GET
$Fichier_a_telecharger = isset($_GET['file']) ? $_GET['file'] : '';

// Définition du chemin vers le dossier contenant le fichier à télécharger
$chemin = __DIR__ . '/../public/pdf/';

// Vérification de l'existence du fichier
if (!file_exists($chemin . $Fichier_a_telecharger)) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

// Expression régulière qui ne permet que les caractères légitimes dans un nom de fichier
$regex = '/^[\w\d\.\-\_]+$/';

// Vérification de la validité de la chaîne de caractères $Fichier_a_telecharger
if (!filter_var($Fichier_a_telecharger, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $regex]])) {
    header("HTTP/1.0 400 Bad Request");
    exit;
}

// Obtention du chemin absolu du fichier
$real_path = realpath($chemin . $Fichier_a_telecharger);

// Vérification que le fichier se trouve bien dans le dossier public/pdf
if (strpos($real_path, realpath(__DIR__ . '/../public/pdf')) !== 0) {
    header("HTTP/1.0 403 Forbidden");
    exit;
}

// Reconaissance de l'extension afin que le téléchargement 
// corresponde au type de fichier. Cela évite les erreurs de corruptions.
switch(strrchr(basename($Fichier_a_telecharger), ".")) {

case ".gz": $type = "application/x-gzip"; break;
case ".tgz": $type = "application/x-gzip"; break;
case ".zip": $type = "application/zip"; break;
case ".pdf": $type = "application/pdf"; break;
case ".png": $type = "image/png"; break;
case ".gif": $type = "image/gif"; break;
case ".jpg": $type = "image/jpeg"; break;
case ".txt": $type = "text/plain"; break;
case ".htm": $type = "text/html"; break;
case ".html": $type = "text/html"; break;
default: $type = "application/octet-stream"; break;

}

header("Content-disposition: attachment; filename=$Fichier_a_telecharger");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: $type\n"); // Surtout ne pas enlever le \n
header("Content-Length: ".filesize($chemin . $Fichier_a_telecharger));
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0");
readfile($chemin . $Fichier_a_telecharger);
?>