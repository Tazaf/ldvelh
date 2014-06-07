<?php

/**
 * Concerne le Controller pour les combats.
 * Permet de travailler sur et avec les données des combats transmises par l'utilisateur.
 */
class Controller_Combat extends Controller {

    /**
     * Affiche la liste des combats effectuées par un personnage en récupérant les données du personnage, de ses combats et en les affichant dans le template combat.tpl
     */
    public function showCombatLog() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        if ($nom != NULL) {
            try {
                $model = new Model_Combat();
                $combat_log = $model->bdGetAll($nom);
                $model = new Model_Paragraphe();
                $paragraphes = $model->bdGetAvailable($nom);
                $template = new Smarty();
                $model = new Model_Personnage();
                $personnage = new Objet_Personnage($model->bdGetOne($nom));
                $template->assign("personnage", $personnage);
                $template->assign("titre", $nom . " - Combats");
                $template->assign("onglet", "combat");
                $template->assign("combat_log", $combat_log);
                $template->assign("paragraphes", $paragraphes);
                $template->display(TPL_PATH . "combat.tpl");
            } catch (Exception $exc) {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

/////////////////////////////////
// METHODES APPELLEES PAR AJAX //
/////////////////////////////////

    /**
     * Ajoute le résultat d'un combat pour un personnage contre un monstre.
     * Lors de l'appel à cette méthode, un nom (de personnage), un numéro (de paragraphe), un id (de monstre) et un résultat de victoire (1 ou 0) doivent être passées en GET ou POST
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function addOneForPersona() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $numero = isset($_REQUEST['numero']) ? $_REQUEST['numero'] : NULL;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
        $victoire = isset($_REQUEST['victoire']) ? $_REQUEST['victoire'] : NULL;
        if (
        !is_null($nom) &&
        !is_null($numero) && is_numeric($numero) &&
        !is_null($id) && is_numeric($id) &&
        !is_null($victoire) && ($victoire == 1 || $victoire == 0)
        ) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model = new Model_Combat();
                $model->bdAddOneForPersona($victoire, $id, $numero, $nom);
                Util_Registery::getInstance()->get("bd")->commit();
                echo TRUE;
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollback();
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
