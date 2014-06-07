<?php

/**
 * Concerne le Controller pour les personnages.
 * Permet de travailler sur et avec les données des personnages transmises par l'utilisateur.
 */
class Controller_Personnage extends Controller {

    /**
     * Affiche la page d'accueil listant tous les personnages présents, s'il en existe.
     */
    public function showAll() {
        $model = new Model_Personnage();
        $params_vivants = $model->bdGetAllAlive();
        $perso_vivants = array();
        foreach ($params_vivants as $params) {
            $perso_vivants[] = new Objet_Personnage($params);
        }
        $params_morts = $model->bdGetAllDead();
        $perso_morts = array();
        foreach ($params_morts as $params) {
            $perso_morts[] = new Objet_Personnage($params);
        }
        $template = new Smarty();
        $template->assign("titre", "Choix du personnage");
        $template->assign("perso_vivants", $perso_vivants);
        $template->assign("perso_morts", $perso_morts);
        $template->display(TPL_PATH . "personnage.tpl");
    }

    /**
     * Affiche l'interface de l'application pour un seul personnage selon son nom.
     * Si le nom est manquant lors de l'appel de la méthode, une redirection est lancée sur l'affichage de tous les personnages.
     * Si la requête ne retourne aucun personnage, une redirection est lancée sur l'affichage de tous les personnages.
     */
    public function showStatus() {
        $nom = isset($_REQUEST['nom']) ? urldecode($_REQUEST['nom']) : NULL;
        $personnage = $this->getOne($nom);
        if ($personnage !== FALSE) {
            $template = new Smarty();
            $template->assign("titre", $personnage->nom . " - Feuille de personnage");
            $template->assign("onglet", "statut");
            $template->assign("personnage", $personnage);
            $template->display(TPL_PATH . "statut.tpl");
        } else {
            $this->redirect();
        }
    }

    /**
     * Permet de récupérer une instance de Personnage contenant les informations du personnage (excepté le contenu de son sac à dos qui devra être récupérer avec le Controller_SacADos).
     * @param type $nom Le nom du personnage dont l'on souhaite récupérer les informations.
     * @return boolean : Une erreur est survenue lors de la création de l'instance|\Objet_Personnage L'instanciation s'est correctement effectuée et un Objet Personnage est retourné.
     */
    public function getOne($nom) {
        if (!is_null($nom)) {
            try {
                $model = new Model_Personnage();
                $params = $model->bdGetOne($nom);
                $personnage = new Objet_Personnage($params);
                return $personnage;
            } catch (Exception $exc) {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Permet d'ajouter un nouveau personnage. Ce personnage doit posséder un nom. Ses autres propriétés prendront leur valeur par défaut : 0.
     * Après la création de ce nouveau personnage, la possession choisie lors de sa création lui sera ajoutée dans son sac à dos.
     * Une fois les possessions ajoutées, une redirection vers la page de statut de ce nouveau personnage est effectuée.
     * Si le nom n'est pas envoyé en paramètre, une redirection vers la page d'accueil est effectuée.
     * Si l'inscription du nouveau personnage dans la base de donnée à échouer, une redirection vers la page d'accueil est effectuée.
     */
    public function createNew() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $potion = isset($_REQUEST['potion']) ? $_REQUEST['potion'] : NULL;
        $quantite = isset($_REQUEST['quantite']) ? $_REQUEST['quantite'] : NULL;
        if (!is_null($nom) && !is_null($potion) && is_numeric($potion) && !is_null($quantite) && is_numeric($quantite)) {
            $habilete = rand(1, 6) + 6;
            $endurance = rand(1, 12) + 12;
            $chance = rand(1, 6) + 6;
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model_personnage = new Model_Personnage();
                $model_personnage->bdCreateNew($nom, $habilete, $endurance, $chance);
                $model_sac_a_dos = new Model_SacADos();
                // Ajout de la potion sélectionnée lors de la création du personnage
                $res = $model_sac_a_dos->bdAddPossession($nom, $potion, $quantite);
                if ($res === FALSE) {
                    throw new Exception;
                }
                // Ajout de l'équipement de base : Épée, Armure de cuir et Lanterne (id : 4, 5, 6)
                for ($i = 4; $i <= 6; $i++) {
                    $res = $model_sac_a_dos->bdAddPossession($nom, $i, 1);
                    if ($res === FALSE) {
                        throw new Exception;
                    }
                }
                Util_Registery::getInstance()->get("bd")->commit();
                $this->redirect("Personnage", "showStatus", array("nom" => urlencode($nom)));
            } catch (Exception $exc) {
                Util_Registery::getInstance()->get("bd")->rollBack();
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
     * Permet de supprimer un personnage en indiquant son nom.
     * Retire dans un premier temps toutes les possessions de ce personnage dans son sac à dos.
     * Supprime ensuite tous les logs de combats du personnage.
     * Enfin, supprime le personnage de la table des personnages.
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function deleteOne() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        if (!is_null($nom)) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model_sac_a_dos = new Model_SacADos();
                $model_sac_a_dos->bdRemoveAll($nom);
                $model_combat = new Model_Combat();
                $model_combat->bdDeleteAllForPersona($nom);
                $model = new Model_Personnage();
                $model->bdDeleteOne($nom);
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
     * Permet de modifier une caractérstique d'un personnage.
     * Les caractéristiques possibles sont : habilete, habileteMax, endurance, enduranceMax, chance, chanceMax, repas ou bourse.
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function modifyOneStat() {
        $white_list = [
            "habilete",
            "habileteMax",
            "endurance",
            "enduranceMax",
            "chance",
            "chanceMax",
            "repas",
            "bourse"
        ];
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $stat = isset($_REQUEST['stat']) ? $_REQUEST['stat'] : NULL;
        $valeur = isset($_REQUEST['valeur']) ? $_REQUEST['valeur'] : NULL;
        if (!is_null($nom) && !is_null($stat) && in_array($stat, $white_list) && !is_null($valeur) && is_numeric($valeur)) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model = new Model_Personnage();
                $model->bdModifyStatValue($nom, $stat, $valeur);
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
     * Permet de modifier toutes les statistiques du personnages selon les valeurs indiquées.
     * Le nom du personnage doit être indiqué. Si ce n'est pass le cas, une redirection vers la page d'accueil est effectuée.
     * Les valeurs doivent prendre la forme d'un objet JSON formaté comme suit :
     * {
     *  "habilete" => valeur
     *  "endurance" => valeur
     *  "chance" => valeur
     *  "repas" => valeur
     *  "bourse" => valeur
     * }
     * Si un des paramètres n'est pas présent ou est invalide ou si une erreur survient dans le porcessus, retourne FALSE.
     * Sinon, retourne TRUE.
     */
    public function modifyAllStats() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $values = isset($_REQUEST['values']) ? json_decode($_REQUEST['values']) : NULL;
        if (!is_null($nom) && !is_null($values)) {
            try {
                Util_Registery::getInstance()->get("bd")->beginTransaction();
                $model = new Model_Personnage();
                foreach ($values as $stat => $value) {
                    $model->bdModifyStatValue($nom, $stat, $value);
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
     * Permet de vérifier si un personnage existe dans la base de donnée en indiquant le nom du personnage.
     * Si le nom est déjà présent dans la base, retourne TRUE. Sinon, si le nom n'est pas présent, retourne FALSE.
     */
    public function checkOne() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        if (!is_null($nom)) {
            try {
                $model = new Model_Personnage();
                $model->bdGetOne($nom);
                echo TRUE;
            } catch (Exception $exc) {
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
