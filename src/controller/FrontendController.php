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

    /**Home*/
    function listAnnonces($template)
    {

        echo $template->render('frontend/list-annonces-view.html.twig');
    }

    /**Toutes les annonces */
    function listAnnoncesAll($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        echo $template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces));
    }

    /**Annonce je recherche */
    function listAnnoncesSearch($template)
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getTypeOfAnnoncesSearch();
        echo $template->render('frontend/list-annonces-search-view.html.twig', array('annonces' => $annonces));
    }
    /**Annonce je propose */
    function listAnnoncesGive($template)
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getTypeOfAnnoncesGive();
        echo $template->render('frontend/list-annonces-give-view.html.twig', array('annonces' => $annonces));
    }
    /**Retoune la page pour selectionner une annonce par ville disponible*/
    function listAnnoncesCity($template)
    {

        echo $template->render('frontend/list-annonces-city.html.twig');
    }

    /** Retourne une annonce */
    function annonce($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        $annonce = $this->annonceDao->getAnnonceById($_GET['id']);
        echo $template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }


}