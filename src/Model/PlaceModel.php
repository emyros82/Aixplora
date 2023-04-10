<?php

class PlaceModel extends AbstractModel

/* Cette classe représentante le CRUD */

{
    /**
     * getAllPlaces() récupère tous les lieux actifs (actifPlace = 1) de la table "places" en utilisant une requête SQL SELECT et retourne les résultats en utilisant la méthode getAllResults() de la classe Database
     *
     * @return void
     */
    function getAllPlaces()
    {
        $sql = 'SELECT *
        FROM places 
        WHERE actifPlace = 1';

        return $this->db->getAllResults($sql);
    }

    /**
     *  getAllPlacesWithCategories() récupère tous les lieux actifs (actifPlace = 1) de la table "places" en utilisant une requête SQL SELECT qui effectue une jointure avec la table "category_place" pour récupérer les catégories associées à chaque lieu, et une autre jointure avec la table "categories" pour récupérer les détails de chaque catégorie. Les résultats sont retournés en utilisant la méthode getAllResults() de la classe de Database 
     *
     * @return void
     */
    function getAllPlacesWithCategories()
    {
        $sql =  'SELECT p.*, c.titleCategory, c.markerCategory, c.idCategory
                FROM places p
                INNER JOIN category_place cp ON p.idPlace = cp.idPlace
                INNER JOIN categories c ON cp.idCategory = c.idCategory
                WHERE actifPlace = 1';
        return $this->db->getAllResults($sql);
    }

    function getAllPlacesByCategories()
    {
        $sql =  'SELECT p.*, c.titleCategory, c.markerCategory, c.idCategory
                FROM places p
                INNER JOIN category_place cp ON p.idPlace = cp.idPlace
                INNER JOIN categories c ON cp.idCategory = c.idCategory
                WHERE idCategory = ?';
        return $this->db->getAllResults($sql);
    }

    // https://openclassrooms.com/forum/sujet/requete-sql-en-many-to-many
    /**
     *getOnePlace(int $idPlace) récupère les détails d'un lieu spécifique en utilisant une requête SQL SELECT qui sélectionne tous les champs de la table "places" où l'ID du lieu correspond à celui passé en paramètre. Les résultats sont retournés en utilisant la méthode getOneResult() 
     *Cette méthode est utilisée pour afficher les détails d'un lieu sélectionné 
     *
     * @param integer $idPlace
     * @return boolean|array
     */
    function getOnePlace(int $idPlace): bool|array
    {

        // Préparation de la requête SQL
        $sql = 'SELECT *
            FROM places AS p
            WHERE idPlace = ?';

        return $this->db->getOneResult($sql, [$idPlace]);
    }
    // https://stackoverflow.com/questions/19714308/mysql-how-to-insert-into-table-that-has-many-to-many-relationship

    /**
     * addPlace() prend plusieurs paramètres pour ajouter un nouvel lieu dans une base de données. 
     * La méthode  commence par :
     * exécuter une requête SQL pour insérer les informations de base de l'lieu dans la table places.
     *  Ensuite, la fonction récupère l'ID du dernier lieu inséré dans la base de données en utilisant la méthode lastInsertId() de l'objet PDO, qui permet d'accéder à la base de données. 
     * La fonction exécute ensuite une autre requête SQL pour ajouter les associations entre l'lieu et les catégories dans la table intermédiaire category_place, en utilisant une boucle pour insérer chaque catégorie de la liste $categories dans la table.
     *
     * @param string $titlePlace
     * @param string $adressPlace
     * @param string $abstractPlace
     * @param string $descriptionPlace
     * @param float $longPlace
     * @param float $latPlace
     * @param string $imagePlace
     * @param [type] $actifPlace
     * @param [type] $categories
     * @return void
     */
    function addPlace(string $titlePlace, string $adressPlace, string $abstractPlace, string $descriptionPlace, float $longPlace, float $latPlace, string $imagePlace, $actifPlace, $categories)
    {

        // Préparation de la requête pour le lieu ajouté dans la table places
        /*Le insert into est une requête d action donc il ny a pas besoin de fecth contrairement aux requêtes de séléctions */
        $sql = "INSERT INTO places (titlePlace, adressPlace, abstractPlace, descriptionPlace,longPlace,latPlace,imagePlace, actifPlace) VALUES (?,?,?,?,?,?,?,?);";

        $this->db->executeQuery($sql, [$titlePlace, $adressPlace, $abstractPlace, $descriptionPlace,  $longPlace,  $latPlace, $imagePlace, $actifPlace]);
        $lastIdPlace = $this->db->getPDO()->lastInsertId();
        // Préparation de la requête pour rajouter les derniers ID de Places et Categorie dans la table intermediare category_place

        // La boucle for est utilisée pour parcourir la liste de catégories $categories. La condition $i < count($categories) permet de vérifier que la variable $i est inférieure au nombre total de catégories dans la liste $categories, afin de ne pas dépasser la limite de la liste.

        // À chaque itération de la boucle, la fonction exécute une requête SQL pour insérer un nouvel enregistrement dans la table intermédiaire category_place, en utilisant l'ID de l'lieu $lastIdPlace et l'ID de la catégorie correspondante $categories[$i].

        // Ainsi, cette boucle permet de créer une nouvelle association entre l'lieu ajouté et chaque catégorie sélectionnée dans la liste $categories.

        $sql2 = "INSERT INTO category_place (idPlace, idCategory)
        VALUES (?,?)";

        for ($i = 0; $i < count($categories); $i++) {
            $this->db->executeQuery($sql2, [$lastIdPlace, $categories[$i]]);
        }
    }


    /**
     * editPlace() permet de modifier les informations d'un lieu existant dans la base de données en utilisant l'ID de l'lieu $idPlace. Elle prend en paramètres les nouvelles informations à enregistrer pour le  lieu et exécute une requête SQL pour mettre à jour l'enregistrement correspondant dans la table places. La fonction renvoie un booléen qui indique si la mise à jour a été effectuée avec succès ou non.
     *
     * @param string $titlePlace
     * @param string $adressPlace
     * @param string $abstractPlace
     * @param string $descriptionPlace
     * @param float $longPlace
     * @param float $latPlace
     * @param string $imagePlace
     * @param [type] $state
     * @param integer $idPlace
     * @return void
     */
    function editPlace(string $titlePlace, string $adressPlace, string $abstractPlace, string $descriptionPlace, float $longPlace, float $latPlace, string $imagePlace, $state, int $idPlace)
    {
        $sql = 'UPDATE places 
                SET titlePlace = ?, adressPlace = ?, abstractPlace = ?, descriptionPlace = ?, longPlace = ?, latPlace=?, imagePlace=?, actifPlace=?
                WHERE idPlace = ?';
        return $this->db->executeQuery($sql, [$titlePlace, $adressPlace, $abstractPlace, $descriptionPlace, $longPlace, $latPlace, $imagePlace, $state, $idPlace]);
    }

/**
 * deletePlace(string $idPlace) permet de supprimer un lieu existant dans la base de données en utilisant l'ID de l'lieu $idPlace. Elle exécute une requête SQL pour supprimer l'enregistrement correspondant dans la table places.
 *
 * @param string $idPlace
 * @return void
 */
    function deletePlace(string $idPlace)
    {
        $sql = 'DELETE FROM places
                WHERE idPlace = ?';
        $this->db->executeQuery($sql, [$idPlace]);
    }
/**
 * searchPlace($titlePlace) permet de rechercher un lieu dans la base de données en utilisant son titre $titlePlace. Elle exécute une requête SQL pour sélectionner tous les enregistrements de la table places qui ont un titre correspondant. La fonction renvoie un tableau qui contient tous les résultats de la requête SQL.
 *
 * @param [type] $titlePlace
 * @return void
 */
    function searchPlace($titlePlace)
    {
        $sql = 'SELECT *  
                FROM places
                WHERE titlePlace = ?';
        return $this->db->getAllResults($sql, [$titlePlace]);
    }
}
