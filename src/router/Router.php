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
                $this->frontendController->listAnnoncesAll();
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

        $this->klein->respond('GET', '/login', function () {
            $this->backendController->displayUserConnexion();
        });

        $this->klein->respond('GET', '/signup', function () {
            $this->backendController->displayInscription();
        });

        $this->klein->dispatch();
    }


}
