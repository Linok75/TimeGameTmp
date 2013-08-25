<?php
class Model_Game extends Model_Template {

	/* Game */
	
    protected $selectIdgameByDual;
    protected $selectGame;
    protected $selectIdserver;
    protected $selectIdbreed;
    protected $selectIdempire;
    protected $selectIdguild;
    protected $selectIdage;
	protected $updateIdempire;
	protected $updateIdguild;
	protected $updateIdage;
	protected $deleteGame;
	protected $insertGame;
	
	/* Breed */
	
	protected $selectAllBreed;
	protected $selectOneBreed;
	
	/* Empire */
	
	protected $selectAllEmpire;
	protected $selectOneEmpire;
	
	/* Guild */
	
	protected $selectAllGuild;
	protected $selectOneGuild;
	protected $updateMembernumber;
	protected $updateDescription;
	protected $deleteGuild;
	protected $insertGuild;

    public function __construct() {
        parent::__construct();
        $sql = 'SELECT idgame FROM game WHERE nickname LIKE ? AND idserver = ?';
        $this->selectIdgameByDual = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT * FROM game WHERE idgame = ?';
        $this->selectGame = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT idserver FROM game WHERE idgame = ?';
        $this->selectIdserver = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idbreed FROM game WHERE idgame = ?';
        $this->selectIdbreed = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT idempire FROM game WHERE idgame = ?';
        $this->selectIdempire = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT idguild FROM game WHERE idgame = ?';
        $this->selectIdguild = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT idage FROM game WHERE idgame = ?';
        $this->selectIdage = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE game SET idempire = ? WHERE idgame = ?';
        $this->updateIdempire = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE game SET idguild = ? WHERE idgame = ?';
        $this->updateIdguild = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT game SET idage = ? WHERE idgame = ?';
        $this->updateIdage = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM game WHERE idgame = ?';
        $this->deleteGame = Controller_Template::$db->prepare($sql);
		
		$sql = 'INSERT INTO game (nickname,idserver,idbreed,idempire,idguild,idage) VALUES (?,?,?,?,?,?)';
        $this->insertGame = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM breed';
        $this->selectAllBreed = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM breed WHERE idbreed = ?';
        $this->selectOneBreed = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM empire';
        $this->selectAllEmpire = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM empire WHERE idempire = ?';
        $this->selectOneEmpire = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM guild';
        $this->selectAllGuild = Controller_Template::$db->prepare($sql);
		
		$sql = 'SELECT * FROM guild WHERE idguild = ?';
        $this->selectOneGuild = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE game SET membernumber = ? WHERE idguild = ?';
        $this->updateMembernumber = Controller_Template::$db->prepare($sql);
		
		$sql = 'UPDATE game SET description = ? WHERE idguild = ?';
        $this->updateDescription = Controller_Template::$db->prepare($sql);
		
		$sql = 'DELETE FROM guild WHERE idguild = ?';
        $this->deleteGuild = Controller_Template::$db->prepare($sql);
		
		$sql = 'INSERT INTO guild (name,membernumber,description) VALUES (?,?,?)';
        $this->insertGuild = Controller_Template::$db->prepare($sql);
    }
    
    public function getIdgame($nickname,$idserver){
		$this->selectIdgameByDual->execute(array($nickname,$idserver));
		return $this->selectIdgameByDual->fetchAll();
	}

    public function getGame($idgame){
        $this->selectGame->execute(array($idgame));
        return $this->selectGame->fetchAll();
    }

	public function getIdserver($idgame){
        $this->selectIdserver->execute(array($idgame));
        return $this->selectIdserver->fetchAll();
    }
	
	public function getIdbreed($idgame){
        $this->selectIdbreed->execute(array($idgame));
		return $this->selectIdbreed->fetchAll();
    }
	
	public function getIdempire($idgame){
        $this->selectIdempire->execute(array($idgame));
		return $this->selectIdempire->fetchAll();
    }
	
	public function getIdguild($idgame){
        $this->selectIdguild->execute(array($idgame));
		return $this->selectIdguild->fetchAll();
    }
	
	public function getIdage($idgame){
        $this->selectIdage->execute(array($idgame));
		return $this->selectIdage->fetchAll();
    }
	
	public function removeGame($idgame){
        return $this->deleteGame->execute(array($idgame));
    }
	
	public function createGame($nickname,$idserver,$idbreed,$idempire,$idguild,$idage){
        return $this->insertGame->execute(array($nickname,$idserver,$idbreed,$idempire,$idguild,$idage));
    }
	
	public function getAllBreed(){
		$this->selectAllBreed->execute(array());
		return $this->selectAllBreed->fetchAll();
	}
	
	public function getOneBreed($idbreed){
		$this->selectOneBreed->execute(array($idbreed));
		return $this->selectOneBreed->fetchAll();
	}
	
	public function getAllEmpire(){
		$this->selectAllEmpire->execute(array());
		return $this->selectAllEmpire->fetchAll();
	}
	
	public function getOneEmpire($idempire){
		$this->selectOneEmpire->execute(array($idempire));
		return $this->selectOneEmpire->fetchAll();
	}
	
	public function getAllGuild(){
		$this->selectAllGuild->execute(array());
		return $this->selectAllGuild->fetchAll();
	}
	
	public function getOneGuild($idguild){
		$this->selectOneGuild->execute(array($idguild));
		return $this->selectOneGuild->fetchAll();
	}
	
	public function setMembernumber($idguild){
        return $this->updateMembernumber^->execute(array($idguild));
    }
	
	public function setDescription($idguild){
        return $this->updateDescription->execute(array($idguild));
    }
	
	public function removeGuild($idguild){
        return $this->deleteGuild->execute(array($idguild));
    }
	
	public function createGuild($name,$membernumber,$description){
        return $this->insertGuild->execute(array($name,$membernumber,$description));
    }
}
?>