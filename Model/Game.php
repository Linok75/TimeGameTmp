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
	protected $selectNameBreed;
	
	/* Empire */
	
	protected $selectAllEmpire;
	protected $selectNameEmpire;
	
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
	
	public function getIdbreed($idgame){
        $this->selectIdbreed->execute(array($idgame));
		return $this->selectIdbreed->fetchAll();
    }
	
	public function setMail($newMail,$nickname){
        return $this->updateMail->execute(array($newMail,$nickname));
    }
	
	public function removeAccount($nickname){
        return $this->deleteAccount->execute(array($nickname));
    }
	
	public function createAccount($nickname,$mail,$password){
        return $this->insertAccount->execute(array($nickname,$mail,$password));
    }
}
