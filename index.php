<?php

require_once "vendor/autoload.php";

use Projet6\Controller\FrontendController;
use Projet6\Controller\BackendController;

$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/view');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$backendController = new BackendController();
$frontendController = new FrontendController();

try {

    if(!isset($_GET["action"])){
        $frontendController->listAnnonces($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'listAnnonces') {
        $frontendController->listAnnonces($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $frontendController->annoonce($twig);
        } else {
            throw new Exception('1 Aucun identifiant d/annonce envoyé');
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
