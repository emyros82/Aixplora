<?php

/**
 * Classe de gestion de l'environnement applicatif
 */
class Environnement
{
    /**
     * @var string
     */

    private $pathEnv;

    /**
     * @return string
     */
    public function getPathEnv()
    {
        return $this->pathEnv;
    }

    /**
     * @param string $pathEnv : le chemin de l'environnement
     * @return void
     */
    private function setPathEnv($pathEnv)
    {
        $this->pathEnv = $pathEnv;
    }

    /**
     * @param string $pathEnv : le chemin vers le fichier de conf de l'appli
     * @return void
     */
    function __construct($pathEnv)
    {
        $this->setPathEnv($pathEnv);
        $this->loadEnv();
    }

    /**
     * Charge le fichier de conf
     * @throws Exception
     * @return void
     */
    private function loadEnv()
    {
        if (!file_exists($this->getPathEnv())) {
            throw new Exception("Le fichier de conf n'a pas été trouvé");
        }
        require_once $this->getPathEnv();
    }

    /**
     * Renvoie le chemin en absolu d un fichier public
     * @throws Exception
     * @return string
     */
    public function getPathPublicAbsolute($fileName)
    {
        $this->checkConst(['PATH_ROOT', 'PATH_PUBLIC']);
        return PATH_ROOT . '/' . PATH_PUBLIC . '/' . $fileName;
    }

    

    /**
     * Vérifie que des constantes existent
     * @param string $consListe: liste de nom de constantes à vérifier
     * @throws Exception
     * @return void
     */
    private function checkConst($consListe)
    {
        foreach ($consListe as $constName) {
            if (!defined($constName)) {
                throw new Exception(
                    "Configuration de l'environnement incomplète"
                );
            }
        }
    }

    function getPathTemplate($template)
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/' . PATH_TPL . '/' . $template;
    }

    /**
    * Renvoie le chemin d'une feuille de style en absolu
    * @throws Exception
    * @return string
    */
    public function getPathCss($fileName)
    {
        $this->checkConst(array('PATH_CSS'));
        return '<link rel="stylesheet" href="' . $this->getPathPublicAbsolute($fileName, PATH_CSS) . '">';
    }

    /**
    * Renvoie le chemin d'un script en absolu
    * @throws Exception
    * @return string
    */
    public function getPathScript($fileName)
    {
        $this->checkConst(array('PATH_JS'));
        return '<script src="' . $this->getPathPublicAbsolute($fileName, PATH_JS) . '"></script>';
    }
// public function getPathScript($fileName)
    // {
    //     $this->checkConst(['PATH_ROOT', 'PATH_PUBLIC', 'PATH_JS']);

    //     $url = PATH_JS . '/' . $fileName;
    //     return '<script src="' .
    //         $this->getPathPublicAbsolute($url) .
    //         '"></script>';
    // }

    
    /**
    * Renvoie le chemin d'une image en absolu
    * @throws Exception
    * @return string
    */
    public function getPathImageThumb($fileName)
    {
        $this->checkConst(array('PATH_IMG'));
        return '<img style="width : 150px; height:150px; object-fit: cover" src="' . $this->getPathPublicAbsolute($fileName, PATH_IMG) . '"/>';
    }

    public function getPathImage($fileName, $cssClass = '')
    {
        $this->checkConst(array('PATH_IMG'));
        return '<img ' . $cssClass . ' src="' . $this->getPathPublicAbsolute($fileName, PATH_IMG) . '"/>';
    }
    function getURL($adresse)
    {
        // $this->checkConst(['PATH_ROOT2']);
        //$adresse = $_SERVER['REDIRECT_URL'];
        return str_replace(PATH_ROOT2, '', $adresse);
    }

}

    
