<?php 

//la class Database permet de se connecter à une base de données MySQL et d'exécuter des requêtes SQL à l'aide de PDO (PHP Data Objects).


class Database {
// propriété statique $pdo de la classe  qui stocke une instance de l'objet PDO (PHP Data Objects) pour la connexion à la base de données 
//Le mot-clé static indique que la propriété est liée à la classe plutôt qu'à une instance de la classe, ce qui signifie qu'elle peut être partagée entre toutes les instances de la classe et accessible depuis l'extérieur de la classe sans avoir besoin d'instancier la classe. 
    static private ?PDO $pdo = null;

    public function __construct()
    {
        if (self::$pdo == null) {
            self::$pdo = $this->getPDOConnection();
        }
    }

    /**
     * Création d'une connexion PDO à la base de données
     */
    function getPDOConnection()
    {
        // Connexion à la base de données
        // DSN : Data Source Name (informations de connexion à la BDD)
        //définir les informations de connexion à la base de données en créant une chaîne de connexion DSN (Data Source Name) qui spécifie le nom de la base de données (constante prédéfinie DB_NAME), l'hôte (constante prédéfinie DB_HOST)  et l'encodage des caractères.
        //les constantes sont definies dans le fichier config.php
        $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8'; 
        $user = DB_USER; // Utilisateur
        $password = DB_PASS; // Mot de passe

        //tableau d'options  créé pour spécifier certains paramètres de configuration de l'objet PDO. 
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Pour transformer les erreurs SQL en exceptions (erreurs) PHP et les voir sur le page = faciliter la gestion des erreurs dans le code
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Mode de récupération des résultats de requêtes de sélection : tableaux associatifs
        ];

        // un nouvel objet de la classe PDO en utilisant les informations de connexion et les options spécifiées, et retourne cet objet

        $pdo = new PDO($dsn, $user, $password, $options); // Création d'un objet de la classe PDO

        return $pdo;
    }


/**
 *getPDO()
 * renvoie simplement l'objet PDO stocké dans la variable de classe $pdo. Comme la variable est statique, elle peut être utilisée par toutes les instances de la classe, ce qui signifie que la même connexion PDO est partagée entre toutes les instances de la classe. Cela permet d'éviter de créer une nouvelle connexion PDO à chaque fois qu'une instance de la classe est créée, ce qui peut être coûteux en termes de performances. En utilisant une variable de classe statique pour stocker l'objet PDO, la connexion à la base de données n'est établie qu'une seule fois, ce qui réduit les temps d'attente et améliore les performances de l'application.
 * @return void
 */
    function getPDO()
    {
        return self::$pdo;
    }


    /**
     * Cette méthode permet de préparer et d'exécuter une requête SQL en utilisant l'objet PDO stocké dans la variable de classe statique $pdo. Elle prend en paramètre la requête SQL à exécuter sous forme de chaîne de caractères, ainsi qu'un tableau de valeurs qui seront introduites dans la requête.
     * @param string $sql La requête SQL qu'on souhaite exécuter
     * @param array $values Le tableau de valeurs qu'on souhaite introduire dans la requête SQL
     * @return PDOStatement L'objet PDOStatement une fois la requête exécutée
     */
    public function executeQuery(string $sql, array $values = []): PDOStatement
    {
        // Préparation de la requête SQL en appelant la méthode prepare() de l'objet PDO, en utilisant la requête SQL passée en paramètre.  Cette méthode permet de préparer la requête SQL en remplaçant les paramètres de requête par des marqueurs de paramètres (par exemple, "?" ou ":nom") qui seront remplacés par les valeurs effectives lors de l'exécution de la requête.
        $pdoStatement = self::$pdo->prepare($sql);

        // Exécution de la requête SQL en appelant la méthode execute() de l'objet PDOStatement retourné par la méthode prepare(). Cette méthode prend en paramètre un tableau de valeurs qui correspond aux valeurs à insérer dans la requête SQL à la place des marqueurs de paramètres.
        $pdoStatement->execute($values);
        //var_dump($pdoStatement->errorInfo());

        // On retourne l'objet PDOStatement  la méthode retourne l'objet PDOStatement résultant, qui peut être utilisé pour récupérer les résultats de la requête SQL ou pour effectuer d'autres opérations sur la requête.
        return $pdoStatement;
    }

    /**
     *  Exécute une requête de sélection et retourne UN seul résultat
     * permet de récupérer un seul résultat sous forme de tableau associatif à partir d'une requête SQL donnée, en appelant la méthode executeQuery() et fetch() sur un objet PDOStatement.
     *la méthode getOneResult() renvoie le tableau associatif obtenu grâce à fetch(). Si la requête ne retourne pas de résultat, la méthode fetch() renvoie false et la méthode getOneResult() renverra donc également false.
     * @param string $sql
     * @param array $values
     * @return void
     */
    public function getOneResult(string $sql, array $values = [])
    {
        // Préparation et exécution de la requête
        $pdoStatement = $this->executeQuery($sql, $values);

        // Récupération d'UN SEUL résultat
        return $pdoStatement->fetch();
    }

   /**
    * Exécute une requête de sélection et retourne TOUS les résultats
    *
    * @param string $sql
    * @param array $values
    * @return void
    */
    public function getAllResults(string $sql, array $values = [])
    {
        // Préparation et exécution de la requête
        $pdoStatement = $this->executeQuery($sql, $values);

        // Récupération de TOUS les résultats
        return $pdoStatement->fetchAll();
    }

}