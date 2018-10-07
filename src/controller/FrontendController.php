<?php

namespace Projet6\Controller;

use Projet6\dao\AnnonceDao;
use Projet6\dao\MemberDao;
use Projet6\Dao\MessagingDao;
use Projet6\Services\SessionService;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class FrontendController
{
    private $annonceDao;
    private $memberDao;
    private $messagingDao;
    private $sessionService;
    private $template;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->sessionService = new SessionService();
        $this->memberDao = new MemberDao();
        $this->messagingDao = new MessagingDao();
        $this->template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../view'), array('debug' => true));
        $this->template->addExtension(new Twig_Extension_Debug());
    }

    /**Home*/
    function listAnnonces()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            echo $this->template->render('frontend/list-annonces-view.html.twig', array('userid' => $userid));
        } else {
            echo $this->template->render('frontend/list-annonces-view.html.twig');
        }
    }

    /**Toutes les annonces */
    function listAnnoncesAll()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;

            $annonces = $this->annonceDao->getAllAnnonces();

            echo $this->template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces, 'userid' => $userid));
        } else

            $annonces = $this->annonceDao->getAllAnnonces();

        echo $this->template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces));
    }

    /**Annonce je recherche */
    function listAnnoncesSearch()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getTypeOfAnnoncesSearch();
            echo $this->template->render('frontend/list-annonces-search-view.html.twig', array('annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getTypeOfAnnoncesSearch();
            echo $this->template->render('frontend/list-annonces-search-view.html.twig', array('annonces' => $annonces));
        }
    }

    /**Annonce je propose */
    function listAnnoncesGive()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getTypeOfAnnoncesGive();
            echo $this->template->render('frontend/list-annonces-give-view.html.twig', array('annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getTypeOfAnnoncesGive();
            echo $this->template->render('frontend/list-annonces-give-view.html.twig', array('annonces' => $annonces));
        }
    }

    /**Retoune la page pour selectionner une annonce par ville disponible*/
    function listAnnoncesCity()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getCity();
            echo $this->template->render('frontend/list-annonces-city.html.twig', array('annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonceDao = new AnnonceDao();
            $annonces = $annonceDao->getCity();
            echo $this->template->render('frontend/list-annonces-city.html.twig', array('annonces' => $annonces));
        }
    }

    /** Retourne une annonce */
    function annonce($annonceId)
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonces = $this->annonceDao->getAllAnnonces();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonces = $this->annonceDao->getAllAnnonces();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
        }
    }

    /**retourne l'annonce séléctionnée */
    function city($annonceId)
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonces = $this->annonceDao->getCity();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonces = $this->annonceDao->getCity();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
        }
    }

    /** permet d'éditer un motif de signalement pour signaler une annonce */
    function spamEditAnnonce($annonceId)
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonces = $this->annonceDao->getAllAnnonces();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/spamannonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces, 'userid' => $userid));
        } else {
            $annonces = $this->annonceDao->getAllAnnonces();
            $annonce = $this->annonceDao->getAnnonceById($annonceId);
            echo $this->template->render('frontend/spamannonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
        }
    }

    /** permet d'envoyer le motif de signalement */
    function spamAnnonce($annonceId, $spam)

    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $annonces = $this->annonceDao->getAllAnnonces();
            $affectedLines = $this->annonceDao->signalAnnonce($annonceId, $spam);
            if ($affectedLines === false) {
                throw new \Exception('Impossible de signaler l\annonce !');
            } else if ($affectedLines === true) {
                echo $this->template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces,'userid'=>$userid));

            } else {
                $annonces = $this->annonceDao->getAllAnnonces();
                $affectedLines = $this->annonceDao->signalAnnonce($annonceId, $spam);
                if ($affectedLines === false) {
                    throw new \Exception('Impossible de signaler l\annonce !');
                }
            }
        } else {
            echo $this->template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces));

        }
    }




    /** Permet d'envoyer un message*/
    function sendMessage($first_name, $surname, $email, $tel, $object, $message)
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            $affectedLines = $this->messagingDao->createMessage($first_name, $surname, $email, $tel, $object, $message);

            if ($affectedLines === false) {
                throw new \Exception('Impossible d\'envoyer le message !');
            } else if ($affectedLines === true) {
                echo $this->template->render('frontend/contact.html.twig', array('userid' => $userid));
            } else {
                $affectedLines = $this->messagingDao->createMessage($first_name, $surname, $email, $tel, $object, $message);

                if ($affectedLines === false) {
                    throw new \Exception('Impossible d\'envoyer le message !');
                }
            }
        } else {
            echo $this->template->render('frontend/contact.html.twig');
        }


    }

    /** permet d'afficher la page de contact*/
    function displayContact()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            echo $this->template->render('frontend/contact.html.twig', array('userid' => $userid));

        } else {
            echo $this->template->render('frontend/contact.html.twig');
        }
    }


    /** permet d'afficher la page de contact*/
    function displayMentions()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            echo $this->template->render('frontend/mentions.html.twig', array('userid' => $userid));

        } else {
            echo $this->template->render('frontend/mentions.html.twig');
        }
    }
}
