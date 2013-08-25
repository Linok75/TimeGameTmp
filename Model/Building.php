<?php
class Model_Building extends Model_Template {

    protected $selectAll;
    protected $selectAllById;
    protected $selectName;
    protected $updateName;
    protected $updateMaxlv;
    protected $deleteBuilding;
    protected $insertBuilding;

    public function __construct() {
        parent::__construct();
        $sql = 'SELECT * FROM building';
        $this->selectAll = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT * FROM building WHERE idbuilding = ?';
        $this->selectAllById = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT name FROM building WHERE idbuilding = ?';
        $this->selectName = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE building SET name = ? WHERE idbuilding = ?';
        $this->updateName = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE building SET maxlv = ? WHERE idbuilding = ?';
        $this->updateMaxlv = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM building WHERE idbuilding = ?';
        $this->deleteBuilding = Controller_Template::$db->prepare($sql);

		$sql = 'INSERT INTO building VALUES (?,?,?)';
		$this->insertBuilding = Controller_Template::$db->prepare($sql);
    }
    
    public function getAll(){
		$this->selectAll->execute(array());
		return $this->selectAll->fetchAll();
	}

    public function getAllById($idbuilding){
        $this->selectAllById->execute(array($idbuilding));
        return $this->selectAllById->fetchAll();
    }

	public function getName($idbuilding){
        $this->selectName->execute(array($idbuilding));
        return $this->selectName->fetchAll();
    }
	
	public function setName($newName,$idbuilding){
        return $this->updateName->execute(array($newName,$idbuilding));
    }
	
	public function setMaxlv($newMaxlv,$idbuilding){
        return $this->updateMaxlv->execute(array($newMaxlv,$idbuilding));
    }
	
	public function removeBuilding($idbuilding){
        return $this->deleteBuilding->execute(array($idbuilding));
    }
	
	public function createBuilding($idbuilding,$name,$maxlv){
        return $this->insertBuilding->execute(array($idbuilding,$name,$maxlv));
    }
}
