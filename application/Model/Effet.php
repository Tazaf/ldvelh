<?php

class Model_Effet {

    /**
     * Requête SQL pour récupérer tous les effets d'une possession.
     */
    const GET_ALL = "
        SELECT effet_modificateur AS modificateur, effet_valeur AS valeur, effet_caracteristique_nom AS caracteristique
        FROM possession_effet
        WHERE possession_id = :id
        ORDER BY effet_valeur DESC
    ";
    
    /**
     * Requête SQL pour récupérer les effets de malus d'un paragraphe
     */
    const GET_MALUS = "
        SELECT effet_modificateur AS modificateur, effet_valeur AS valeur, effet_caracteristique_nom AS caracteristique
        FROM malus
        WHERE paragraphe_numero = :numero
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
     * Récupère tous les effets associés à une possession. Demande l'id de la possession.
     * @param int $id L'id de la possession pour laquelle on souhaite récupérer les effets.
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetAllForPossession($id) {
        $params = array(":id" => $id);
        $sql = $this->bdconnect->prepare(self::GET_ALL);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupére le malus d'un paragraphe selon son numéro.
     * @param int $numero Le numéro du paragraphe dont on souhaite récupérer le malus
     * @return array Un tableau associatif contenant les résultats de la requête SQL.
     */
    public function bdGetMalus($numero) {
        $params = array(":numero" => $numero);
        $sql = $this->bdconnect->prepare(self::GET_MALUS);
        $sql->execute($params);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
