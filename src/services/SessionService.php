<?php

namespace Projet6\Services;

class SessionService
{

    function isClientAuthorized()
    {
        return isset($_COOKIE['projet6']);
    }

    function storeCookie()
    {
        $endTime = time() + 3600; // Delai d'expiration de la session du client
        setcookie('projet6', 'connexion-pr6', $endTime); // Stock un cookie qui contient le temps d'expiration
    }

    function disconnect()
    {
        setcookie('projet6', 'connexion-pr6', time() - 1);
    }

}
