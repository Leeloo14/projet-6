<?php

namespace Projet6\Controller;

use Projet6\Dao\AnnonceDao;
use Projet6\Dao\MemberDao;
use Projet6\Model\Member;
use Projet6\Model\Messaging;
use Projet6\Dao\MessagingDao;
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
        $this->messagingDao = new MessagingDao();
        $this->sessionService = new SessionService();
        $this->template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../view'), array('debug' => true));
        $this->template->addExtension(new Twig_Extension_Debug());
    }

    /** Permet de creer une nouvelle annonce*/
    function addAnnonce($title, $content, $typeof, $tel, $email, $city, $author)
    {
        $affectedLines = $this->annonceDao->createAnnonce($title, $content, $typeof, $tel, $email, $city, $author);;

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter l\'annonce !');
        } else {
            echo $this->template->render('backend/my-annonces.html.twig');
        }
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

    /** permet de renvoyer l'utilisateur à la page d'accueil si inscription avec succés*/
    function inscription($pseudo, $pass, $email)
    {

        $affectedLines = $this->memberDao->createMember($pseudo, password_hash($pass, PASSWORD_BCRYPT), $email);
        if ($affectedLines === false) {
            throw new \Exception('Tous les champs ne sont pas complétés');
        } else {
            header('Location: /userpanel');
            die();
        }
    }


    /** Permet de se deconnecter */
    function disconnect()
    {
        $this->sessionService->disconnect();
        echo $this->template->render('frontend/connexion.html.twig');
    }


    /** permet d'afficher la page d'inscription*/
    function displayInscription()
    {

        echo $this->template->render('frontend/inscription.html.twig');
    }

    /** permet d'afficher la page permettant de creer une nouvelle annonce*/
    function displayNewAnnonce()
    {

        echo $this->template->render('backend/new-annonce-view.html.twig');

    }

    /** permet d'afficher la page contenant les annonces de l'utilisateur*/
    function displayMyAnnonces()
    {
        echo $this->template->render('backend/my-annonces.html.twig');

    }


    /**annonces signalées*/
    function listAnnoncesSpam()
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getSpamAnnonces();
        echo $this->template->render('backend/spam.html.twig', array('annonces' => $annonces));
    }

    /**messages recus*/
    function listMassages()
    {
        $messagingDao = new MessagingDao();
        $messagings = $messagingDao->getAllMessages();
        echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings));
    }











    /** annonce membre */
    function annoncesMember()
    {

    }























    /** Permet de se connecter */
    function reqUser($mailconnect, $mdpconnect)
    {
        /** @var Member $user */
        $user = $this->memberDao->getByEmail($mailconnect);
        if (password_verify($mdpconnect, $user->getPass())) {
            $this->sessionService->storeCookie();
            header('Location: /userpanel');
            die();
        }
        header('Location: /login');
        die();

    }


    /** permet d'afficher la page de connexion*/
    function displayUserConnexion()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/user-view.html.twig');
        } else {
            $hasFormError = isset($_GET['error']) && $_GET["error"]; // A faire passer depuis le routeur
            echo $this->template->render('frontend/connexion.html.twig', ["hasFormError" => $hasFormError]);
        }
    }


    /** permet d'afficher la page principale de l'espace personnel de la personne identifié */
    function displayUserPanel()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/user-view.html.twig');
        } else {
            echo $this->template->render('frontend/connexion.html.twig');;
        }
    }








    /*****************************************************************************/
    /** Permet de se connecter */
    function reqUserMaster($mailconnect, $mdpconnect)
    {
        /** @var Member $user */
        $user = $this->memberDao->getByEmail($mailconnect);
        if (password_verify($mdpconnect, $user->getPass())) {
            $this->sessionService->storeCookie();
            header('Location: /userpanelmaster');
            die();
        }
        header('Location: /loginmaster');
        die();

    }


    /** permet d'afficher la page de connexion*/
    function displayUserConnexionMaster()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/master-view.html.twig');
        } else {
            $hasFormError = isset($_GET['error']) && $_GET["error"]; // A faire passer depuis le routeur
            echo $this->template->render('frontend/master.html.twig', ["hasFormError" => $hasFormError]);
        }
    }


    /** permet d'afficher la page principale de l'espace personnel de la personne identifié */
    function displayUserPanelMaster()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/master-view.html.twig');
        } else {
            echo $this->template->render('frontend/master.html.twig');;
        }
    }













    /** permet de supprimer une annonce */
    function deleteAdminPost($annonceId)
    {
        {
            $annonceDao = new AnnonceDao();
            $affectedLines = $this->annonceDao->deleteAnnonce($annonceId);
            $annonces = $annonceDao->getSpamAnnonces();

            if ($affectedLines === false) {
                throw new \Exception('Impossible de supprimer l\annonce !');
            } else {
                echo $this->template->render('backend/spam.html.twig', array('annonces' => $annonces));

            }
        }
    }




    /** permet de supprimer une annonce */

    function deleteMessage($messagingId)
    {
        {
            $messagingDao = new MessagingDao();
            $affectedLines = $this->messagingDao->deleteMessage($messagingId);
            $messagings = $messagingDao->getAllMessages();
            if ($affectedLines === false) {
                throw new \Exception('Impossible de supprimer le message !');
            } else {
                echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings));

            }
        }
    }

}
