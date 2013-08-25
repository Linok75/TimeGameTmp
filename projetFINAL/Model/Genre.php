<?php
/*
	La classe modèle pour les genres. 
	
*/
class Model_Genre extends Model_Template{
	
	protected $selectAll;
	protected $selectbyId;
        protected $selectByGenre;
	protected $insertionGenre;
	protected $upGenre;
	protected $delGenre;
	

	public function __construct(){
		parent::__construct();
		$sql = 'SELECT * FROM Genre';
		$this->selectAll = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT genre FROM Genre WHERE idgenre=?';
		$this->selectbyId = Controller_Template::$db->prepare($sql);
		
		$sql = 'INSERT INTO Genre (genre) VALUES (?)';
		$this->insertionGenre = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE Genre SET genre=? WHERE idgenre=?';
		$this->upGenre = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM Genre WHERE idgenre=?';
		$this->delGenre= Controller_Template::$db->prepare($sql);
                
                $sql = 'SELECT idgenre FROM Genre WHERE genre LIKE ?';
                $this->selectByGenre = Controller_Template::$db->prepare($sql);
	}
	
	public function getAll(){
		$this->selectAll->execute();
		return $this->selectAll->fetchAll();
	}

	public function getById($id){
		$this->selectbyId->execute(array($id));
		return $this->selectbyId->fetchAll();
	}
	
	public function addGenre($genre){
		$this->insertionGenre->execute(array($genre));
		return $this->insertionGenre->fetchAll();
	}
	
	public function setGenre($genre){
		$this->upManga->execute(array($genre));
		return $this->upManga->fetchAll();
	}
	
	public function removeGenre($id){
		$this->delGenre->execute(array($id));
		return $this->delGenre->fetchAll();
	}
        
        public function getByGenre($genre){
            $this->selectByGenre->execute(array($genre));
            return $this->selectByGenre->fetchAll();
        }
}

