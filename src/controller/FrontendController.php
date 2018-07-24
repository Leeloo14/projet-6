<?php

namespace Projet6\Controller;

use Projet6\dao\AnnonceDao;
use Projet6\dao\MemberDao;


class FrontendController
{

    private $annonceDao;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();

    }

    /** renvoi la liste de tout les episodes */
    function listAnnonces($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        echo $template->render('frontend/list-annonces-view.html.twig', array('annonces' => $annonces));
    }

    /** renvoi un épisode */
    function annonce($template)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        $annonce = $this->annonceDao->getAnnonceById($_GET['id']);
        echo $template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }


}