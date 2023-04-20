<?php

class Session extends AbstractSession
{

    /**
     * checkUser verifie que l'adresse mail et le mot de pass soient correctes
     * Il recupere d'abord le user par son mail getUserByEmail et ensuite si
     * l'utilisateur existe il est necessaire de verifier le mot de passe reinsegné
     * avec le mot de passe hashé enregistré dans la BDD
     *
     * @param string $emailUser adresse mail de l'utilisateur
     * @param string $passwordUser password reinsegné par l'utilisateur
     * @return void
     */
    function checkUser(string $emailUser, string $passwordUser)
    {
        //Création d'une instance de la classe UserModel
        $userModel = new UserModel();
        // On récupère l'utilisateur à partir de son email
        $user = $userModel->getUserByEmail($emailUser);
        // Si on trouve bien un utilisateur...
        if ($user) {
            // On vérifie son mot de passe
            if (password_verify($passwordUser, $user['hashPassUser'])) {
                // Tout est ok, on retourne l'utilisateur
                return $user;
            }
        }

        // Si l'email ou le mot de passe est incorrect...
        return false;
    }

    /**
     * registerUser() enregistre les données de l'utilisateur en session
     *
     * @param string $idUser
     * @param string $firstnameUser
     * @param string $lastnameUser
     * @param string $emailUser
     * @param string $roleUser
     * @return void
     */
    function registerUser(
        string $idUser,
        string $firstnameUser,
        string $lastnameUser,
        string $emailUser,
        string $roleUser
    ) {
        // On commence par vérifier qu'une session est bien démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Puis on enregistre les données de l'utilisateur en session dans la variable de session $_SESSION['users'] sous la forme d'un tableau associatif contenant les clés 'idUser', 'firstnameUser', 'lastnameUser', 'emailUser' et 'roleUser', et les valeurs correspondantes passées en paramètre.
        $_SESSION['users'] = [
            'idUser' => $idUser,
            'firstnameUser' => $firstnameUser,
            'lastnameUser' => $lastnameUser,
            'emailUser' => $emailUser,
            'roleUser' => $roleUser,
        ];
    }

    /**
     * isConnected() Détermine si l'utilisateur est connecté ou non
     * *public la méthode peut être appelée de n'importe où dans le code, que ce soit à l'intérieur de la classe ou depuis l'extérieur.
     * static  indique que la méthode appartient à la classe elle-même plutôt qu'à une instance de la classe. Cela signifie qu'elle peut être appelée directement depuis la classe, sans avoir besoin d'instancier un objet de cette classe.
     * @return bool - true si l'utilisateur est connecté, false sinon
     */
    public static function isConnected(): bool
    {
        // On commence par vérifier qu'une session est bien démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return array_key_exists('users', $_SESSION) && isset($_SESSION['users']);
    }

    /**
     * getUserId() Retourne l'id de l'utilisateur connecté
     *
     * @return void
     */
    public static function getUserId()
    {
        // Si l'utilisateur n'est pas connecté return false
        if (!Session::isConnected()) {
            return null;
        }
        // vérifie si un utilisateur est connecté en vérifiant si la clé "users" est présente dans $_SESSION et si elle est définie (non nulle). Si c'est le cas, la fonction isConnected() renvoie true, sinon elle renvoie false.
        return $_SESSION['users']['idUser'];
    }

 /**
  * getUserFirstname() Retourne le prénom de l'utilisateur connecté
  *
  * @return void
  */
    public static function getUserFirstname()
    {
        // Si l'utilisateur n'est pas  connecté return false
        if (!Session::isConnected()) {
            return null;
        }
        // s'il est connecté ...
        return $_SESSION['users']['firstnameUser'];
    }

    /**
     * getUserLastname() Retourne le nom de l'utilisateur connecté
     *
     * @return void
     */
    public static function getUserLastname()
    {
        // Si l'utilisateur n'est pas connecté...
        if (!Session::isConnected()) {
            return null;
        }
        // s'il est connecté ...
        return $_SESSION['users']['lastnameUser'];
    }

   /**
    *  getUserEmail() Retourne l'email de l'utilisateur connecté
    *
    * @return void
    */
    public static function getUserEmail()
    {
        // Si l'utilisateur n'est pas connecté...
        if (!Session::isConnected()) {
            return null;
        }
        // s'il est connecté ...
        return $_SESSION['users']['emailUser'];
    }

    /**
     * getUserRole() Retourne le rôle de l'utilisateur connecté
     *
     * @return void
     */
    public static function getUserRole()
    {
         // Si l'utilisateur n'est pas connecté...
        if (!Session::isConnected()) {
            return null;
        }
        //s'il est connecté ...    
        return $_SESSION['users']['roleUser'];
    }

    /**
     * Vérifie si l'utilisateur possède un rôle particulier
     *
     * @param string $roleUser
     * @return boolean
     */
    public static function hasRole(string $roleUser)
    {
        // Si l'utilisateur n'est pas connecté...
        if (!Session::isConnected()) {
            return false;
        }

        return Session::getUserRole() == $roleUser;
    }

    /**
     * logout() Déconnecte l'utilisateur
     *
     * @return void
     */
    public static function logout()
    {
        // Si l'utilisateur est connecté...
        if (Session::isConnected()) {
            // On efface nos données en session
            $_SESSION['users'] = null;

            // On ferme la session
            session_destroy();
        }
    }
}
