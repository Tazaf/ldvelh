<?php

class Objet_Possession {

    /**
     * L'identifiant en base de donnée de la possession.
     * @var int 
     */
    public $id;

    /**
     * Le nom de la possession.
     * @var String 
     */
    public $nom;

    /**
     * Le type de possession.
     * @var String 
     */
    public $type;

    /**
     * Un tableau contenant le ou les effets de la possession. Peut être vide.
     * @var array 
     */
    public $effets;

    /**
     * Construit un nouvel objet Possession. Les données passées dans le constructeur doivent être sous forme de tableau associatif :
     * <p>array(<br>
     *     $params["id"] => <i>L'identifiant en base de donnée de la possession.</i><br>
     *     $params["nom"] => <i>Le nom de la possession.</i><br>
     *     $params["type"] => <i>Le type de possession.</i><br>
     * )</p>
     * 
     * À sa construction, un objet Possession ne possède aucun effet. Il est possible de rajouter un effet en utilisant la méthode addEffect().
     * @param array $params
     * @throws Exception Cette exception se lance si l'un des paramètres n'est pas présent ou valide.
     */
    public function __construct($params) {
        if (
        isset($params["id"]) && $params["id"] !== NULL && is_numeric($params["id"]) &&
        isset($params["nom"]) && $params["nom"] !== NULL &&
        isset($params["type"]) && $params["type"] !== NULL
        ) {
            $this->id = $params["id"];
            $this->nom = $params["nom"];
            $this->type = $params["type"];
            $this->effets = array();
        } else {
            throw new Exception("Paramètre(s) manquant(s) ou invalide(s) pour la création d'un objet Possession.");
        }
    }

    /**
     * Ajoute un effet (Objet_Effet) à une possession dans sa liste d'effets.
     * @param Objet_Effet $effet L'effet à ajouter à la possession.
     * @return NULL
     */
    public function addEffect(Objet_Effet $effet) {
        if ($effet !== NULL) {
            $this->effets[] = $effet;
            $effet = NULL;
        }
        return $effet;
    }

}