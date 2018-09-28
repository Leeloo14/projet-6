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
        echo $this->template->render('frontend/inscription.html.twig');
    }

    /** inscription + redirection à la page d'accueil si inscription avec succés*/
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

    /** Permet de se connecter */
    function reqUser($mailconnect, $mdpconnect)
    {
        /** @var Member $user */
        $user = $this->memberDao->getByEmail($mailconnect);
        if (password_verify($mdpconnect, $user->getPass())) {
            $this->sessionService->storeCookie($user->getId());
            header('Location: /userpanel');
            die();
        }
        header('Location: /login');
        die();

    }

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

    /** Permet de se deconnecter */
    function disconnect()
    {
        $this->sessionService->disconnect();
        echo $this->template->render('frontend/connexion.html.twig');
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
            var_dump($user);
        } else {
            echo $this->template->render('frontend/connexion.html.twig');;
        }
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


    /** Permet de creer une nouvelle annonce*/
    function addAnnonce($title, $content, $typeof, $tel, $email, $city, $author, $image,$member_id)
    {
        if ($user = $this->sessionService->isClientAuthorized()) {


            $image = $_FILES ['image']['name'];


            if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
            {

                if ($_FILES['image']['size'] <= 1000000)
                {

                    $infosfichier = pathinfo($_FILES['image']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    $name = basename($_FILES['image']['name']);
                    $file = rand(1,99999). $name. '.' .$extension_upload;
                    if (in_array($extension_upload, $extensions_autorisees))
                    {

                      move_uploaded_file($_FILES['image']['tmp_name'], $info = './public/upload/' . $file);
            var_dump($image);

                    }
                }
            }
            $affectedLines = $this->annonceDao->createAnnonce($title, $content, $typeof, $tel, $email, $city, $author, $image = $info ,$member_id = $user->id);
            var_dump($info,$user);

            if ($affectedLines === false) {
                throw new \Exception('Impossible d\'ajouter l\'annonce !');
            } else {
                echo $this->template->render('backend/my-annonces.html.twig');
            }
        } else {

            echo $this->template->render('frontend/connexion.html.twig');
        }
    }

    /** permet de modifier une annonce existante */
    function editAnnonce($annonceId)
    {
        if ($this->sessionService->isClientAuthorized()) {
            $annonceDao = new AnnonceDao();
            $annonce = $annonceDao->getannonce($annonceId);
            echo $this->template->render('backend/user-modify-annonce.html.twig', array('annonce' => $annonce));
        } else {

            echo $this->template->render('frontend/connexion.html.twig');
        }
    }

    /** permet valider les modifications d'une annonce existante */
    function replaceAnnonce($id, $title, $content, $typeof, $tel, $email, $city)
    {
        if ($this->sessionService->isClientAuthorized()) {
            $annonceDao = new AnnonceDao();
            $affectedLines = $this->annonceDao->updateAnnonce($id, $title, $content, $typeof, $tel, $email, $city);
            $annonces = $annonceDao->getMyAnnonces();
            if ($affectedLines === false) {
                throw new \Exception('Impossible de modifier l/annonce!');
            } else {
                header('location: index.php?action=displayPanelUser');
            }
        } else {

            echo $this->template->render('frontend/connexion.html.twig');
        }
    }

    /** permet d'afficher la page permettant de creer une nouvelle annonce*/
    function displayNewAnnonce()
    {
        if ($user = $this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/new-annonce-view.html.twig');
            var_dump($user);
        } else {

            echo $this->template->render('frontend/connexion.html.twig');
        }
    }

    /** permet d'afficher la page contenant les annonces de l'utilisateur*/
    function displayMyAnnonces()
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $this->template->render('backend/my-annonces.html.twig');
        } else {

            echo $this->template->render('frontend/connexion.html.twig');
        }
    }

    /**annonces signalées*/
    function listAnnoncesSpam($id)
    {
        if ($this->sessionService->isClientAuthorized()) {
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
        if ($this->sessionService->isClientAuthorized()) {
            $messagingDao = new MessagingDao();
            $messagings = $messagingDao->getAllMessages();
            $messaging = $messagingDao->getMessageById($id);
            echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings, 'messaging' => $messaging));
        } else {

            echo $this->template->render('frontend/master.html.twig');
        }
    }

    /********************************************************/
    /** permet d'éditer le staus d'un message */
    function editStatusMessage($id)
    {
        if ($this->sessionService->isClientAuthorized()) {
            $messagings = $this->messagingDao->getAllMessages();
            $messaging = $this->messagingDao->getMessageById($id);
            echo $this->template->render('backend/message-status.html.twig', array('messaging' => $messaging, 'messagings' => $messagings));
        } else {

            echo $this->template->render('frontend/master.html.twig');
        }
    }

    /** permet d'envoyer le mettre à jour le status d'un message */
    function updateStatus($messagingId, $status)
    {
        if ($this->sessionService->isClientAuthorized()) {
            $messagings = $this->messagingDao->getAllMessages();
            $affectedLines = $this->messagingDao->updateMessage($messagingId, $status);
            if ($affectedLines === false) {
                throw new \Exception('Impossible de modifier le status !');
            } else {
                echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings));

            }
        } else {

            echo $this->template->render('frontend/master.html.twig');
        }
    }

    /*********************************************************************/


    /** permet de supprimer une annonce signalée */
    function deleteAdminAnnonce($annonceId)

    {
        if ($this->sessionService->isClientAuthorized()) {
            $annonceDao = new AnnonceDao();
            $affectedLines = $this->annonceDao->deleteAnnonce($annonceId);
            $annonces = $annonceDao->getSpamAnnonces();

            if ($affectedLines === false) {
                throw new \Exception('Impossible de supprimer l\annonce !');
            } else {
                echo $this->template->render('backend/spam.html.twig', array('annonces' => $annonces));

            }
        } else {

            echo $this->template->render('frontend/master.html.twig');
        }
    }


    /** permet de supprimer un message */

    function deleteMessage($messagingId)

    {
        if ($this->sessionService->isClientAuthorized()) {
            $messagingDao = new MessagingDao();
            $affectedLines = $this->messagingDao->deleteMessage($messagingId);
            $messagings = $messagingDao->getAllMessages();
            if ($affectedLines === false) {
                throw new \Exception('Impossible de supprimer le message !');
            } else {
                echo $this->template->render('backend/messages.html.twig', array('messagings' => $messagings));

            }
        } else {

            echo $this->template->render('frontend/master.html.twig');
        }

    }


}
