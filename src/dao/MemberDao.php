<?php

namespace Projet6\Dao;


use Projet6\Model\Member;

class MemberDao extends BaseDao
{
    /** Permet de creer un nouveau membre*/
    public function createMember($pseudo, $pass, $email)
    {
        $db = $this->dbConnect();
        $member = $db->prepare('INSERT INTO member(pseudo, pass, email, date_inscription ) VALUES(?, ?, ?, NOW())');
        $affectedLines = $member->execute(array($pseudo, $pass, $email));
        return $affectedLines;
    }
/******************************************************/
    /**Retourne une annonce suivant son id*/
    public function getMemberById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,pseudo, pass, emaail, date_inscription FROM member WHERE id = ' . $id);
        $req->execute();
        $memberData = $req->fetch();
        return new Member($memberData);
    }
  /***********************************/



    /** Permet de recuperer un utilisateur pour la connexion*/
    public function getByEmail($mailconnect)
    {
        $db = $this->dbConnect();
        $requser = $db->prepare('SELECT * FROM member WHERE email = ?');
        $requser->execute([$mailconnect]);
        return $requser->fetchObject(Member::class);
    }

    /** Permet de recuperer l'admin pour la connexion*/
    public function getByEmailMaster($mailconnect)
    {
        $db = $this->dbConnect();
        $requser = $db->prepare('SELECT * FROM member WHERE email = master2@hotmail.fr');
        $requser->execute([$mailconnect]);
        return $requser->fetchObject(Member::class);
    }
}
