<?php

/**
 * Concerne le Controller pour les possessions.
 * Permet de travailler sur et avec les données des possessions transmises par l'utilisateur.
 */
class Controller_Possession extends Controller {

    /**
     * Récupère les données d'une possession selon son id puis créé un objet Possession avec ces données.
     * Récupère ensuite les données du ou des effet(s) de cette possession, créé un objet Effet pour chacun de ces effets et les ajoutes à la Possession.
     * @param int $id L'identifiant de la possession que l'on souhaite récupérer.
     * @return \Objet_Possession : Le processus s'est correctement déroulé | boolean : Une erreur est survenue lors du processus.
     */
    public function bdgetOne($id) {
        if (!is_null($id) && is_numeric($id)) {
            $model = new Model_Possession();
            $possession = new Objet_Possession($model->bdgetOne($id));
            $model = new Model_Effet();
            $effets = $model->bdGetAllForPossession($possession->id);
            foreach ($effets as $effet) {
                $possession->addEffect(new Objet_Effet($effet));
            }
            return $possession;
        } else {
            return FALSE;
        }
    }

/////////////////////////////////
// METHODES APPELLEES PAR AJAX //
/////////////////////////////////

    /**
     * Récupère toutes les possessions et retourne au client une chaîne JSON contenant toutes les informations brutes de ces possessions.
     */
    public function getAll() {
        $model = new Model_Possession();
        $possessions = $model->bdGetAll();
        echo json_encode($possessions);
    }

    /**
     * Permet de simuler l'utilisation d'une possession par un personnage en appliquant les éventuelles effets de cette possession sur ce personnage.
     * Si ce processus s'est correctement déroulé, la méthode redirige ensuite vers le contrôleur de sac à dos pour modifier la quantité de la possession ou la retirer du sac à dos du personnage.
     * Si une erreur survient ou qu'un paramètre est absent ou invalide, retourne FALSE au client.
     */
    public function useOne() {
        $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : NULL;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
        if (!is_null($nom) && !is_null($id) && is_numeric($id)) {
            $model = new Model_Personnage();
            $personnage = new Objet_Personnage($model->bdGetOne($nom));
            $possession = $this->bdgetOne($id);
            foreach ($possession->effets as $effet) {
                $stat_modified = $effet->caracteristique;
                if ($effet->modificateur === "+") {
                    if ((int) $effet->valeur === 0) {
                        $stat_ref = $stat_modified . "Max";
                        $personnage->$stat_modified = $personnage->$stat_ref;
                    } else {
                        $personnage->$stat_modified += $effet->valeur;
                    }
                } else {
                    $personnage->$stat_modified -= $effet->valeur;
                }
                if ((int) $personnage->$stat_modified < 0) {
                    $personnage->$stat_modified = 0;
                }
                if ((int) $personnage->$stat_modified > 99) {
                    $personnage->$stat_modified = 99;
                }
                try {
                    Util_Registery::getInstance()->get("bd")->beginTransaction();
                    $model->bdModifyStatValue($nom, $stat_modified, $personnage->$stat_modified);
                    Util_Registery::getInstance()->get("bd")->commit();
                } catch (Exception $exc) {
                    Util_Registery::getInstance()->get("bd")->rollback();
                    echo FALSE;
                    exit();
                }
            }
            $this->redirect("SacADos", "changePossessionQuantity", array("nom" => $nom, "id" => $id, "valeur" => -1));
        } else {
            echo FALSE;
        }
    }

}
