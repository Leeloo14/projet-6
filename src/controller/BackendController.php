<?php

namespace Projet6\Controller;

use Projet6\Dao\AnnonceDao;
use Projet6\Dao\MemberDao;
use Projet6\Services\SessionService;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class BackendController
{

    private $memberDao;
    private $sessionService;
    private $annonceDao;
    private $template;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->memberDao = new MemberDao();
        $this->sessionService = new SessionService();
        $this->template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../view'), array('debug' => true));
        $this->template->addExtension(new Twig_Extension_Debug());
    }

    /** Permet de creer une nouvelle annonce*/
    function addAnnonce($title, $content,$typeof, $tel , $email, $city, $author)
    {
        $affectedLines = $this->annonceDao->createAnnonce($title, $content,$typeof, $tel, $email, $city, $author);
        ;

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter l\'episode !');
        }
        else {
            header('location: index.php');
        }
    }

    /** permet de supprimer une annonce */
    function deleteAdminPost($id, $template)
    {
        $annonceDao = new AnnonceDao();
        $annonceDao->deleteAnnonce($id);
        /*a définir*/
        $annonces = $annonceDao->getMyAnnonces();
        echo $this->template->render('backend/my-annonces.html.twig', array('annonces' => $annonces));

    }

    /** permet de modifier une annonce existante */
    function editAnnonce($annonceId, $template)
    {
        $annonceDao = new AnnonceDao();
        $annonce = $annonceDao->getannonce($annonceId);
        echo $this->template->render('backend/user-modify-annonce.html.twig', array('annonce' => $annonce));
    }

    /** permet valider les modifications d'une annonce existante */
    function replaceAnnonce($id, $title, $content, $typeof, $tel, $email, $city)
    {
        $annonceDao = new AnnonceDao();
        $affectedLines = $this->annonceDao->updateAnnonce($id, $title, $content, $typeof, $tel, $email, $city);
        $annonces = $annonceDao->getMyAnnonces();
        if ($affectedLines === false) {
            throw new \Exception('Impossible de modifier l/annonce!');
        } else {
            header('location: index.php?action=displayPanelUser');
        }
    }

    /** Permet de se connecter */
    function reqUser($mailconnect, $mdpconnect)
    {
        $userData = $this->memberDao->getUser($mailconnect, $mdpconnect);
        if ($mdpconnect == $userData['pass'] && $mailconnect == $userData['email']) {
            $this->sessionService->storeCookie();
            header('location: index.php?action=displayPanelUser');
        } else {
            $this->sessionService->disconnect();
            header('location: index.php?action=displayConnection&error=true');
        }
    }

    /** Permet de se deconnecter */
    function disconnect()
    {
        $this->sessionService->disconnect();
        header('location: index.php?action=displayConnexion');
    }

    /** permet d'afficher la page principale de l'espace personnel de la personne identifié */
    function displayUserPanel()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/user-view.html.twig');
        } else {
            header('location: index.php?action=displayConnexion');
        }
    }

    /** permet d'afficher la page permettant de creer une nouvelle annonce*/
    function displayNewAnnonce($template)
    {

        echo $this->template->render('backend/new-annonce-view.html.twig');

    }

    /** permet d'afficher la page contenant les annonces de l'utilisateur*/
    function displayMyAnnonces($template)
    {

        echo $this->template->render('backend/my-annonces.html.twig');

    }

    /** permet d'afficher la page de connexion*/
    function displayUserConnexion()
    {
        if ($this->sessionService->isClientAuthorized()) {
            header('location: index.php?action=displayPanelUser');
        } else {
            $hasFormError = isset($_GET['error']) && $_GET["error"]; // A faire passer depuis le routeur
            echo $this->template->render('frontend/connexion.html.twig', ["hasFormError" => $hasFormError]);
        }
    }

    /** permet d'afficher la page d'inscription*/
    function displayInscription()
    {

        echo $this->template->render('frontend/inscription.html.twig');
    }

    /** permet de renvoyer l'utilisateur à la page d'accueil si inscription avec succés*/
    function inscription($pseudo, $pass, $email)
    {

        $affectedLines = $this->memberDao->createMember($pseudo, $pass, $email);
        if ($affectedLines === false) {
            throw new \Exception('Tous les champs ne sont pas complétés');
        } else {
            echo $this->template->render('frontend/inscription.html.twig');
            echo '<p class="form-signin text-center border border-success "><b>votre compte a bien été créé</b></p>';
        }
    }

}
