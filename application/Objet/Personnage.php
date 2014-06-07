<?php

/**
 * Concerne la classe d'objet personnage. Représente les données d'un personnage.
 */
class Objet_Personnage {

    /**
     * Le nom du personnage
     * @var string 
     */
    public $nom;

    /**
     * L'habileté maximale d'un personnage
     * @var int 
     */
    public $habileteMax;

    /**
     * L'habileté actuelle d'un personnage
     * @var int 
     */
    public $habilete;

    /**
     * L'endurance maximale d'un personnage
     * @var int 
     */
    public $enduranceMax;

    /**
     * L'endurance actuelle d'un personnage
     * @var int 
     */
    public $endurance;

    /**
     * La chance maximale d'un personnage
     * @var int 
     */
    public $chanceMax;

    /**
     * La chance actuelle d'un personnage
     * @var int 
     */
    public $chance;

    /**
     * Le nombre de repas dont dispose le personnage
     * @var int 
     */
    public $repas;

    /**
     * Le nombre de pièces d'or dans la bourse du personnage
     * @var int 
     */
    public $bourse;

    /**
     * Un tableau contenant un ou des objets Possessions représentant les possessions du personnage. Peut être vide.
     * @var Objet_SacADos 
     */
    public $sac_a_dos;

    /**
     * Permet de construire un nouvel objet Personnage. Les données passées dans le constructeur doivent être sous forme de tableau associatif :
     * <p>array(<br>
     *     $params["nom"] => <i>Le nom du personnage.</i><br>
     *     $params["habileteMax"] => <i>L'habileté maximum d'un personnage.</i><br>
     *     $params["habilete"] => <i>L'habileté actuelle d'un personnage.</i><br>
     *     $params["enduranceMax"] => <i>L'endurance maximale d'un personnage.</i><br>
     *     $params["endurance"] => <i>L'endurance actuelle d'un personnage.</i><br>
     *     $params["chanceMax"] => <i>La chance maximale d'un personnage.</i><br>
     *     $params["chance"] => <i>La chance actuelle d'un personnage.</i><br>
     *     $params["repas"] => <i>Le nombre de repas dont dispose le personnage.</i><br>
     *     $params["bourse"] => <i>Le nombre de pièces d'or dans la bourse du personnage.</i><br>
     * )</p>
     * @param array $params Les données du personnage au format adéquat tel que décrit dans la description de la méthode.
     * @throws Exception Une exception est lancée si le paramètre data n'est pas formaté correctement.
     */
    public function __construct(array $params) {
        $params = self::cleanParams($params);
        if ($params !== FALSE) {
            $this->nom = $params["nom"];
            $this->habileteMax = $params["habileteMax"];
            $this->habilete = $params["habilete"];
            $this->enduranceMax = $params["enduranceMax"];
            $this->endurance = $params["endurance"];
            $this->chanceMax = $params["chanceMax"];
            $this->chance = $params["chance"];
            $this->repas = $params["repas"];
            $this->bourse = $params["bourse"];
            $this->sac_a_dos = NULL;
        } else {
            throw new Exception("Paramètres manquants ou invalides pour la création d'un nouvel objet Personnage");
        }
    }

    /**
     * Permet de s'assurer que les propriétés d'un personnage auront toujours une valeur correcte.
     * L'endurance, la chance et l'habilete actuelles ne peuvent être supérieur à leux maximum.
     * Les repas ne peuvent excéder 10.
     * Le contenu de la bourse ne peut être supérieeur à 100'000'000 pièces d'or.
     * Si un paramètre récupérer est faux, il est corriger dans la BD et dans le tableau des paramètres.
     * @param array $params Les paramètres à vérifier pour la création d'un instance.
     * @return boolean : FALSE si les paramètres ne sont pas présents ou qu'une erreur survient | array : un tableau contenant tous les paramètres nettoyés.
     */
    private static function cleanParams(array $params) {
        if (self::checkParamsValidity($params)) {
            try {
                $model = new Model_Personnage();
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                if ($params["habilete"] > $params["habileteMax"]) {
                    $model->bdModifyStatValue($params["nom"], "habilete", $params["habileteMax"]);
                    $params["habilete"] = $params["habileteMax"];
                }
                if ($params["endurance"] > $params["enduranceMax"]) {
                    $model->bdModifyStatValue($params["nom"], "endurance", $params["enduranceMax"]);
                    $params["endurance"] = $params["enduranceMax"];
                }
                if ($params["chance"] > $params["chanceMax"]) {
                    $model->bdModifyStatValue($params["nom"], "chance", $params["chanceMax"]);
                    $params["chance"] = $params["chanceMax"];
                }
                if ($params["repas"] > 10) {
                    $model->bdModifyStatValue($params["nom"], "repas", 10);
                    $params["repas"] = 10;
                }
                if ($params["bourse"] > 100000000) {
                    $model->bdModifyStatValue($params["nom"], "bourse", 100000000);
                    $params["bourse"] = 100000000;
                }
                Util_Registery::getInstance()->get("bd")->commit();
                return $params;
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollback();
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Vérifie la présence et la validité des données présentes dans le tableau des paramètres pour la création d'un nouveau personnage
     * @param array $params Un tableau contenant les paramètres à tester
     * @return boolean TRUE si les paramètres sont OK, FALSE si il y a une erreur
     */
    private static function checkParamsValidity($params) {
        return isset($params["nom"]) && $params["nom"] !== NULL &&
        isset($params["habileteMax"]) && $params["habileteMax"] !== NULL && is_numeric($params["habileteMax"]) &&
        isset($params["habilete"]) && $params["habilete"] !== NULL && is_numeric($params["habilete"]) &&
        isset($params["enduranceMax"]) && $params["enduranceMax"] !== NULL && is_numeric($params["enduranceMax"]) &&
        isset($params["endurance"]) && $params["endurance"] !== NULL && is_numeric($params["endurance"]) &&
        isset($params["chanceMax"]) && $params["chanceMax"] !== NULL && is_numeric($params["chanceMax"]) &&
        isset($params["chance"]) && $params["chance"] !== NULL && is_numeric($params["chance"]) &&
        isset($params["repas"]) && $params["repas"] !== NULL && is_numeric($params["repas"]) &&
        isset($params["bourse"]) && $params["bourse"] !== NULL && is_numeric($params["bourse"]);
    }

}
