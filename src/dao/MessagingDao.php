<?php

namespace Projet6\Dao;

use Projet6\Model\Messaging;

class MessagingDao extends BaseDao
{
    /**envoyer un message*/
    public function createMessage($first_name,  $surname, $email, $tel, $object, $message)
    {
        $db = $this->dbConnect();
        $messaging = $db->prepare('INSERT INTO messaging (first_name, surname,email , tel,object , message, creation_date, status) VALUES(?, ?,?,?,?,?,NOW(),"Non traité")');
        $affectedLines = $messaging->execute(array($first_name,  $surname, $email, $tel,$object, $message ));
        return $affectedLines;
    }



/**Retourne les messages*/
public function getAllMessages()
{
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM messaging ORDER BY creation_date');
    $req->execute();
    $messagingsDB = $req->fetchAll();
    $messagings = [];
    foreach ($messagingsDB as $messagingDB) {
        array_push($messagings, new Messaging($messagingDB));
    }
    return $messagings;
}



    /** permet de supprimer un message */
    public function deleteMessage($messagingId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM messaging WHERE id = ?');
        $req->execute(array($messagingId));
    }

}