<?php

namespace Projet6\Model;

class Annonce
{
    private $id;
    private $member_id;
    private $title;
    private $content;
    private $creationDate;
    private $typeof;
    private $tel;
    private $email;
    private $city;

    function __construct($annonceData)
    {
        if (isset($annonceData['id'])) {
            $this->id = $annonceData['id'];
        }
        if (isset($annonceData['member_id'])) {
            $this->member_Id = $annonceData['member_id'];
        }
        if (isset($annonceData['title'])) {
            $this->title = $annonceData['title'];
        }
        if (isset($annonceData['content'])) {
            $this->content = $annonceData['content'];
        }
        if (isset($annonceData['typeof'])) {
            $this->typeof = $annonceData['typeof'];

        }
        if (isset($annonceData['tel'])) {
            $this->tel = $annonceData['tel'];
        }
        if (isset($annonceData['creation_date'])) {
            $this->creationDate = date_create_from_format('Y-m-d H:i:s', $annonceData['creation_date']);
        }
        if (isset($annonceData['email'])) {
            $this->email = $annonceData['email'];
        }
        if (isset($annonceData['city'])) {
            $this->city = $annonceData['city'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMemberId()
    {
        return $this->member_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getTypeof()
    {
        return $this->typeof;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getCity()
    {
        return $this->city;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setTypeof($typeof)
    {
        $this->typeof = $typeof;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
}

