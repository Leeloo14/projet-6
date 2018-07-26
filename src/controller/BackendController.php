<?php

namespace Projet6\Controller;

use Projet6\Dao\AnnonceDao;
use Projet6\Dao\MemberDao;
use Projet6\Services\SessionService;

class BackendController
{

    private $memberDao;
    private $sessionService;
    private $annonceDao;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->memberDao = new MemberDao();
        $this->sessionService = new SessionService();
    }

    /** Permet de creer une nouvelle annonce*/
    function addAnnonce($memberId, $title, $content, $typeof, $tel, $email, $city)
    {
        $affectedLines = $this->annonceDao->createAnnonce($memberId, $title, $content, $typeof, $tel, $email, $city);;

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter l\'episode !');
        } else {
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
        echo $template->render('backend/my-annonces.html.twig', array('annonces' => $annonces));

    }

    /** permet de modifier une annonce existante */
    function editAnnonce($annonceId, $template)
    {
        $annonceDao = new AnnonceDao();
        $annonce = $annonceDao->getannonce($annonceId);
        echo $template->render('backend/user-modify-annonce.html.twig', array('annonce' => $annonce));
    }

    /** permet valider les modifications d'une annonce existante */
    function replaceAnnonce($id, $title, $content, $typeof, $tel, $email, $city)
    {
        $annonceDao = new AnnonceDao();
        $affectedLines = $this->annonceDao->updatePost($id, $title, $content, $typeof, $tel, $email, $city);
        $annonces = $annonceDao->getMyAnnonces();
        if ($affectedLines === false) {
            throw new \Exception('Impossible de modifier le post!');
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
    function displayUserPanel($template)
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $template->render('backend/user-view.html.twig');
        } else {
            header('location: index.php?action=displayConnexion');
        }
    }

    /** permet d'afficher la page permettant de creer une nouvelle annonce*/
    function displayNewAnnonce($template)
    {

        echo $template->render('backend/new-annonce-view.html.twig');

    }

    /** permet d'afficher la page contenant les annonces de l'utilisateur*/
    function displayMyAnnonces($template)
    {

        echo $template->render('backend/my-annonces.html.twig');

    }

    /** permet d'afficher la page de connexion*/
    function displayUserConnexion($template)
    {
        if ($this->sessionService->isClientAuthorized()) {
            header('location: index.php?action=displayPanelUser');
        } else {
            $hasFormError = isset($_GET['error']) && $_GET["error"];
            echo $template->render('frontend/connexion.html.twig', ["hasFormError" => $hasFormError]);
        }
    }

    /** permet d'afficher la page d'inscription*/
    function displayInscription($template)
    {
        echo $template->render('frontend/inscription.html.twig');
    }

    /** permet de renvoyer l'utilisateur à la page d'accueil si inscription avec succés*/
    function inscription($pseudo, $pass, $email)
    {
        $affectedLines = $this->memberDao->createMember($pseudo, $pass, $email);
        if ($affectedLines === false) {
            throw new \Exception('Tous les champs ne sont pas complétés');
        } else {
            echo "votre comptre à bien été crée";
            header('location: index.php');
        }
    }

}
