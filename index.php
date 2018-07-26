<?php

require_once "vendor/autoload.php";

use Projet6\Controller\FrontendController;
use Projet6\Controller\BackendController;


$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/view');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$frontendController = new FrontendController();
$backendController = new BackendController();

try {
    if (!isset($_GET["action"])) {
        $frontendController->listAnnonces($twig);
    }

    if (isset($_GET["action"]) && $_GET['action'] == 'listAnnoncesSearch') {
        $frontendController->listAnnoncesSearch($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'listAnnoncesGive') {
        $frontendController->listAnnoncesGive($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'listAnnoncesAll') {
        $frontendController->listAnnoncesAll($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $frontendController->annonce($twig);
        } else {
            throw new Exception('1 Aucun identifiant d/annonce envoyé');
        }

    }
    /**test inscription*/
    if (isset($_GET['action']) && $_GET['action'] == 'displayUserInscription') {
        $backendController->displayInscription($twig);
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
                            $backendController->inscription($pseudo, $mdp, $mail);
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


    /********************************************************************************
     * ! USER PART !
     *********************************************************************************/
    if (isset($_GET["action"]) && $_GET['action'] == 'disconnect') {
        $backendController->disconnect();
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'displayConnexion') {
        $backendController->displayUserConnexion($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'displayPanelUser') {
        $backendController->displayUserPanel($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'displayNewAnnonce') {
        $backendController->displayNewAnnonce($twig);
    }
    if (isset($_GET["action"]) && $_GET['action'] == 'displayMyAnnonces') {
        $backendController->displayMyAnnonces($twig);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'createAnnonce') {
        if (!empty($_POST['title']) && !empty($_POST['content'])&& !empty($_POST['typeof']) && !empty($_POST['tel'])&& !empty($_POST['email'])) {
            $backendController->addAnnonce($_GET['id'],$_POST['title'], $_POST['content'],$_POST['typeof'],$_POST['tel'],$_POST['email']);
        } else {
            throw new Exception('2 Tous les champs ne sont pas remplis !');
        }
    }

    /**connexion */
    if (isset($_POST['formconnect'])) {
        $mailconnect = $_POST['mailconnect'];
        $mdpconnect = sha1($_POST['mdpconnect']);
        if (!empty($mailconnect) AND !empty($mdpconnect)) {
            $backendController->reqUser($_POST['mailconnect'], sha1($_POST['mdpconnect']));
        } else {
            throw new Exception("Tous les champs doivent être complétés!");
        }
        if (isset($_SESSION['pseudo'])) {
            $backendController->displayUserPanel($twig);
        }
    }

    /********************************************************************************
     * ! USER PART !
     *********************************************************************************/
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
