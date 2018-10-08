<?php

namespace Projet6\Router;

class Router
{
    private $klein;
    private $frontendController;
    private $backendController;

    public function __construct()
    {
        $this->klein = new \Klein\Klein();
        $this->frontendController = new \Projet6\Controller\FrontendController();
        $this->backendController = new \Projet6\Controller\BackendController();
    }

    public function run()
    {
        $this->klein->respond('GET', '/', function () {
            $this->frontendController->listAnnonces();
        });
        $this->klein->respond('GET', '/annonces', function ($request) {
            if (is_null($request->type)) {
                $this->frontendController->
                listAnnoncesAll();
                return;
            }
            $actions = [
                "all" => 'listAnnoncesAll',
                "search" => 'listAnnoncesSearch',
                "give" => 'listAnnoncesGive',
                "city" => 'listAnnoncesCity',
            ];
            call_user_func([$this->frontendController, $actions[$request->type]]);
        });
        $this->klein->respond('GET', '/annonces/[:id]', function ($request) {
            $this->frontendController->annonce($request->id);
        });
        $this->klein->respond('GET', '/newannonce', function () {
            $this->backendController->displayNewAnnonce();
        });
        $this->klein->respond('GET', '/myannonces', function ($request) {
            $this->backendController->displayMyAnnonces($request->user, $request->annonceId);
        });
        $this->klein->respond('POST', '/addannonce', function ($request) {
            $this->backendController->addAnnonce($request->title, $request->content, $request->typeof, $request->tel, $request->email, $request->city, $request->author, $request->image, $request->member_id, $request->affectedLines);
        });
        $this->klein->respond('POST', '/spamannonce', function ($request) {
            $this->frontendController->spamAnnonce($request->id, $request->spam);
        });
        $this->klein->respond('GET', '/spameditannonce/[:id]', function ($request) {
            $this->frontendController->spamEditAnnonce($request->id);
        });

        $this->klein->respond('GET', '/signup', function () {
            $this->backendController->displayInscription();
        });
        $this->klein->respond('POST', '/signin', function ($request) {
            $this->backendController->inscription($request->pseudo, $request->mdp, $request->mail);
        });
        $this->klein->respond('GET', '/loginmaster', function () {
            $this->backendController->displayUserConnexionMaster();
        });
        $this->klein->respond('GET', '/login', function () {
            $this->backendController->displayUserConnexion();
        });
        $this->klein->respond('POST', '/disconnect', function () {
            $this->backendController->disconnect();
        });
        $this->klein->respond('POST', '/disconnectmaster', function () {
            $this->backendController->disconnectMaster();
        });
        $this->klein->respond('GET', '/mentions', function () {
            $this->frontendController->displayMentions();
        });
        $this->klein->respond('GET', '/spamannoncesview', function ($request) {
            $this->backendController->listAnnoncesSpam($request->id);
        });
        $this->klein->respond('GET', '/allannonces', function () {
            $this->backendController->listAnnoncesAllMaster();
        });
        $this->klein->respond('POST', '/delete', function ($request) {
            $this->backendController->deleteAdminAnnonce($request->id);
        });
        $this->klein->respond('POST', '/deleteu', function ($request) {
            $this->backendController->deleteAnnonceUser($request->id, $request->user);
        });
        $this->klein->respond('POST', '/deletem', function ($request) {
            $this->backendController->deleteAnnonceMaster($request->id);
        });
        $this->klein->respond('POST', '/deleteadminmessage', function ($request) {
            $this->backendController->deleteMessage($request->id);
        });
        $this->klein->respond('GET', '/messagesview', function ($request) {
            $this->backendController->listMessages($request->id);
        });
        $this->klein->respond('GET', '/userpanelmaster', function () {
            $this->backendController->displayUserPanelMaster();
        });
        $this->klein->respond('POST', '/usermaster', function ($request) {
            $this->backendController->reqUserMaster($request->mailconnect, $request->mdpconnect);
        });
        $this->klein->respond('GET', '/contact', function () {
            $this->frontendController->displayContact();
        });
        $this->klein->respond('GET', '/userpanel', function () {
            $this->backendController->displayUserPanel();
        });
        $this->klein->respond('POST', '/user', function ($request) {
            $this->backendController->reqUser($request->mailconnect, $request->mdpconnect);
        });
        $this->klein->respond('POST', '/sendmessage', function ($request) {
            $this->frontendController->sendMessage($request->first_name, $request->surname, $request->email, $request->tel, $request->object, $request->message);
        });
        $this->klein->respond('GET', '/public/[*]', function ($request, $response) {
            $file = $_SERVER['DOCUMENT_ROOT'] . $request->pathname();
            $types = [
                "css" => "text/css",
                "js" => "application/javascript",
                "png" => "image/png",
                "jpg" => "image/jpg",
            ];
            $contentType = $types[pathinfo($file, PATHINFO_EXTENSION)] ?? mime_content_type($file);
            $response->header('Content-type', $contentType);
            return file_get_contents($file);
        });
        $this->klein->dispatch();
    }
}
