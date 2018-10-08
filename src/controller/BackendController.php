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
    private $messagingDao;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->memberDao = new MemberDao();
        $this->messagingDao = new MessagingDao();
        $this->sessionService = new SessionService();
        $this->template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../view'), array('debug' => true));
        $this->template->addExtension(new Twig_Extension_Debug());
    }

    /** permet d'afficher la page d'inscription*/
    function displayInscription()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            $userid = $user->id;
            echo $this->template->render('frontend/inscription.html.twig', array('userid' => $userid));
        } else {
            echo $this->template->render('frontend/inscription.html.twig');
        }
    }

    /** inscription + redirection à la page d'accueil si inscription avec succés*/
    function inscription($pseudo, $pass, $email)
    {
        $this->memberDao->getByEmail($email);
        $affectedLines = $this->memberDao->createMember($pseudo, password_hash($pass, PASSWORD_BCRYPT), $email);

        if ($affectedLines === false) {
            throw new \Exception('Tous les champs ne sont pas complétés');
        } else {
            header('Location: /userpanel');


            die();
        }
    }

    /** Permet de se connecter */
    function reqUser($mailconnect, $mdpconnect)
    {
        /** @var Member $user */
        $user = $this->memberDao->getByEmail($mailconnect);

        if (password_verify($mdpconnect, $user->getPass())) {
            $this->sessionService->storeCookie($user->getId());
            header('Location: /userpanel');
            die();
        } else {
            header('Location: /login');
            die();}
        }

        /** Permet de se connecter master*/
        function reqUserMaster($mailconnect, $mdpconnect)
        {
            /** @var Member $user */
            $user = $this->memberDao->getByEmailMaster($mailconnect);


            if (password_verify($mdpconnect, $user->getPass())) {
                $this->sessionService->storeCookieMaster($user->getId());

                header('Location: /userpanelmaster');
                die();
            }else{
            header('Location: /loginmaster');
            die();
            }
        }

        /** Permet de se deconnecter */
        function disconnect()
        {
            $this->sessionService->disconnect();
            header('Location: /login');
            die();

        }

        /** Permet de se deconnecter */
        function disconnectMaster()
        {
            $this->sessionService->disconnectMaster();
            header('Location: /loginmaster');
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
            if ($user = $this->sessionService->isClientAuthorized()) {
                echo $this->template->render('backend/user-view.html.twig');

            } else {
                echo $this->template->render('frontend/connexion.html.twig');;
            }
        }

        /** permet d'afficher la page de connexion*/
        function displayUserConnexionMaster()
        {
            if ($this->sessionService->isClientAuthorizedMaster()) {
                echo $this->template->render('backend/master-view.html.twig');
            } else {
                $hasFormError = isset($_GET['error']) && $_GET["error"];
                echo $this->template->render('frontend/master.html.twig', ["hasFormError" => $hasFormError]);
            }
        }

        /** permet d'afficher la page principale de l'espace personnel de la personne identifié */
        function displayUserPanelMaster()
        {
            if ($this->sessionService->isClientAuthorizedMaster()) {
                echo $this->template->render('backend/master-view.html.twig');
            } else {
                echo $this->template->render('frontend/master.html.twig');;
            }
        }


        /** Permet de creer une nouvelle annonce*/
        function addAnnonce($title, $content, $typeof, $tel, $email, $city, $author, $image, $member_id, $affectedLines)
        {
            if ($user = $this->sessionService->isClientAuthorized()) {

                $this->sessionService->uploadFile($title, $content, $typeof, $tel, $email, $city, $author, $image, $member_id, $affectedLines, $user);


                if ($affectedLines === false) {
                    throw new \Exception('Impossible d\'ajouter l\'annonce !');
                } else {
                    header('Location: /myannonces');
                    die();
                }
            } else {
                header('Location: /login');
                die();
            }
        }


        /** affiche toutes les annonces présentes sur le site */
        function listAnnoncesAllMaster()
        {
            if ($user = $this->sessionService->isClientAuthorizedMaster()) {
                $annonces = $this->annonceDao->getAllAnnonces();
                echo $this->template->render('backend/list-annonces-all-master.html.twig', array('annonces' => $annonces));
            } else {
                echo $this->template->render('frontend/master.html.twig');;
            }
        }


        /** permet d'afficher la page permettant de creer une nouvelle annonce*/
        function displayNewAnnonce()
        {

            if ($user = $this->sessionService->isClientAuthorized()) {

                echo $this->template->render('backend/new-annonce-view.html.twig');

            } else {

                echo $this->template->render('frontend/connexion.html.twig');
            }
        }

        /** permet d'afficher la page contenant les annonces de l'utilisateur*/
        function displayMyAnnonces($user, $annonceId)
        {
            if ($user = $this->sessionService->isClientAuthorized()) {
                $annonceDao = new AnnonceDao();
                $identity = $user->id;

                if ($user = $identity) {


                    $annonces = $annonceDao->getMyAnnonces($user);
                    $annonce = $this->annonceDao->getAnnonceById($annonceId);


                    echo $this->template->render('backend/my-annonces.html.twig', array('annonces' => $annonces, 'annonce' => $annonce));
                } else {

                    echo $this->template->render('frontend/connexion.html.twig');
                }
            }

        }

        /**annonces signalées*/
        function listAnnoncesSpam($id)
        {
            if ($this->sessionService->isClientAuthorizedMaster()) {
                $annonceDao = new AnnonceDao();
                $annonces = $annonceDao->getSpamAnnonces();
                $annonce = $annonceDao->getAnnonceById($id);
                echo $this->template->render('backend/spam.html.twig', array('annonces' => $annonces, 'annonce' => $annonce));
            } else {

                echo $this->template->render('frontend/master.html.twig');
            }


        }

        /**messages recus*/
        function listMessages($id)
        {
            if ($this->sessionService->isClientAuthorizedMaster()) {
                $messagingDao = new MessagingDao();
                $messagings = $messagingDao->getAllMessages();
                $messaging = $messagingDao->getMessageById($id);
                echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings, 'messaging' => $messaging));
            } else {

                echo $this->template->render('frontend/master.html.twig');
            }
        }


        /** permet de supprimer une annonce signalée admin*/
        function deleteAdminAnnonce($annonceId)

        {
            if ($this->sessionService->isClientAuthorizedMaster()) {

                $affectedLines = $this->annonceDao->deleteAnnonce($annonceId);


                if ($affectedLines === false) {
                    throw new \Exception('Impossible de supprimer l\annonce !');
                } else {
                    header('Location: /spamannoncesview');
                    die();

                }
            } else {

                header('Location: /loginmaster');
                die();
            }
        }

        /** permet de supprimer une annonce par son auteur*/
        function deleteAnnonceUser($annonceId, $user)

        {
            if ($user = $this->sessionService->isClientAuthorized()) {


                $affectedLines = $this->annonceDao->deleteAnnonce($annonceId);

                if ($affectedLines === false) {
                    throw new \Exception('Impossible de supprimer l\annonce !');
                } else {
                    header('Location: /myannonces');
                    die();
                }
            } else {

                header('Location: /login');
                die();
            }

        }

        /**permet de supprimer une annonce par l admin*/
        function deleteAnnonceMaster($annonceId)

        {
            if ($this->sessionService->isClientAuthorizedMaster()) {

                $affectedLines = $this->annonceDao->deleteAnnonce($annonceId);

                if ($affectedLines === false) {
                    throw new \Exception('Impossible de supprimer le message !');
                } else {
                    header('Location: /allannonces');
                    die();

                }
            } else {

                header('Location: /loginmaster');
                die();
            }

        }

        /** permet de supprimer un message */
        function deleteMessage($messagingId)

        {
            if ($this->sessionService->isClientAuthorizedMaster()) {

                $affectedLines = $this->messagingDao->deleteMessage($messagingId);

                if ($affectedLines === false) {
                    throw new \Exception('Impossible de supprimer le message !');
                } else {
                    header('Location: /messagesview');
                    die();
                }
            } else {

                header('Location: /loginmaster');
                die();
            }

        }


    }
