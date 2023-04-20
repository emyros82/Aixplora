<?php
// On dit que cette classe fait de la 'composition, car elle stock un objet qui provient d'une autre classe sans en être un enfant.

/**
 * Classe abstraite qui sera parente des classes de modèles
 * Elle permet de mutualiser la propriété $db qui stocke l'objet Database
 */
abstract class AbstractSession
{
    
    // On déclare la variable $db qui revient souvent en propriété et on va l'initialiser dans le constructeur. Le fait de le mettre directement dans la classe induit que l'on va avoir qu'une seule connection à la BDD ou lieu de faire une nouvelle connection à chaque requête. On met la propriété en protected pour pouvoir récupérer les données dans les enfants de la classe.
    protected Database $db; 

    function __construct()
    {
        $this->db = new Database();
    }
}