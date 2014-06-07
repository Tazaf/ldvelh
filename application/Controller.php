<?php

//namespace application;

/**
 * Concerne les objets Controller de l'application.
 * Cette classe mere contient les méthodes et propriétés que doivent posséder tous les Controller.
 */
abstract class Controller {

    /**
     * Permet de rediriger vers une autre action de l'application.
     * Par défaut, la méthode redirige vers le dispatcher en appelant le Controller et l'Action par défaut tels que définis dans le bootstrap.
     * Si le Controller et l'Action sont passés en paramètres, la méthode redirigera vers le dispatcher en appellant le Controller et l'Action indiqués.
     * ATTENTION ! Le paramètre Controller ne peut pas être renseigné seul sous peine d'une Exception.
     * Un tableau de paramètres supplémentaires peuvent être ajoutés pour spécialiser la redirection.
     * @param type $controller Optionnel : Le nom du contrôleur visé. Par défaut, a pour valeur celle du Controller par défaut (cf. bootstrap.php).
     * @param type $action Optionnel : Le nom de l'action souhaitée. Par défaut, a pour valeur celle de l'Action par défaut (cf. bootstrap.php).
     * @param type $params Optionnel : Un tableau contenant des paramètres supplémentaires pour la redirection. Le tableau DOIT avoir la structure suivante : array($nom_param1 => $valeur_param1 [, $nom_paramX => $valeur_paramX]). Par défaut, ce paramètre est NULL.
     * @throws Exception Si le Controller est renseigné seul, envoie une Exception.
     */
    protected function redirect($controller = DEFAULT_CONTROLLER, $action = DEFAULT_ACTION, $params = NULL) {
        if ($controller !== DEFAULT_CONTROLLER && $action === DEFAULT_ACTION) {
            throw new Exception("Aucune Action spécifiée pour le Controller souhaité !");
        }
        $url = FILE_NAME . "?controller={$controller}&action={$action}";
        if ($params && is_array($params)) {
            foreach ($params as $param_nom => $param_valeur) {
                $url .= "&" . $param_nom . "=" . $param_valeur;
            }
        }
        header("location: {$url}");
        die();
    }

}
