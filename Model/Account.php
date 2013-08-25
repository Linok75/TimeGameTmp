<?php
class Model_Account extends Model_Template {

    protected $selectAllNickname;
    protected $selectMail;
    protected $selectPassword;
    protected $updatePassword;
    protected $updateMail;
    protected $deleteAccount;
    protected $insertAccount;

    public function __construct() {
        parent::__construct();
        $sql = 'SELECT nickname FROM account';
        $this->selectAllNickname = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT mail FROM account WHERE nickname LIKE ?';
        $this->selectMail = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT password FROM account WHERE nickname LIKE ?';
        $this->selectPassword = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE account SET password = ? WHERE nickname LIKE ?';
        $this->updatePassword = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE account SET mail = ? WHERE nickname LIKE ?';
        $this->updateMail = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM account WHERE nickname LIKE ?';
        $this->deleteAccount = Controller_Template::$db->prepare($sql);

		$sql = 'INSERT INTO account VALUES (?,?,?)';
		$this->insertAccount = Controller_Template::$db->prepare($sql);
    }
    
    public function getAllNickname(){
		$this->selectAllNickname->execute(array());
		return $this->selectAllNickname->fetchAll();
	}

    public function getMail($nickname){
        $this->selectMail->execute(array($nickname));
        return $this->selectMail->fetchAll();
    }

	public function getPassword($nickname){
        $this->selectPassword->execute(array($nickname));
        return $this->selectPassword->fetchAll();
    }
	
	public function setPassword($newPassword,$nickname){
        return $this->updatePassword->execute(array($newPassword,$nickname));
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
