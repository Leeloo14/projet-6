<?php

require_once "vendor/autoload.php";

use Projet6\Controller\FrontendController;

//require_once 'src/controller/FrontendController.php';


$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/view');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$frontendController = new FrontendController();

try {
    if (!isset($_GET["action"])) {
        $frontendController->listAnnonces($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'listAnnonces') {
        $frontendController->listAnnonces($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $frontendController->annonce($twig);
        } else {
            throw new Exception('1 Aucun identifiant d/annonce envoyé');
        }
    } /**test inscription*/
    elseif ($_GET['action'] == 'displayInscription') {
        $frontendController->displayInscription($twig);
    }
    if ($_GET['action'] == 'forminscription') {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $mail2 = $_POST['mail2'];
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
        if (!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp) AND !empty($mdp2)) {
            $pseudolength = strlen($pseudo);
            if ($pseudolength <= 255) {
                if ($mail == $mail2) {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        if ($mdp == $mdp2) {
                            $frontendController->inscription($pseudo, $mdp, $mail);
                        } else {
                            throw new Exception('Vos mots de passe ne correspondent pas!');
                        }
                    } else {
                        throw new Exception('Votre adresse mail est invalide!');
                    }
                } else {
                    throw new Exception('Vos adresse mail ne correspondent pas!');
                }
            } else {
                throw new Exception('Votre pseudo ne doit pas dépasser 255 caractères!');
            }
        } else {
            throw new Exception("Tous les champs ne sont pas complétés!");
        }
    }


} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
