<?php

/**
 * Concerne le Controller pour les paragrapnes.
 * Permet de travailler sur et avec les données des paragraphes transmises par l'utilisateur.
 */
class Controller_Paragraphe extends Controller {

    /**
     * Récupère les données relatives à un paragraphe selon son numéro et retourne au client une structure JSON contenant les données du paragraphe :
     * - Son numéro
     * - Un objet Effet contenant les données du malus
     * - Un ou plusieurs objets Monstres pour chaque monstre présent dans le paragraphe.
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function getParagrapheData() {
        $numero = isset($_REQUEST['numero']) ? $_REQUEST['numero'] : NULL;
        if (!is_null($numero) && is_numeric($numero)) {
            try {
                $model = new Model_Effet();
                $params = $model->bdGetMalus($numero);
                $malus = $params !== FALSE ? new Objet_Effet($model->bdGetMalus($numero)) : NULL;
                $monstres = array();
                $model = new Model_Monstre();
                $all_monstres = $model->bdGetMonsters($numero);
                foreach ($all_monstres as $params) {
                    $monstres[] = new Objet_Monstre($params);
                }
                $paragraphe = new Objet_Paragraphe($numero, $monstres, $malus);
                echo json_encode($paragraphe);
            } catch (Exception $exc) {
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
