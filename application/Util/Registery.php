<?php

/**
 * Cette classe concerne le registre utilitaire dans lequel sont stockés les informations globales à l'application.
 * Auteur original : M. Nicolas Chabloz.
 */
class Util_Registery {

    private static $singletone = NULL;
    private $registery;
    
    /**
     * Cette fonction permet de récupérer le registre utilitaire.
     * @return Util_Registery Le registre utilitaire.
     */
    public static function getInstance() {
        if (!isset(self::$singletone)) {
            self::$singletone = new self();
        }
        return self::$singletone;
    }
    
    private function __construct() {
        $this->registery = array();
    }
    
    /**
     * Permet de rajouter un élément au registre en renseignant son nom et sa valeur.
     * @param type $key Le nom de l'élément à rajouter au registre.
     * @param type $value La valeur de l'élément à rajouter au registre.
     */
    public function set($key, $value) {
        $this->registery[$key] = $value;
    }
    
    /**
     * Permet de récupérer la valeur d'un élément selon la clé entrée en paramètre.
     * @param type $key La clé de l'élément duquel l'on souhaite récupérer la valeur.
     * @return type La valeur de l'élément.
     * @throws Exception Lancée si la clé passée en paramètre ne pointe sur aucun élément existant dans le registre.
     */
    public function get($key) {
        if (!isset($this->registery[$key])) {
            throw new Exception("Key doesn't exist in this registery");
        }
        return $this->registery[$key];
    }

}