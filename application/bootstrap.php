<?php

date_default_timezone_set('Europe/Zurich');

require_once APPLICATION_PATH . 'bdconnect.php';

// Nom du fichier de dispatcher
define("FILE_NAME", basename($_SERVER["PHP_SELF"]));
// Controller et Action par défaut du dispatcher
define("DEFAULT_CONTROLLER", "Personnage");
define("DEFAULT_ACTION", "showAll");
// Chemin d'accès des templates Smarty
define("TPL_PATH", APPLICATION_PATH . "View" . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR);
// Définition du chemin d'accès aux fichiers Smarty
define("SMARTY_PATH", APPLICATION_PATH . "View" . DIRECTORY_SEPARATOR . "Smarty" . DIRECTORY_SEPARATOR);
define("LANGUAGE_PATH", APPLICATION_PATH . "locale");

// Autoload des fichiers de classes lors de leur instanciation
spl_autoload_register(function($className) {
    // Autoload Smarty
    if (strpos($className, "Smarty") !== false) {
        require_once SMARTY_PATH . "Smarty.class.php";
        return;
    }
    $classPath = str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
    if (!file_exists(APPLICATION_PATH . $classPath)) {
        throw new Exception("Class not found : " . $classPath);
        header("location: " . FILE_NAME);
        die();
    }
    require_once APPLICATION_PATH . $classPath;
});

$bdconnect = new PDO(BD_DSN, BD_USERNAME, BD_PASSWD);
// Ajout de la connexion ouverte au registre utilitaire pour son accès depuis l'application
Util_Registery::getInstance()->set("bd", $bdconnect);
