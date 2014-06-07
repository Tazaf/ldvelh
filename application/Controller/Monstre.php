<?php

/**
 * Concerne le Controller pour les monstres.
 * Permet de travailler sur et avec les données des monstres transmises par l'utilisateur.
 */
class Controller_Monstre extends Controller {
    
/////////////////////////////////
// METHODES APPELLEES PAR AJAX //
/////////////////////////////////

    /**
     * Récupère les informations d'un monstre par son id, créé un objet Monstre avec ces données et les transmets au client sous forme d'une chaîne JSON.
     * Si le paramètre id pour le monstre n'est pas présent ou pas valide, une redirection vers la page par défaut est effectuée.
     * Si une erreur survient lors du processus, FALSE est renvoyée au client.
     */
    public function getOne() {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
        if (!is_null($id) && is_numeric($id)) {
            try {
                $model = new Model_Monstre();
                $params = $model->bdGetOne($id);
                $monstre = new Objet_Monstre($params);
                echo json_encode($monstre);
            } catch (Exception $exc) {
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
