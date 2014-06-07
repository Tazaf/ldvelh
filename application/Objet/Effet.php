<?php

class Objet_Effet {

    /**
     * Le modificateur de l'effet. Ne peut prendre que deux valeurs : "+" et "-".
     * @var char
     */
    public $modificateur;

    /**
     * La valeur de la modification de l'effet.
     * @var int 
     */
    public $valeur;

    /**
     * La caractéristique du personnage touchée par l'effet.
     * @var String 
     */
    public $caracteristique;

    /**
     * Construit un nouvel objet Effet. Les données passées dans le constructeur doivent être sous forme de tableau associatif :
     * <p>array(<br>
     *     $params["modificateur"] => <i>Le modificateur de l'effet. Ne peut prendre que deux valeurs : "+" et "-".</i><br>
     *     $params["valeur"] => <i>La valeur de la modification de l'effet.</i><br>
     *     $params["caracteristique"] => <i>La caractéristique du personnage touchée par l'effet.</i><br>
     * )</p>
     * @param array $params
     * @throws Exception Cette exception se lance si l'un des paramètres n'est pas présent ou valide.
     */
    public function __construct(array $params) {
        if (
        isset($params["modificateur"]) && $params["modificateur"] !== NULL && ($params["modificateur"] === "+" || $params["modificateur"] === "-") &&
        isset($params["valeur"]) && $params["valeur"] !== NULL && is_numeric($params["valeur"]) &&
        isset($params["caracteristique"]) && $params["caracteristique"] !== NULL
        ) {
            $this->modificateur = $params["modificateur"];
            $this->valeur = $params["valeur"];
            $this->caracteristique = $params["caracteristique"];
        } else {
            throw new Exception("Paramètre(s) manquant(s) ou invalide(s) pour la création d'un objet Effet");
        }
    }

}