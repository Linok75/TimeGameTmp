<?php

/*
  La classe modèle pour les utilisateurs.
 */

class Model_Utilisateur extends Model_Template {

    protected $selectAll;
    protected $selectAllTypeUser;
    protected $selectTypeById;
    protected $selectById;
    protected $selectByPseudo;
    protected $selectByPseudoPass;
    protected $insertion;
    protected $deleteUserById;
    protected $updateUser;
    protected $updateTypeUser;
    protected $upPw;
    protected $selectAllAmi;
    protected $delAmi;
    protected $selectAmi;
    protected $ajoutDemandeAmi;
    protected $acceptDemandeAmi;
    protected $recherchAmi;
    protected $upAimeByUser;
    

    /*     * *************UP SAMIR****************** */
    protected $delProfil;
    protected $delAllNote;
    protected $delAllAmi;
    protected $delAllAime;

    /*     * ***************************** */

    public function __construct() {
        parent::__construct();
        $sql = 'UPDATE Aimer SET aime=? WHERE iduser=?';
        $this->upAimeByUser = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT iduser FROM Utilisateur WHERE pseudo LIKE ? AND iduser NOT IN (SELECT iduser1 as iduser FROM Ami WHERE iduser2=? AND demande=1) AND iduser NOT IN
                (SELECT iduser2 as iduser FROM Ami WHERE iduser1=? AND demande=1) ORDER BY pseudo';
        $this->recherchAmi = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT * FROM Utilisateur, TypeUser WHERE Utilisateur.idtype=TypeUser.idtype';
        $this->selectAll = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM TypeUser';
        $this->selectAllTypeUser = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Utilisateur WHERE iduser= ?';
        $this->selectById = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT iduser FROM Utilisateur WHERE pseudo LIKE ?';
        $this->selectByPseudo = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Utilisateur WHERE pseudo = ? AND pass = ?';
        $this->selectByPseudoPass = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Utilisateur(pseudo, pass, nom, prenom, mail, datenaiss, idtype) 
		VALUES(?, ?, ?, ?, ?, ?, 4)';
        $this->insertion = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM Utilisateur WHERE iduser=?';
        $this->deleteUserById = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Utilisateur SET nom=?, prenom=?, mail=?, datenaiss=? WHERE iduser=?';
        $this->updateUser = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM TypeUser WHERE idtype = ?';
        $this->selectTypeById = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Utilisateur SET pass=? WHERE iduser=?';
        $this->upPw = Controller_Template::$db->prepare($sql);

        $sql = '(SELECT iduser1 AS iduser FROM Ami WHERE iduser2=? AND demande=1)UNION
                (SELECT iduser2 AS iduser FROM Ami WHERE iduser1=? AND demande=1)ORDER BY iduser';
        $this->selectAllAmi = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM Ami WHERE (iduser1=? AND iduser2=?) OR (iduser1=? AND iduser2=?)';
        $this->delAmi = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT iduser1, iduser2, demande FROM Ami WHERE (iduser1=? AND iduser2=?) OR (iduser1=? AND iduser2=?)'; //AND demande=1';
        $this->selectAmi = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Ami(iduser1,iduser2,demande) VALUES (?,?,0)';
        $this->ajoutDemandeAmi = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Ami SET demande=1 WHERE iduser1=? AND iduser2=?';
        $this->acceptDemandeAmi = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Utilisateur SET idtype = ? WHERE iduser = ?';
        $this->updateTypeUser = Controller_Template::$db->prepare($sql);

        /*         * **************UP SAMIR****************** */
        $sql = 'DELETE from Profil where iduser = ?';
        $this->delProfil = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Note where iduser = ?';
        $this->delAllNote = Controller_Template::$db->prepare($sql);
        
        $sql = 'DELETE FROM Aimer WHERE iduser = ?';
        $this->delAllAime = Controller_Template::$db->prepare($sql);
        
        $sql='DELETE FROM Ami WHERE iduser1 = ? OR iduser2 = ?';
        $this->delAllAmi = Controller_Template::$db->prepare($sql);
        /*         * ********************************** */
    }
    
    public function setAimeByUser($aime,$iduser){
		return $this->upAimeByUser->execute(array($aime,$iduser));
	}

    public function searchUser($pseudo,$iduser){
        $this->recherchAmi->execute(array($pseudo,$iduser,$iduser));
        return $this->recherchAmi->fetchAll();
    }
    
    public function setTypeUser($idType, $idUser) {
        return $this->updateTypeUser->execute(array($idType, $idUser));
    }

    public function getAllAmi($id) {
        $this->selectAllAmi->execute(array($id, $id));
        return $this->selectAllAmi->fetchAll();
    }

    public function supprAmi($iduser1, $iduser2) {
        return $this->delAmi->execute(array($iduser1, $iduser2, $iduser2, $iduser1));
    }

    public function getAmi($iduser1, $iduser2) {
        $this->selectAmi->execute(array($iduser1, $iduser2, $iduser2, $iduser1));
        return $this->selectAmi->fetchAll();
    }

    public function demandeAmi($iduser1, $iduser2) {
        return $this->ajoutDemandeAmi->execute(array($iduser1, $iduser2));
    }

    public function acceptAmi($iduser1, $iduser2) {
        return $this->acceptDemandeAmi->execute(array($iduser1, $iduser2));
    }

    public function getAll() {
        $this->selectAll->execute(array());
        return $this->selectAll->fetchAll();
    }

    public function getAllTypeUser() {
        $this->selectAllTypeUser->execute(array());
        return $this->selectAllTypeUser->fetchAll();
    }

    public function getById($id) {
        $this->selectById->execute(array($id));
        return $this->selectById->fetchAll();
    }

    public function getByPseudo($pseudo) {
        $this->selectByPseudo->execute(array($pseudo));
        return $this->selectByPseudo->fetchAll();
    }

    public function getByPseudoPass($pseudo, $pass) {
        $this->selectByPseudoPass->execute(array($pseudo, $pass));
        return $this->selectByPseudoPass->fetchAll();
    }

    public function addUtilisateur($pseudo, $pass, $nom, $prenom, $mail, $datenaiss) {
        return $this->insertion->execute(array($pseudo, $pass, $nom, $prenom, $mail, $datenaiss));
    }

    public function removeUserById($id) {
        return $this->deleteUserById->execute(array($id));
    }

    public function setUtilisateur($nom, $prenom, $mail, $datenaiss, $iduser) {
        return $this->updateUser->execute(array($nom, $prenom, $mail, $datenaiss, $iduser));
    }

    public function testConnexion($pseudo, $pass) {
        return $this->testConnexion->execute(array($pseudo, $pass));
    }

    public function getTypeById($id) {
        $this->selectTypeById->execute(array($id));
        return $this->selectTypeById->fetchAll();
    }

    public function setPw($pass, $id) {
        return $this->upPw->execute(array($pass, $id));
    }

    /*     * *********************SAMIR UP********************** */

    public function delProfil($iduser) {
        return $this->delProfil->execute(array($iduser));
    }

    public function delAllNote($iduser) {
        return $this->delAllNote->execute(array($iduser));
    }
    
    public function delAllAime($iduser) {
        return $this->delAllAime->execute(array($iduser));
    }
    
    public function delAllAmi($iduser) {
        return $this->delAllAmi->execute(array($iduser,$iduser));
    }

    /*     * ********************************************* */
}
