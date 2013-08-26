<?php

class Controller_Account extends Controller_Template {

    public function __construct() {
        parent::__construct();
        $this->accountModel = new Model_Account();
    }

    public function connection() {
		$gameModel = new Model_Game();
        $connection = false;
        $password = $this->accountModel->getPassword($_POST['nickname']);

        if (!empty($password) && $password[0]['password'] == sha1($_POST['password'])) {
            $connection = true;
            $_SESSION['nickname'] = $_POST['nickname'];
            $game = $gameModel->getGameByNickname($_SESSION['nickname']);
			$gameEmpty = true;
			if(!empty($game)){
				$gameEmpty = false;
				$guild = array();
				$breed = array();
				$empire = array();
				$age = array();
			
				for($i=0;$i<count($game);$i++){
					$guild[$i] = $gameModel->getOneGuild($game[$i]['idguild']);
					$breed[$i] = $gameModel->getOneBreed($game[$i]['idbreed']);
					$empire[$i] = $gameModel->getOneEmpire($game[$i]['idempire']);
					$age[$i] = $gameModel->getOneAge($game[$i]['idage']);
				}
			}
        }
		
		// require of view
    }

	public function inscription(){
		$validate = false;
		
		if(empty($this->accountModel->checkUnicity($_POST['nickname'],$_POST['mail']))){
			$validate = true;
			$this->accountModel->createAccount($_POST['nickname'],$_POST['mail'],$_POST['password']);
		}
		
		// require of view
	}
}

?>