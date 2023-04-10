<?php

class CategoryModel extends AbstractModel
// CategoryModel représente un modèle de données pour les catégories. Cette classe hérite d'une classe abstraite "AbstractModel"
{
    /**
     * getAllCategories() retourne toutes les catégories actives contrairement à la fonction getAllCategoriesActInactifs qui  récupère  les catégories actives et inactives. . Elle prépare une requête SQL qui sélectionne toutes les colonnes de la table "categories" où la colonne "actifCategory" est égale à 1. Elle appelle la méthode "getAllResults" de l'objet "db" qui représente une instance de la base de données pour exécuter la requête SQL et récupérer tous les résultats.
     *
     * @return array
     */
    function getAllCategories(): array
    {
        $sql = 'SELECT *
            FROM categories AS c
            WHERE actifCategory = 1';
        return $this->db->getAllResults($sql);
    }

    /**
     * getAllCategoriesActInactifs() récupère toutes les catégories de la base de données, qu'elles soient actives ou inactives, contrairement à la fonction getAllCategories() qui ne récupère que les catégories actives. 
     * La méthode getAllResults() de l'objet de connexion $this->db est ensuite appelée avec la requête SQL en tant que premier paramètre pour récupérer toutes les catégories dans la base de données, qu'elles soient actives ou inactives. Le résultat est retourné sous forme d'un tableau de résultats.
     *
     * @return array
     */
    function getAllCategoriesActInactifs(): array
    {
        $sql = 'SELECT *
            FROM categories AS c';
        return $this->db->getAllResults($sql);
    }


    /**
     * getAllCategoryByIdPlace() récupère toutes les catégories associées à un lieu spécifique. Elle prépare une requête SQL qui joint les tables "categories" et "category_place" pour sélectionner toutes les colonnes de la table "categories" où la colonne "idPlace" de la table "category_place" est égale à l'ID du lieu spécifié en paramètre. Elle appelle la méthode "getAllResults" de l'objet "db" pour exécuter la requête SQL et récupérer tous les résultats.
     *
     * @param integer $idPlace
     * @return array
     */
    function getAllCategoryByIdPlace(int $idPlace): array
    {
        $sql = 'SELECT *
        FROM categories AS c
        LEFT JOIN  category_place AS cp ON c.idCategory = cp.idCategory
        LEFT JOIN places p ON cp.idPlace = p.idPlace";
        WHERE cp.idPlace = ?';
        return $this->db->getAllResults($sql, [$idPlace]);
    }

    /**
     * getOneCategory(int $idCategory) récupère une catégorie spécifique en utilisant son ID. Elle prépare une requête SQL qui sélectionne toutes les colonnes de la table "categories" où la colonne "idCategory" est égale à l'ID de la catégorie spécifiée en paramètre. Elle appelle la méthode "getOneResult" de l'objet "db" pour exécuter la requête SQL et récupérer un seul résultat.
     *
     * @param integer $idCategory
     * @return boolean|array
     */
    function getOneCategory(int $idCategory): bool|array
    {

        // Préparation de la requête SQL
        $sql = 'SELECT * 
            FROM categories
            WHERE idCategory = ?';

        return $this->db->getOneResult($sql, [$idCategory]);
    }


    /**
     * addCategory(string $titleCategory, string $descriptionCategory, string $imgCategory, string $markerCategory, string $iconeCategory, $actifCategory) ajoute une nouvelle catégorie à la base de données. Elle prépare une requête SQL qui insère une nouvelle ligne dans la table "categories" en utilisant les valeurs spécifiées en paramètre. Elle appelle la méthode "executeQuery" de l'objet "db" pour exécuter la requête SQL.
     *
     * @param string $titleCategory
     * @param string $descriptionCategory
     * @param string $imgCategory
     * @param string $markerCategory
     * @param string $iconeCategory
     * @param [type] $actifCategory
     * @return void
     */
    function addCategory(string $titleCategory, string $descriptionCategory, string $imgCategory, string $markerCategory, string $iconeCategory, $actifCategory)
    {
        // Préparation de la requête
        $sql = 'INSERT INTO categories (titleCategory, descriptionCategory, imgCategory, markerCategory, iconeCategory, actifCategory)  /*Le insert into est une requête d action donc il ny a pas besoin de fecth contrairement aux requêtes de séléctions */ 
            VALUES (?,?,?,?,?,?)';
        return $this->db->executeQuery($sql, [$titleCategory, $descriptionCategory, $imgCategory, $markerCategory, $iconeCategory, $actifCategory]);
    }
    /**
     * function editCategory(int $idCategory, string $titleCategory, string $descriptionCategory, string $imgCategory, string $markerCategory, string $iconeCategory, $actifCategory) modifie une catégorie existante dans la base de données. Elle prépare une requête SQL qui met à jour les colonnes de la table "categories" correspondant à l'ID de la catégorie spécifiée en paramètre avec les nouvelles valeurs spécifiées en paramètre. Elle appelle la méthode "executeQuery" de l'objet "db" pour exécuter la requête SQL.
     *
     * @param integer $idCategory
     * @param string $titleCategory
     * @param string $descriptionCategory
     * @param string $imgCategory
     * @param string $markerCategory
     * @param string $iconeCategory
     * @param [type] $actifCategory
     * @return void
     */
    function editCategory(int $idCategory, string $titleCategory, string $descriptionCategory, string $imgCategory, string $markerCategory, string $iconeCategory, $actifCategory)
    {
        $sql = 'UPDATE categories 
                SET titleCategory = ?, descriptionCategory = ?, imgCategory = ?, markerCategory = ?, iconeCategory = ?, actifCategory=?
                WHERE idCategory = ?';
        return $this->db->executeQuery($sql, [$titleCategory, $descriptionCategory, $imgCategory, $markerCategory, $iconeCategory, $actifCategory, $idCategory]);
    }

    /**
     * deleteCategory(int $idCategory) supprime une catégorie spécifique de la base de données. Elle prépare une requête SQL qui supprime toutes les lignes de la table "categories" où la colonne "idCategory" est égale à l'ID de la catégorie spécifiée en paramètre. Elle appelle la méthode "executeQuery" de l'objet "db" pour exécuter la requête SQL.
     *
     * @param string $idCategory
     * @return void
     */
    function deleteCategory(int $idCategory)
    {
        $sql = 'DELETE FROM categories
                WHERE idCategory = ?';
        $this->db->executeQuery($sql, [$idCategory]);
    }

    /**
     *  searchCategory($titleCategory) permet de rechercher une catégorie dans la base de données en fonction de son titre. La méthode prend un paramètre $titleCategory qui représente le titre de la catégorie recherchée.
     * La méthode construit une requête SQL pour récupérer toutes les colonnes (*) de la table categories où la colonne titleCategory correspond à la valeur fournie en tant que paramètre. La valeur de $titleCategory est transmise en tant que paramètre à la méthode getAllResults() de l'objet $this->db, qui est une instance d'une connexion à la base de données. La méthode getAllResults() renvoie un tableau de toutes les lignes qui correspondent à la requête.
     *
     * @param [type] $titleCategory
     * @return void
     */
    function searchCategory($titleCategory)
    {
        $sql = 'SELECT *  
                FROM categories
                WHERE titleCategory = ?';
        return $this->db->getAllResults($sql, [$titleCategory]);
    }
}
