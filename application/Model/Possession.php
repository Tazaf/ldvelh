<?php

/**
 * Concerne le Model pour les possessions.
 * Permet de travailler sur et avec les données des possessions présentes dans la base de données.
 */
class Model_Possession {
    
    /**
     * Requête SQL pour récupérer les informations d'une possession.
     */
    const GET_ONE = "
        SELECT id, nom, type_nom AS type
        FROM possession
        WHERE id = :id
    ";

    /**
     * Requête SQL pour récupérer les informations de toutes les possessions excepté les trois premiers identifiants.
     */
    const GET_ALL = "
        SELECT *
        FROM possession
        WHERE id NOT IN (1, 2, 3)
        ORDER BY nom
    ";

    /**
     * Contient la connexion PDO à la base de donnée pour l'exécution des requêtes SQL.
     * @var PDO La connexion PDO à la base de donnée.
     */
    protected $bdconnect;

    /**
     * Construit un nouveau modele de possessions.
     * À sa construction, la propriété bdconnect du modèle est initialisée avec une nouvelle connexion PDO créée à partir des informations de connection initialisées dans le bootstrap.
     */
    public function __construct() {
        $this->bdconnect = Util_Registery::getInstance()->get("bd");
    }

    /**
     * Récupère les données d'une possession en indiquant son identifiant.
     * @param int $id L'identifiant de la possession à récupérer.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdgetOne($id) {
        $params = array(":id" => $id);
        $sql = $this->bdconnect->prepare(self::GET_ONE);
        $sql->execute($params);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le nom et l'identifiant de toutes les possessions inscrites dans la BD.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAll() {
        $sql = $this->bdconnect->query(self::GET_ALL);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}