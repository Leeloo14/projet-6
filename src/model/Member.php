<?php

namespace Projet6\Model;

class Member
{
    private $id;
    private $pseudo;
    private $pass;
    private $email;
    private $dateInsription;




    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDateIncription()
    {
        return $this->dateInsription;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setDateInscription($dateInscription)
    {
        $this->dateInsription = $dateInscription;
    }

}
