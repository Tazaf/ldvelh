<?php

class Objet_Paragraphe {
    
    /**
     * Le numero du paragraphe.
     * @var int 
     */
    public $numero;
    
    /**
     * Un tableau contenant un ou plusieurs objets Monstres représentants les monstres présents dans le paragraphe.
     * @var array 
     */
    public $monstres;
    
    /**
     * Le malus du paragraphe. Peut être NULL.
     * @var Objet_Effet 
     */
    public $malus;
    
    /**
     * Construit un nouvel objet Paragraphe
     * @param int $numero Le numero du paragraphe.
     * @param array $monstres Un tableau contenant un ou plusieurs objets Monstres représentants les monstres présents dans le paragraphe.
     * @param Objet_Effet $malus Le malus du paragraphe. Peut être NULL.
     * @throws Exception Si un paramètre est absent ou invalide.
     */
    public function __construct($numero, array $monstres, Objet_Effet $malus = NULL) {
        if (!is_null($numero) && is_numeric($numero) && $monstres[0] instanceof Objet_Monstre) {
            $this->numero = $numero;
            $this->monstres = $monstres;
            $this->malus = $malus;
        } else {
            throw new Exception("Paramètre(s) manquant(s) ou invalide(s) pour l'instanciation de la classe Objet_Paragraphe");
        }
    }
}
