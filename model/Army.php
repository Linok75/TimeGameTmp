<?php
class Model_Army extends Model_Template {
	
	protected $selectAll;
	protected $selectAllById;
	protected $selectName;
	protected $updateName;
	protected $updateAtkpower;
	protected $updateDefpower;
	protected $updateSpeed;
	protected $insertArmy;
	protected $deleteArmy;
	
	public function __construct() {
		
		parent::__construct();
		$sql = 'SELECT * FROM army';
		$this->selectAll = Controller_Template::$db->prepare($sql);
		
		$sql ='SELECT * FROM army WHERE idarmy = ?';
		$this->selectAllById = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT name FROM army WHERE idarmy = ?';
		$this->selectName = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE army SET name = ? WHERE idarmy = ?';
		$this->updateName = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE army SET atkpower = ? WHERE idarmy = ?';
		$this->updateAtkpower = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE army SET defpower = ? WHERE idarmy = ?';
		$this->updateDefpower = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE army SET speed = ? WHERE idarmy = ?';
		$this->updateSpeed = Controller_Template::$db->prepare($sql);
		
		$sql = 'INSERT INTO army VALUES (?,?,?,?,?)';
		$this->insertArmy = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM army WHERE idarmy = ?';
		$this->deleteArmy = Controller_Template::$db->prepare($sql);
		
	}
	
	public function getAll() {
		
		$this->selectAll->execute(array());
		return $this->selectAll->fetchAll();
		
		}
		
	public function getAllById($idarmy) {
		$this-> selectAllById->execute(array($idarmy));
		return $this->selectAllById->fetchAll();
		}
	
	public function getName($idarmy) {
		$this-> selectName -> execute(array($idarmy));
		return $this->selectName->fetchAll();
		}
	
	public function setName ($newName,$idarmy) {
		return $this->updateName->execute(array($newName,$idarmy);
		}
	
	public function setAtkpower ($newAtkpower,$idarmy) {
		return $this->updateAtkpower->execute(array($newAtkpower,$idarmy);
		}
	
	public function setDefpower ($newDefpower,$idarmy) {
		return $this->updateDefpower->execute(array($newDefpower,$idarmy);
		}
	
	public function setSpeed ($newSpeed,$idarmy) {
		return $this->updateSpeed->execute(array($newSpeed,$idarmy);
		}
		
	public function createArmy($idarmy,$name,$atkpower,$defpower,$speed){
        return $this->insertArmy->execute(array($idarmy,$name,$atkpower,$defpower,$speed));
		}
	
	public function removeArmy($idarmy) {
		return $this->deleteArmy->execute(array($idarmy));
	} 
}
?>
