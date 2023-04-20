<?php

class UserModel extends AbstractModel
{
/**
 * addUser() permet d'ajouter un nouvel utilisateur dans la base de données. Les paramètres de cette méthode sont le prénom, le nom, l'email et le mot de passe hashé de l'utilisateur. La méthode traite également le rôle de l'utilisateur, qui est défini comme "ROLE_USER" dans cet exemple. La méthode insère les données dans la table "users" de la base de données.
 *
 * @param string $firstnameUser Le prénom de l'utilisateur
 * @param string $lastnameUser  Le nom de l'utilisateur
 * @param string $emailUser L'email de l'utilisateur
 * @param string $hashPassUser Le mot de passe hashé de l'utilisateur
 * @return void
 */
    function addUser(
        string $firstnameUser,
        string $lastnameUser,
        string $emailUser,
        string $hashPassUser,   
    ) 
    {
      //on traite le role user
        $roleUser = ROLE_USER;

        $sql = 'INSERT INTO users (firstnameUser, lastnameUser, emailUser, hashPassUser, dateRegisterUser, roleUser)  /*Le insert into est une requête d action donc il ny a pas besoin de fecth contrairement aux requêtes de séléctions */ 
            VALUES (?,?,?,?,NOW(),?)';

            return $this->db->executeQuery($sql, [
            $firstnameUser,
            $lastnameUser,
            $emailUser,
            $hashPassUser,
            $roleUser,
           
        ]);
    }

    /**
     * compareUser vérifie l'existance d'un compte avec le même adresse mail  en utilisant 
     * la méthode getUserByEmail qui est definie dans cette classe. 
     * Si tel est le cas, elle renvoie un message d'erreur, sinon elle ne fait rien.
     * @param string $emailUser adresse mail de l'utilisateur
     * @return void
     */
    function compareUser (string $emailUser)
    {
        // Si il existe déjà un compte avec cet email... 
        if ($this->getUserByEmail($emailUser)) {

            // ... on lance une exception ! 
            return ('Il existe déjà un compte associé à cet email');
        }

    }

    /**
     * getAllUsers() récupère tous les utilisateurs ayant un compte
     *Elle effectue une requête SQL pour récupérer toutes les lignes de la table "users" triées par ordre décroissant d'identifiant utilisateur.
     * @return array
     */
    function getAllUsers(): array
    {
        $sql = 'SELECT *
            FROM users AS U
            ORDER BY U.idUser DESC';

        // Sinon on retourne directement notre tableau de users
        return $this->db->getAllResults($sql);
    }

    /**
     * getOneUser(int $idUser) permet de récupérer un utilisateur spécifique à partir de son identifiant. Elle effectue une requête SQL pour récupérer la ligne correspondante de la table "users" en fonction de l'identifiant utilisateur fourni en paramètre.
     *
     * @param integer $idUser
     * @return boolean|array
     */
    function getOneUser(int $idUser): bool|array
    {

        // Préparation de la requête SQL
        $sql = 'SELECT * 
            FROM users
            WHERE idUser = ?';

        return $this->db->getOneResult($sql, [$idUser]);

    }
   

    /**
     * getUserByEmail récupère un utilisateur à partir de son mail
     *Elle effectue une requête SQL pour récupérer la ligne correspondante de la table "users" 
     *en fonction de l'adresse mail. Elle retourne un resultat en utilisant la methode getOneResult de la classe Database. 
     *Cette methode est utilisée dans la methode compareUser()
     * @param string $emailUser adresse mail de l'utilisateur
     * @return void
     */
    function getUserByEmail(string $emailUser)
    {
        // Préparation de la requête SQL
        $sql = 'SELECT * 
            FROM users
            WHERE emailUser = ?';

        // On retourne ce résultat
        return $this->db->getOneResult($sql, [$emailUser]);
    }
}
