<?php

/*
  La classe modèle pour les messages.
 */

class Model_Message extends Model_Template {

    protected $selectDernierMessageAmi;
    protected $selectAllMessageAmi;
    protected $selectEchange;
    protected $selectByIddestAndLu;
    protected $selectByIdmp;
    protected $updateMessageLu;
    protected $envoiMessage;
    protected $updateExpeByIdmp;
    protected $updateDestByIdmp;
    protected $deleteByIdmp;
    

    public function __construct() {
        parent::__construct();
        $sql = 'SELECT * FROM Mp WHERE iddest = ? AND Mp.idmp =(SELECT MAX(idmp) FROM Mp mp1 WHERE mp1.iddest = ? AND mp1.idexpe=Mp.idexpe AND destsupp=0 ) ORDER BY date DESC';
        $this->selectDernierMessageAmi = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Mp WHERE iddest=? AND idexpe=? UNION SELECT * FROM Mp WHERE iddest=? AND idexpe=?';
        $this->selectAllMessageAmi = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Mp SET lu=1 WHERE idmp=?';
        $this->updateMessageLu = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM (SELECT * FROM Mp WHERE iddest=? AND idexpe=? AND destsupp=0 UNION SELECT * FROM Mp WHERE iddest=? AND idexpe=? AND expesupp=0) mp ORDER BY date DESC';
        $this->selectEchange = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Mp WHERE iddest = ? AND lu=0 ORDER BY idmp DESC';
        $this->selectByIddestAndLu = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Mp WHERE idmp=?';
        $this->selectByIdmp = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Mp(idexpe, iddest, message, date, lu) VALUES(?, ?, ?, NOW(), 0)';
        $this->envoiMessage = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Mp SET expesupp=1 WHERE idmp=?';
        $this->updateExpeByIdmp = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Mp SET destsupp=1 WHERE idmp=?';
        $this->updateDestByIdmp = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM Mp WHERE idmp=?';
        $this->deleteByIdmp = Controller_Template::$db->prepare($sql);
        
    }


    public function getDernierMessageAmi($id) {
        $this->selectDernierMessageAmi->execute(array($id, $id));
        return $this->selectDernierMessageAmi->fetchAll();
    }

    public function getAllMessageAmi($id1, $id2) {
        $this->selectAllMessageAmi->execute(array($id1, $id2, $id2, $id1));
        return $this->selectAllMessageAmi->fetchAll();
    }

    public function getEchange($id1, $id2) {
        $this->selectEchange->execute(array($id1, $id2, $id2, $id1));
        return $this->selectEchange->fetchAll();
    }

    public function getByIddestAndLu($id) {
        $this->selectByIddestAndLu->execute(array($id));
        return $this->selectByIddestAndLu->fetchAll();
    }

    public function getByIdmp($id) {
        $this->selectByIdmp->execute(array($id));
        return $this->selectByIdmp->fetchAll();
    }

    public function setMessageLu($id) {
        return $this->updateMessageLu->execute(array($id));
    }

    public function envoiMessage($id1, $id2, $message) {
        return $this->envoiMessage->execute(array($id1, $id2, $message));
    }

    public function setExpeByIdmp($id) {
        return $this->updateExpeByIdmp->execute(array($id));
    }

    public function setDestByIdmp($id) {
        return $this->updateDestByIdmp->execute(array($id));
    }

    public function removeByIdmp($id) {
        return $this->deleteByIdmp->execute(array($id));
    }
    

}
