<?php

class Objet_SacADos {
    
    /**
     * Le contenu du Sac à Dos.
     * @var array 
     */
    public $contenu;
    
    /**
     * Construit un nouveau SacADos. Par défaut, le contenu du SacADos est vide.
     * Pour ajouter des possessions au SacADos, utilisez la méthode addPossession().
     */
    public function __construct() {
        $this->contenu = array();
    }
    
    /**
     * Ajoute une possession au SacADos. Demande un Objet_Possession ainsi qu'une quantite pour cette possession.
     * @param Objet_Possession $possession Un objet Possession à ajouter au sac à dos.
     * @param int $quantite La quantité liée à l'objet Possession à ajouter.
     */
    public function addPossession(Objet_Possession $possession, $quantite) {
        $this->contenu[] = array(
            "possession" => $possession,
            "quantite" => $quantite
        );
    }
}