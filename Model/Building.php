<?php
class Model_Building extends Model_Template {

	/* Building */

    protected $selectAll;
    protected $selectAllById;
    protected $selectName;
    protected $updateName;
    protected $updateMaxlv;
    protected $deleteBuilding;
    protected $insertBuilding;
	
	/* Owned Building */
	
	protected $selectAllByIdgame;
	protected $selectOne;
	protected $updateLv;
	protected $deleteOne;

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

		$sql = 'INSERT INTO building (name, maxlv) VALUES (?,?)';
		$this->insertBuilding = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM ownedbuilding WHERE idgame = ?';
		$this->selectAllByIdgame = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM ownedbuilding WHERE idgame = ? AND idbuilding = ?';
		$this->selectOne = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE ownedbuilding SET lv = ? WHERE idgame = ? AND idbuilding = ?';
		$this->updateLv = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM ownedbuilding WHERE idgame = ? AND idbuilding = ?';
		$this->deleteOne = Controller_Template::$db->prepare($sql);
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
	
	public function createBuilding($name,$maxlv){
        return $this->insertBuilding->execute(array($name,$maxlv));
    }
	
	public function getAllOwnedBuilding($idgame){
		return $this->selectAllByIdgame->execute(array($idgame));
	}
	
	public function getOneOwnedBuilding($idgame,$idbuilding){
		return $this->selectOne->execute(array($idgame,$idbuilding));
	}
	
	public function setOwnedBuildingLv($idgame,$idbuilding){
		return $this->updateLv->execute(array($idgame,$idbuilding));
	}
	
	public function removeOwnedBuilding($idgame,$idbuilding){
		return $this->deleteOne->execute(array($idgame,$idbuilding));
	}
}
