<?php

namespace Projet6\Model;

class Annonce
{
    private $id;
    private $title;
    private $content;
    private $typeof;
    private $tel;
    private $email;
    private $city;
    private $author;
    private $creationDate;
    private $spam;
    private $image;


    function __construct($annonceData)
    {
        if (isset($annonceData['id'])) {
            $this->id = $annonceData['id'];
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
        if (isset($annonceData['email'])) {
            $this->email = $annonceData['email'];
        }
        if (isset($annonceData['city'])) {
            $this->city = $annonceData['city'];
        }
        if (isset($annonceData['author'])) {
            $this->author = $annonceData['author'];
        }
        if (isset($annonceData['creation_date'])) {
            $this->creationDate = date_create_from_format('Y-m-d H:i:s', $annonceData['creation_date']);
        }
        if (isset($annonceData['spam'])) {
            $this->spam = $annonceData['spam'];
        }
        if (isset($annonceData['image'])) {
            $this->image = $annonceData['image'];
        }
    }

    public function getId()
    {
        return $this->id;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
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

    public function getAuthor()
    {
        return $this->author;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getSpam()
    {
        return $this->spam;
    }
    public function getImage()
    {
        return $this->image;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
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

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setSpam($spam)
    {
        $this->spam = $spam;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

}

