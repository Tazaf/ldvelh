<?php

class Model_Combat {

    /**
     * Requête SQL pour récupérer les données des combats effectués par un personnage.
     */
    const GET_ALL = "
        SELECT *
        FROM combat
        INNER JOIN monstre ON monstre.id = combat.monstre_id
        WHERE personnage_nom = :nom
        ORDER BY combat.id DESC
    ";
    
    /**
     * Requête SQL pour l'ajout d'un résultat de combat pour un personnage donnée.
     */
    const ADD_ONE_FOR_PERSONA = "
        INSERT INTO combat (victoire, monstre_id, paragraphe_numero, personnage_nom)
        VALUES (:victoire, :id, :numero, :nom)
    ";

    /**
     * Requête SQL pour supprimer tous les combats d'un personnage.
     */
    const DELETE_ALL = "
        DELETE FROM `combat`
        WHERE `personnage_nom` = :nom
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
     * Récupère tous les résultats de combats pour un personnage donnée.
     * @param string $nom Le nom du personnage donc on souhaite récupérer les résultats de combats.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAll($nom) {
        $params = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::GET_ALL);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Ajoute un résultat de combat à un personnage.
     * @param boolean $victoire Le résultat du combat. 1 : victoire. 0 : Défaite.
     * @param int $id L'id du monstre combattu.
     * @param int $numero Le numéro du paragraphe dans lequel s'est déroulé le combat.
     * @param string $nom Le nom du personnage qui a combattu.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdAddOneForPersona($victoire, $id, $numero, $nom) {
        $params = array(
            ":victoire" => $victoire,
            ":id" => $id,
            ":numero" => $numero,
            ":nom" => $nom
        );
        $sql = $this->bdconnect->prepare(self::ADD_ONE_FOR_PERSONA);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception;
        }
    }

    /**
     * Permet de supprimer tous les combats auxquels a participé un personnage en indiquant le nom du personnage.
     * @param string $nom Le nom du personnage à supprimer.
     * @throws Exception Si la requête SQL a échoué, une exception est lancée.
     */
    public function bdDeleteAllForPersona($nom) {
        $params = array(":nom" => $nom);
        $sql = $this->bdconnect->prepare(self::DELETE_ALL);
        $res = $sql->execute($params);
        if ($res === FALSE) {
            throw new Exception;
        }
    }

}
