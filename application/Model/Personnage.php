<?php

/**
 * Concerne le Model pour les personnages.
 * Permet de travailler sur et avec les données des personnages présentes dans la base de données.
 */
class Model_Personnage {

    /**
     * Requête SQL pour la sélection de tous les personnages vivants.
     */
    const GET_ALL_ALIVE = "
        SELECT *
        FROM `personnage`
        WHERE endurance > 0
    ";
    
    /**
     * Requête SQL pour la sélection de tous les personnages morts.
     */
    const GET_ALL_DEAD = "
        SELECT *
        FROM personnage
        WHERE endurance = 0
    ";

    /**
     * Requête SQL pour la sélection d'un seul personnage.
     */
    const GET_ONE = "
        SELECT *
        FROM `personnage`
        WHERE `nom` = :nom
    ";

    /**
     * Requête SQL pour l'ajout d'un nouveau personnage.
     */
    const CREATE_NEW = "
        INSERT INTO `personnage` (`nom`, `habileteMax`, `habilete`, `enduranceMax`, `endurance`, `chanceMax`, `chance`)
        VALUES (:nom, :habileteMax, :habilete, :enduranceMax, :endurance, :chanceMax, :chance)
    ";

    /**
     * Requête SQL pour la suppression d'un seul personnage.
     */
    const DELETE_ONE = "
        DELETE FROM `personnage`
        WHERE `nom` = :nom
    ";

    /**
     * Requête SQL pour modifier la valeur d'une statistique d'un personnage.
     */
    const MODIFY_STAT_VALUE = "
        UPDATE `personnage`
        SET `%s` = :value
        WHERE `nom` = :nom
    ";

    /**
     * Contient la connexion PDO à la base de donnée pour l'exécution des requêtes SQL.
     * @var PDO La connexion PDO à la base de donnée.
     */
    protected $bdconnect;

    /**
     * Construit un nouveau modele de personnages.
     * À sa construction, la propriété bdconnect du modèle est initialisée avec une nouvelle connexion PDO créée à partir des informations de connection initialisées dans le bootstrap.
     */
    public function __construct() {
        $this->bdconnect = Util_Registery::getInstance()->get("bd");
    }

    /**
     * Permet de récupérer les informations de tous les personnages vivants (dont l'endurance est supérieure à 0) présents dans la table personnage.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAllAlive() {
        $sql = $this->bdconnect->query(self::GET_ALL_ALIVE);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Permet de récupérer les informations de tous les personnages morts (dont l'endurance est égale à 0) présents dans la table personnage.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAllDead() {
        $sql = $this->bdconnect->query(self::GET_ALL_DEAD);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Permet de récupérer les informations d'un personnage présent dans la table personnage selon le nom passé en paramètre.
     * @param string $nom Le nom du personnage duquel récupérer les informations.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetOne($nom) {
        $parameters = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::GET_ONE);
        $sql->execute($parameters);
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        if ($res === FALSE) {
            throw new Exception;
        } else {
            return $res;
        }
    }

    /**
     * Permet d'ajouter un nouveau personnage dans la base de données dont le nom sera celui passé en paramètre et les caractéristiques celles passées en paramètres.
     * @param string $nom Le nom du nouveau personnage.
     * @param int $habilete L'habileté du nouveau personnage. Cette valeur sera affectée aussi bien à l'habileté Max qu'à l'habileté actuelle de ce personnage.
     * @param int $endurance L'endurance du nouveau personnage. Cette valeur sera affectée aussi bien à l'endurance Max qu'à l'endurance actuelle de ce personnage.
     * @param int $chance La chance du nouveau personnage. Cette valeur sera affectée aussi bien à la chance Max qu'à la chance actuelle de ce personnage.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdCreateNew($nom, $habilete, $endurance, $chance) {
        $parameters = array(
            ":nom" => $nom,
            ":habileteMax" => $habilete,
            ":habilete" => $habilete,
            ":enduranceMax" => $endurance,
            ":endurance" => $endurance,
            ":chanceMax" => $chance,
            ":chance" => $chance
        );
        $sql = $this->bdconnect->prepare(self::CREATE_NEW);
        $res = $sql->execute($parameters);
        if ($res == FALSE) {
            throw new Exception();
        }
    }

    /**
     * Permet de supprimer un personnage de la table personnage selon son nom.
     * @param string $nom Le nom du personnage à supprimer.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdDeleteOne($nom) {
        $parameters = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::DELETE_ONE);
        $res = $sql->execute($parameters);
        if ($res == FALSE) {
            throw new Exception();
        }
    }

    /**
     * Permet de modifier une statistique d'un personnage en indiquant le nom de la statistique, la nouvelle valeur de la statistique et le nom du personnage dont on souhaite modifier la statistique.
     * @param string $nom Le nom du personnage sur lequel modifier la statistique.
     * @param string $stat Le nom de la statistique dont on souhaite modifier la valeur.
     * @param int $valeur La valeur de la statistique.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdModifyStatValue($nom, $stat, $valeur) {
        $parameters = array(
            ":value" => $valeur,
            ":nom" => $nom
        );
        $request = sprintf(self::MODIFY_STAT_VALUE, $stat);
        $sql = $this->bdconnect->prepare($request);
        $res = $sql->execute($parameters);
        if ($res == FALSE) {
            throw new Exception();
        }
    }

}
