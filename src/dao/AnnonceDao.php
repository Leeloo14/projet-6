<?php

namespace Projet6\Dao;

use Projet6\Model\Annonce;

require_once 'BaseDao';

class AnnonceDao extends BaseDao
{
    /**Creer une nouvelle annonce*/
    public function createAnnonce($title, $content, $typeof, $tel, $email, $city, $author)
    {
        $db = $this->dbConnect();
        $annonces = $db->prepare('INSERT INTO annonces (title, content,typeof , tel ,email,city, author, creation_date) VALUES(?, ?,?,?,?,?,?, NOW())');
        $affectedLines = $annonces->execute(array($title, $content, $typeof, $tel, $email, $city, $author));
        return $affectedLines;
    }

    /**Retourne une annonce suivant son id*/
    public function getAnnonceById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,title, content,typeof , tel ,email,city, author , creation_date FROM annonces WHERE id = ' . $id);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);
    }

    /**retourne un épisode*/
    public function getannonce($annonceId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,title, content,typeof , tel ,email,city,  creation_date FROM annonces WHERE id =' . $annonceId);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);
    }

    /**Retourne toutes les annonces*/
    public function getAllAnnonces()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces ORDER BY creation_date');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }

    /**Retourne les annonces type recherche*/
    public function getTypeOfAnnoncesSearch()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces WHERE typeof = "recherche"');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }

    /**Retourne les annonces type */
    public function getTypeOfAnnoncesGive()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces WHERE typeof = "propose"');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }

    /** permet de supprimer un épisode */
    public function deleteAnnonce($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM annonces WHERE id = ?');
        $req->execute(array($id));
    }
    /** renvoie la liste des annonces liées a un utilisateur */
    /**A définir*/
    public function getMyAnnonces()
    {
        $db = $this->dbConnect();

    }

    /** permet de mettre à jour une annonce */
    public function updateAnnonce($id, $title, $content, $typeof, $tel, $email, $city)
    {
        $db = $this->dbConnect();
        $annonce = $db->prepare('UPDATE annonces SET title = ?, content = ?,typeof =?, tel = ?, email = ?, city = ? WHERE id = ?');
        $affectedLine = $annonce->execute(array($title, $content, $typeof, $tel, $email, $city));
        return $affectedLine;
    }


}