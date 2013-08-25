<?php
/*
	La classe modèle pour les profils. 
*/
class Model_Profil extends Model_Template{

	protected $insertion;
        protected $updateProfil;
	protected $updateLastCo;
	protected $updateStatut;
	protected $updateAvatar;
	protected $updateDescriptionCivilite;
	protected $selectProfil;
	protected $deleteProfilById;
	protected $selectDemandeAmi;
	protected $selectMessNonLu;
	protected $selectAvatarStatut;

	public function __construct(){
		parent::__construct();
		
		$sql = 'INSERT INTO Profil(iduser, dateinscri, avatar) 
		VALUES(?, NOW(), "defaut.png")';
		$this->insertion = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE Profil SET datelastco=NOW() WHERE iduser=?';
		$this->updateLastCo = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE Profil SET statut=? WHERE iduser=?';
		$this->updateStatut = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE Profil SET description=?,civilite=? WHERE iduser=?';
		$this->updateDescriptionCivilite = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM Profil WHERE iduser = ?';
		$this->selectProfil = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM Profil WHERE iduser=?';
		$this->deleteProfilById = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT Utilisateur.pseudo, Profil.avatar FROM Ami,Utilisateur,Profil WHERE Utilisateur.iduser=Ami.iduser1 AND Profil.iduser=Ami.iduser1 AND iduser2 = ? AND demande=0';
		$this->selectDemandeAmi = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT avatar,statut FROM Profil WHERE iduser = ?';
		$this->selectAvatarStatut = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT idmp,message,Utilisateur.pseudo, Profil.avatar FROM Mp,Profil,Utilisateur WHERE Utilisateur.iduser=Mp.idexpe AND Profil.iduser=Mp.idexpe AND iddest= ? AND lu=0 ORDER BY date DESC';
		$this->selectMessNonLu = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE Profil SET avatar=? WHERE iduser=?';
		$this->updateAvatar = Controller_Template::$db->prepare($sql);
                
                $sql = 'UPDATE Profil SET description=?, civilite=?, animefav=?, mangafav=?, genrefav=? WHERE iduser=?';
                $this->updateProfil = Controller_Template::$db->prepare($sql);
	}
	
	public function addProfil($iduser){
		return $this->insertion->execute(array($iduser));
	}
	
	public function setLastCo($id){
		return $this->updateLastCo->execute(array($id));
	}
	
	public function setStatut($statut,$id){
		return $this->updateStatut->execute(array($statut,$id));
	}
	
	public function setDescriptionCivilite($id){
		return $this->updateDescriptionCivilite->execute(array($description, $civilite, $id));
	}
	
	public function getById($id){
		$this->selectProfil->execute(array($id));
		return $this->selectProfil->fetchAll();
	}
	
	public function removeProfil($id){
		return $this->deleteProfilById->execute(array($id));
	}
	
	public function getDemandeAmi($id){
		$this->selectDemandeAmi->execute(array($id));
		return $this->selectDemandeAmi->fetchAll();
	}
	
	public function getMessNonLu($id){
		$this->selectMessNonLu->execute(array($id));
		return $this->selectMessNonLu->fetchAll();
	}
	
	public function getAvatarStatut($id){
		$this->selectAvatarStatut->execute(array($id));
		return $this->selectAvatarStatut->fetchAll();
	}
	
	public function setAvatar($avatar,$id){
		return $this->updateAvatar->execute(array($avatar,$id));
	}
        
        public function setProfil($description,$civilite,$animeFav,$mangaFav,$genreFav,$id){
            return $this->updateProfil->execute(array($description,$civilite,$animeFav,$mangaFav,$genreFav,$id));
        }
}
