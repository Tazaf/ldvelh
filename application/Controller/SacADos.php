<?php

/**
 * Concerne le Controller pour les sac à dos.
 * Permet de travailler sur et avec les données des sac à dos transmises par l'utilisateur.
 */
class Controller_SacADos extends Controller {

    /**
     * Affiche le contenu du sac à dos d'un personnage. Le nom du personnage doit être passé en paramètre.
     * Un objet sac est ensuite créé avec le nom du personnage. Si cet objet n'est pas NULL, le processus continue et le sac est affiché.
     * Sinon, une redirection vers la page principale est effectuée.
     */
    public function showBagContent() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $sac = $this->getContent($nom);
        if ($sac != FALSE) {
            try {
                $model = new Model_Personnage();
                $personnage = new Objet_Personnage($model->bdGetOne($nom));
                $template = new Smarty();
                $template->assign("personnage", $personnage);
                $template->assign("titre", $nom . " - Sac à ");
                $template->assign("onglet", "sac");
                $template->assign("contenu", $sac->contenu);
                $template->display(TPL_PATH . "sac.tpl");
            } catch (Exception $exc) {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

    /**
     * Permet de récupérer le contenu du sac à dos d'un personnage.
     * Ce contenu aura la forme d'un objet SacADos contenant un tableau d'objets Possession.
     * Chaque objet Possession contiendra ses objets Effets associés.
     * @param type $nom Le nom du personnage dont l'on souhaite récupérer le contenu du sac à dos.
     * @return boolean : retourne FALSE si le nom a comme valeur NULL | \Objet_SacADos Un SacADos contenant toutes les possessions du personnage.
     */
    public function getContent($nom) {
        $controller = new Controller_Personnage();
        if (!is_null($nom)) {
            $sac = new Objet_SacADos();
            $model = new Model_SacADos();
            $content = $model->bdGetBagContent($nom);
            foreach ($content as $ligne) {
                $controller = new Controller_Possession();
                $sac->addPossession($controller->bdgetOne($ligne["id"]), $ligne["quantite"]);
            }
            return $sac;
        } else {
            return FALSE;
        }
    }

    /**
     * Permet d'ajouter une nouvelle possession à un personnage en renseignant le nom du personnage, l'id de cette possession ainsi que la quantité ajoutée.
     * Si la possession est déjà présente dans le sac à dos du personnage, la quantité de cette possession est augmentée.
     * Si la possession n'est pas présente dans le sac à dis du personnage, elle est rajoutée.
     * La méthode redirige ensuite vers l'affichage du sac à dos nouvelle modifié.
     * Si un paramètre est absent ou invalide une redirection vers la page de statut du personnage.
     */
    public function addPossession() {
        $nom = isset($_REQUEST['nom']) ? urldecode($_REQUEST['nom']) : NULL;
        $possession_id = isset($_REQUEST['possession_id']) ? $_REQUEST['possession_id'] : NULL;
        $quantite = isset($_REQUEST['quantite']) ? $_REQUEST['quantite'] : NULL;
        if (!is_null($nom) && !is_null($possession_id) && is_numeric($possession_id) && !is_null($quantite) && is_numeric($quantite)) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model = new Model_SacADos();
                $check = $model->bdGetPossessionQuantity($nom, $possession_id);
                if (!isset($check["quantite"])) {
                    $model->bdAddPossession($nom, $possession_id, $quantite);
                } else {
                    $quantite += $check["quantite"];
                    if ($quantite > 99) {
                        $quantite = 99;
                    }
                    $model->bdChangePossessionQuantity($nom, $possession_id, $quantite);
                }
                Util_Registery::getInstance()->get("bd")->commit();
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollBack();
                echo $exc->getTraceAsString();
            }
            $this->redirect("SacADos", "showBagContent", array("nom" => urlencode($nom)));
        }
        $this->redirect("Personnage", "showStatus", array("nom" => urlencode($nom)));
    }

/////////////////////////////////
// METHODES APPELLEES PAR AJAX //
/////////////////////////////////

    /**
     * Modifie la quantité d'une possession dans le sac à dos d'un personnage en renseignant le nom du personnage, l'id de la possession et la quantité souhaité.
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function changePossessionQuantity() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $possession_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
        $valeur = isset($_REQUEST['valeur']) ? $_REQUEST['valeur'] : NULL;
        if (!is_null($nom) && !is_null($possession_id) && is_numeric($possession_id) && !is_null($valeur) && is_numeric($valeur)) {
            $model = new Model_SacADos;
            $quantite = $model->bdGetPossessionQuantity($nom, $possession_id);
            $quantite = $quantite["quantite"] + $valeur;
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                if ($quantite > 0) {
                    $model->bdChangePossessionQuantity($nom, $possession_id, $quantite);
                } else {
                    $model->bdRemoveOne($nom, $possession_id);
                }
                Util_Registery::getInstance()->get("bd")->commit();
                echo TRUE;
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollBack();
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

    /**
     * Retire une possession du sac à dos d'un personnage en renseignant le nom du personnage et l'id de la possession.
     * Si un paramètre est absent ou invalide ou si une erreur survient, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function removePossession() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $possession_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
        if (!is_null($nom) && !is_null($possession_id) && is_numeric($possession_id)) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model = new Model_SacADos;
                $model->bdRemoveOne($nom, $possession_id);
                Util_Registery::getInstance()->get("bd")->commit();
                echo TRUE;
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollBack();
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
