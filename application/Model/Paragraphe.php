<?php

class Model_Paragraphe {

    /**
     * Requête SQL pour sélectionner les paragraphes dont le ou les combat(s) n'a pas encore été effectué par un personnage.
     */
    const GET_ALL_FOR_PERSONA = "
        SELECT *
        FROM paragraphe
        WHERE numero NOT IN (
            SELECT paragraphe_numero
            FROM combat
            WHERE personnage_nom = :nom AND victoire = true
        )
    ";

    /**
     * Contient la connexion PDO à la base de donnée pour l'exécution des requêtes SQL.
     * @var PDO La connexion PDO à la base de donnée.
     */
    protected $bdconnect;

    /**
     * Construit un nouveau modele de paragraphe.
     * À sa construction, la propriété bdconnect du modèle est initialisée avec une nouvelle connexion PDO créée à partir des informations de connection initialisées dans le bootstrap.
     */
    public function __construct() {
        $this->bdconnect = Util_Registery::getInstance()->get("bd");
    }

    /**
     * Récupère tous les paragraphes contenant des combats non-effectués par le personnage.
     * @param string $nom Le nom du personnage dont on souhaite récupérer les paragraphes restants.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAvailable($nom) {
        $params = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::GET_ALL_FOR_PERSONA);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
