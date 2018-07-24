<?php

namespace Projet6\Model;

class Annonce
{
    private $id;
    private $title;
    private $content;
    private $creationDate;


    function __construct($postData) {
        if (isset($postData['id'])){
            $this->id = $postData['id'];
        }
        if (isset($postData['title'])){
            $this->title = $postData['title'];
        }
        if (isset($postData['content'])){
            $this->content = $postData['content'];
        }
        if (isset($postData['creation_date'])){
            $this->creationDate = date_create_from_format('Y-m-d H:i:s', $postData['creation_date']);
        }
    }

    // GETTERS //

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


    // SETTERS //

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

}

?>
