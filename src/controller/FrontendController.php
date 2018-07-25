<?php

namespace Projet6\Controller;

use Projet6\dao\AnnonceDao;
use Projet6\dao\MemberDao;
use Projet6\Services\SessionService;

class FrontendController
{
    private $annonceDao;
    private $memberDao;
    private $sessionService;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->sessionService = new SessionService();
        $this->memberDao = new MemberDao();
    }

    function listAnnonces($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        echo $template->render('frontend/list-annonces-view.html.twig', array('annonces' => $annonces));
    }

    function annonce($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        $annonce = $this->annonceDao->getAnnonceById($_GET['id']);
        echo $template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }

    /** a bouger dans backend */
    function displayNewAnnonce($template)
    {

        echo $template->render('frontend/new-annonce-view.html.twig');

    }
    /** permet d'afficjer la page d'inscription */
    function displayInscription($template)
    {
        echo $template->render('frontend/inscription.html.twig');
    }
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