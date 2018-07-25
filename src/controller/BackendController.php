<?php

namespace Blog\Controller;

use Projet6\Dao\AnnonceDao;
use Projet6\Dao\MemberDao;
use Projet6\Services\SessionService;

class BackendController
{

    private $memberDao;
    private $sessionService;
    function __construct()
    {
        $this->postDao = new AnnonceDao();
        $this->memberDao = new MemberDao();
        $this->sessionService = new SessionService();
    }
    function reqUser($mailconnect, $mdpconnect)
    {
        $userData = $this->memberDao->getUser($mailconnect, $mdpconnect);
        if ($mdpconnect == $userData['pass'] && $mailconnect == $userData['email']) {
            $this->sessionService->storeCookie();
            header('location: index.php?action=displayPanelAdmin');
        } else {
            $this->sessionService->disconnect();
            header('location: index.php?action=displayConnection&error=true');
        }
    }
    function disconnect(){
        $this->sessionService->disconnect();
        header('location: index.php?action=displayConnection');
    }
    function displayAdminPanel($template)
    {
        if ($this->sessionService->isClientAuthorized()) {
            echo $template->render('backend/admin-view.html.twig');
        } else {
            header('location: index.php?action=displayConnection');
        }
    }
    function displayAdminConnection($template)
    {
        if ($this->sessionService->isClientAuthorized()) {
            header('location: index.php?action=displayPanelAdmin');
        } else {
            $hasFormError = isset($_GET['error']) && $_GET["error"];
            echo $template->render('frontend/connection.html.twig', [ "hasFormError" =>  $hasFormError]);
        }
    }
}
