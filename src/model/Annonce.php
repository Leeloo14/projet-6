<?php

namespace Projet6\Model;

class Annonce
{
    private $id;
    private $title;
    private $content;
    private $creationDate;
    private $type;
    private $tel;

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
        if (isset($annonceData['type'])) {
            $this->type = $annonceData['type'];

        }
        if (isset($annonceData['tel'])) {
            $this->tel = $annonceData['tel'];
        }
        if (isset($annonceData['creation_date'])) {
            $this->creationDate = date_create_from_format('Y-m-d H:i:s', $annonceData['creation_date']);
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

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTel()
    {
        return $this->tel;
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

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }
}

