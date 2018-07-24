<?php

namespace Projet6\Dao;

use Projet6\Model\Annonce;

class AnnonceDao extends BaseDao
{

    public function createAnnonce($title, $content)
    {
        $db = $this->dbConnect();
        $annonces = $db->prepare('INSERT INTO annonces(title, content, creation_date) VALUES(?, ?, NOW())');
        $affectedLines = $annonces->execute(array($title, $content));
        return $affectedLines;
    }


    public function getAnnonceById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, creation_date FROM annonces WHERE id = ' . $id);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);
    }


    public function getannonce($annonceId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, creation_date FROM annonces WHERE id =' . $annonceId);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);   
    }


    public function getAllAnnonces()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces ORDER BY creation_date LIMIT 0, 5');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($posts, new Post($annonceDB));
        }
        return $annonces;
    }

    public function deleteAnnonce($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM annonces WHERE id = ?');
        $req->execute(array($id));
    }



}