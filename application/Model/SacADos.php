<?php

/**
 * Concerne le Model pour les sac à dos.
 * Permet de travailler sur et avec les données des sac à dos présentes dans la base de données.
 */
class Model_SacADos {

    /**
     * Requête SQL pour la récupération du contenu d'un sac.
     */
    const GET_ALL_CONTENT = "
        SELECT possession_id AS id, quantite
        FROM sac_a_dos
        INNER JOIN possession ON possession.id = sac_a_dos.possession_id
        WHERE personnage_nom = :nom
        ORDER BY possession.nom
    ";

    /**
     * Requête SQL pour récupérer la quantité d'une possession présente dans un sac à dos d'un personnage.
     */
    const GET_QUANTITY = "
        SELECT quantite
        FROM sac_a_dos
        WHERE personnage_nom = :nom AND possession_id = :id
    ";

    /**
     * Requête SQL pour l'ajout d'une possession dans le sac à dos d'un personnage.
     */
    const ADD_ONE_IN_PERSONA_BAG = "
        INSERT INTO `sac_a_dos` (`possession_id`, `personnage_nom`, `quantite`)
        VALUES (:id, :nom, :quantite)
    ";

    /**
     * Requête SQL pour modifier la quantité d'une possession dans le sac à dos d'un personnage.
     */
    const CHANGE_QUANTITY = "
        UPDATE `sac_a_dos`
        SET `quantite` = :quantite
        WHERE `possession_id` = :id AND `personnage_nom` = :nom
    ";

    /**
     * Requête SQL pour supprimer une possession du sac à dos d'un personnage.
     */
    const REMOVE_ONE_FROM_BAG = "
        DELETE FROM sac_a_dos
        WHERE personnage_nom = :nom AND possession_id = :id
    ";

    /**
     * Requête SQL pour la suppression des possessions dans le sac à dos d'un personnage.
     */
    const REMOVE_ALL_FROM_BAG = "
        DELETE FROM `sac_a_dos`
        WHERE `personnage_nom` = :nom
    ";

    /**
     * Contient la connexion PDO à la base de donnée pour l'exécution des requêtes SQL.
     * @var PDO La connexion PDO à la base de donnée.
     */
    protected $bdconnect;

    /**
     * Construit un nouveau modele de sac à dos.
     * À sa construction, la propriété bdconnect du modèle est initialisée avec une nouvelle connexion PDO créée à partir des informations de connection initialisées dans le bootstrap.
     */
    public function __construct() {
        $this->bdconnect = Util_Registery::getInstance()->get("bd");
    }

    /**
     * Récupére le contenu d'un sac à dos en indiquant le nom du personnage qui possède ce sac à dos.
     * @param string $nom Le nom du personnage dont on souhaite récupérer les informations de sac à dos.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetBagContent($nom) {
        $params = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::GET_ALL_CONTENT);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le nombre d'exemplaire d'une certaine possession dans le sac à dos d'un certain personnage.
     * @param string $nom Le nom du personnage qui possède la sac à dos contenant la possession.
     * @param int $id L'id de la possession dont on souhaite vérifier le nombre d'exemplaires.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetPossessionQuantity($nom, $id) {
        $params = array(
            ":nom" => $nom,
            ":id" => $id
        );
        $sql = $this->bdconnect->prepare(self::GET_QUANTITY);
        $sql->execute($params);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Permet d'ajouter une possession à un sac à dos d'un personnage en renseignant le nom du personnage et l'id de la possession.
     * @param string $nom Le nom du personnage au sac à dos duquel on souhaite ajouter la possession.
     * @param int $possession_id L'id de la possession que l'on souhaite ajouter au sac à dos du personnage.
     * @throws Exception Cette exception est lancée si une erreur survient lors de l'exécution de la requête.
     */
    public function bdAddPossession($nom, $possession_id, $quantite) {
        $params = array(
            ":id" => $possession_id,
            ":nom" => $nom,
            ":quantite" => $quantite
        );
        $sql = $this->bdconnect->prepare(self::ADD_ONE_IN_PERSONA_BAG);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception();
        }
    }

    /**
     * Change le nombre d'exemplaire d'une possession dans le sac à dos d'un personnage.
     * @param string $nom Le nom du personnage possédant le sac à dos.
     * @param int $id L'id de la possession dont on souhaite modifier la quantité.
     * @param int $quantite La nouvelle quantité pour la possession.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdChangePossessionQuantity($nom, $id, $quantite) {
        $params = array(
            ":nom" => $nom,
            ":id" => $id,
            ":quantite" => $quantite
        );
        $sql = $this->bdconnect->prepare(self::CHANGE_QUANTITY);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception;
        }
    }

    /**
     * Retire une possession du sac à dos d'un personnage.
     * @param string $nom Le nom du personnage possédant le sac à dos.
     * @param int $id L'id de la possession à retirer.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdRemoveOne($nom, $id) {
        $params = array(
            ":nom" => $nom,
            ":id" => $id
        );
        $sql = $this->bdconnect->prepare(self::REMOVE_ONE_FROM_BAG);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception;
        }
    }

    /**
     * Permet de supprimer toutes les possessions présentes dans le sac d'un personnage en indiquant le nom de ce personnage.
     * @param string $nom Le nom du personnage dont on souhaite supprimer toutes les possessions.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdRemoveAll($nom) {
        $params = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::REMOVE_ALL_FROM_BAG);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception;
        }
    }

}
