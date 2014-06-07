<?php

class Model_Monstre {

    /**
     * Requête SQL pour la sélection des monstres présents sur un certain paragraphe.
     */
    const GET_MONSTERS = "
        SELECT monstre.*
        FROM population
        INNER JOIN monstre ON monstre.id = population.monstre_id
        WHERE population.paragraphe_numero = :numero
    ";
    
    /**
     * Requête SQL pour la sélection d'un monstre.
     */
    const GET_ONE = "
        SELECT *
        FROM monstre
        WHERE id = :id
    ";

    /**
     * Contient la connexion PDO à la base de donnée pour l'exécution des requêtes SQL.
     * @var PDO La connexion PDO à la base de donnée.
     */
    protected $bdconnect;

    /**
     * Construit un nouveau modele de monstre.
     * À sa construction, la propriété bdconnect du modèle est initialisée avec une nouvelle connexion PDO créée à partir des informations de connection initialisées dans le bootstrap.
     */
    public function __construct() {
        $this->bdconnect = Util_Registery::getInstance()->get("bd");
    }

    /**
     * Récupère les données des monstres présents dans un paragraphe.
     * @param int $numero Le numéro du paragraphe dont on souhaite récupérer les monstres.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetMonsters($numero) {
        $params = array(":numero" => $numero);
        $sql = $this->bdconnect->prepare(self::GET_MONSTERS);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupére les données d'un monstre selon son id.
     * @param int $id L'id du monstre à récupérer.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetOne($id) {
        $params = array(":id" => $id);
        $sql = $this->bdconnect->prepare(self::GET_ONE);
        $sql->execute($params);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
