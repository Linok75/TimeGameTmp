<?php
/*
	La classe modèle pour les genres. 
	
*/
class Model_Statut extends Model_Template{
	
	protected $selectAll;
	protected $selectbyId;
	

	public function __construct(){
		parent::__construct();
		$sql = 'SELECT * FROM Statut';
		$this->selectAll = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT statut FROM Statut WHERE idstatut=?';
		$this->selectbyId = Controller_Template::$db->prepare($sql);
	}
	
	public function getAll(){
		$this->selectAll->execute();
		return $this->selectAll->fetchAll();
	}

	public function getById($id){
		$this->selectbyId->execute(array($id));
		return $this->selectbyId->fetchAll();
	}
}

