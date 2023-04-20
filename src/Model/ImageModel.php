<?php

class ImageModel extends AbstractModel // Ne pas oublier de faire un extend de la classe.

/* Cette classe représentante le CRUD */

{
    function getAllImages(): array
    {
        $sql = 'SELECT *
            FROM images';

//        $db = new Database(); //Cette variable est toujours présente dans chaque méthode et elle vient de Database. Le mettre en propriété veut dire qu'on va le mutualiser dans la classe.

        return $this->db->getAllResults($sql);
    }

    function getAllImagesByPlace(int $idPlace): array
    {
        $sql = 'SELECT *
            FROM images
            WHERE idPlace = ?';

//        $db = new Database(); //Cette variable est toujours présente dans chaque méthode et elle vient de Database. Le mettre en propriété veut dire qu'on va le mutualiser dans la classe.

        return $this->db->getAllResults($sql, [$idPlace]);
    }


    // https://openclassrooms.com/forum/sujet/requete-sql-en-many-to-many
    function getOneImage(int $idImage): bool|array
    {

        // Préparation de la requête SQL
        $sql = 'SELECT * 
            FROM images
            WHERE idImage = ?';

        return $this->db->getOneResult($sql, [$idImage]);

    }

    function addImage(string $titleImage, string $nameImage)
    {

        // Préparation de la requête
        $sql = 'INSERT INTO images (titleImage, titleImage)  /*Le insert into est une requête d action donc il ny a pas besoin de fecth contrairement aux requêtes de séléctions */ 
            VALUES (?,?)';


        return $this->db->executeQuery($sql, [$titleImage, $nameImage]);

    }

    function editImage(string $titleImage, string $nameImage)
    {

        $sql = 'UPDATE images 
                SET titleImage = ?, nameImage = ?
                WHERE idImage = ?';


        return $this->db->executeQuery($sql, [$titleImage, $nameImage]);
    }


    function deleteImage(string $idImage)
    {

        $sql = 'DELETE FROM images
                WHERE idImage = ?';

        $this->db->executeQuery($sql, [$idImage]);

    }

}