<?php

header('Content-type: text/html; charset=utf-8');

// Définition du chemin d'accès aux fichier de l'application
define("APPLICATION_PATH", str_replace("public" . DIRECTORY_SEPARATOR, "application" . DIRECTORY_SEPARATOR, dirname(__FILE__) . DIRECTORY_SEPARATOR));

require_once APPLICATION_PATH . "bootstrap.php";

$controllerName = isset($_REQUEST["controller"]) ? $_REQUEST["controller"] : DEFAULT_CONTROLLER;
$actionName = isset($_REQUEST["action"]) ? $_REQUEST["action"] : DEFAULT_ACTION;

$controllerClassName = "Controller_" . $controllerName;
$controller = new $controllerClassName();

if (!method_exists($controller, $actionName)) {
    die("Tentative de détournement de l'application.");
}
$controller->$actionName(); 
