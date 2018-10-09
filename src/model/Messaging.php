<?php

namespace Projet6\Model;

class Messaging
{
    private $id;
    private $firstName;
    private $surname;
    private $email;
    private $tel;
    private $message;
    private $creationDate;
    private $object;
    private $status;

    function __construct($messagingData)
    {
        if (isset($messagingData['id'])) {
            $this->id = $messagingData['id'];
        }
        if (isset($messagingData['first_name'])) {
            $this->firstName = $messagingData['first_name'];
        }
        if (isset($messagingData['surname'])) {
            $this->surname = $messagingData['surname'];
        }
        if (isset($messagingData['email'])) {
            $this->email = $messagingData['email'];
        }
        if (isset($messagingData['tel'])) {
            $this->tel = $messagingData['tel'];
        }
        if (isset($messagingData['message'])) {
            $this->message = $messagingData['message'];
        }
        if (isset($messagingData['creation_date'])) {
            $this->creationDate = date_create_from_format('Y-m-d H:i:s', $messagingData['creation_date']);
        }
        if (isset($messagingData['object'])) {
            $this->object = $messagingData['object'];
        }
        if (isset($messagingData['status'])) {
            $this->status = $messagingData['status'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}

