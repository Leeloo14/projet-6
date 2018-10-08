<?php

namespace Projet6\Services;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Projet6\Dao\AnnonceDao;

class SessionService
{
    private $annonceDao;
    private $sessionService;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();

    }

    function isClientAuthorized()
    {
        if (!isset($_COOKIE['projet6'])) {
            return false;
        }
        try {
            return JWT::decode($_COOKIE['projet6'], file_get_contents('certs/jwt.pub'), ['RS256']);

        } catch (ExpiredException $e) {
            return false;
        }
    }

    function storeCookie($id)
    {
        $token = array(
            "iss" => "normandhelp",
            "iat" => time(),
            "exp" => time() + 3600,
            "id" => $id,

        );
        $jwt = JWT::encode($token, file_get_contents('certs/jwt.key'), 'RS256');
        setcookie('projet6', $jwt); // Stock un cookie qui contient le temps d'expiration
    }

    function disconnect()
    {
        setcookie('projet6', 'connexion-pr6', time() - 1);
    }

    function isClientAuthorizedMaster()
    {
        if (!isset($_COOKIE['projet6master'])) {
            return false;
        }
        try {
            return JWT::decode($_COOKIE['projet6master'], file_get_contents('certs/jwt.pub'), ['RS256']);

        } catch (ExpiredException $e) {
            return false;
        }
    }


    function storeCookieMaster($id)
    {
        $token = array(
            "iss" => "normandhelp",
            "iat" => time(),
            "exp" => time() + 3600,
            "id" => $id,

        );
        $jwt = JWT::encode($token, file_get_contents('certs/jwt.key'), 'RS256');
        setcookie('projet6master', $jwt); // Stock un cookie qui contient le temps d'expiration
    }

    function disconnectMaster()
    {
        setcookie('projet6master', 'connexion-pr6master', time() - 1);
    }

    function uploadFile($title, $content, $typeof, $tel, $email, $city, $author, $image, $member_id,$affectedLines,$user)
    {

            if ($_FILES['image']['size'] <= 6000000) {
                $infosfichier = pathinfo($_FILES['image']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

                mt_srand();
                $image = str_pad(mt_rand(0, 999999) . '.' . $extension_upload, 6, '0', STR_PAD_LEFT);

                if (in_array($extension_upload, $extensions_autorisees)) {

                   move_uploaded_file($_FILES['image']['tmp_name'], $info = 'public/upload/' . $image);


                }
            }
            $affectedLines = $this->annonceDao->createAnnonce($title, $content, $typeof, $tel, $email, $city, $author, $image = $info, $member_id = $user->id);

    }
}
