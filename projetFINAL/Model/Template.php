<?php
/*
	Ce modèle sert de classe père pour les autres classes modèles. 
	Il instancie les méthodes "getAll" et "getById" et définit les propriétés "selectAll" et "selectById" qui seront remplies dans chaque classes fille par une requête SQL préparée.
*/

abstract class Model_Template{

	protected $selectById;

	public function __construct(){
		
	}

	public function getById($id){
		$this->selectById->execute(array($id));
		return $this->selectById->fetchAll();
	}
}

