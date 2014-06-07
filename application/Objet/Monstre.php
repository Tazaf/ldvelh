<?php

/**
 * 
 */
class Objet_Monstre {

    /**
     * L'identifiant du monstre.
     * @var Number 
     */
    public $id;

    /**
     * Le nom du monstre.
     * @var String 
     */
    public $nom;

    /**
     * La valeur d'habileté du monstre.
     * @var Number 
     */
    public $habilete;

    /**
     * La valeur d'endurance du monstre.
     * @var Number 
     */
    public $endurance;

    /**
     * Construit un nouvel objet Monstre avec un array contenant les paramètres. Cet array doit avoir le format et les données suivants :
     * <p>{</p>
     * <p>"id" => L'identifiant du monstre.</p>
     * <p>"nom" => Le nom du monstre</p>
     * <p>"habilete" => La valeur d'habilete du monstre.</p>
     * <p>"endurance" => La valeur d'endurance du monstre.</p>
     * <p>}</p>
     * @param array $params Un tableau contenant tous les paramètres pour la création d'un nouvel objet Monstre.
     * @throws Exception Si un paramètre est absent ou invalide.
     */
    public function __construct(array $params) {
        if (
        isset($params["id"]) && is_numeric($params["id"]) &&
        isset($params["nom"]) &&
        isset($params["habilete"]) && is_numeric($params["habilete"]) &&
        isset($params["endurance"]) && is_numeric($params["endurance"])
        ) {
            $this->id = $params["id"];
            $this->nom = $params["nom"];
            $this->habilete = $params["habilete"];
            $this->endurance = $params["endurance"];
        } else {
            throw new Exception("Paramètre absent ou invalide");
        }
    }

}
