<?php

class Controller_Message extends Controller_Template {

    private $utilisateurModel;
    private $profilModel;
    private $messageModel;

    public function __construct() {
        parent::__construct();
        $this->utilisateurModel = new Model_Utilisateur();
        $this->profilModel = new Model_Profil();
        $this->messageModel = new Model_Message();
    }

    public function listeMessage() {
        $liste = $this->messageModel->getDernierMessageAmi(bdsql($_SESSION['id']));
        
        for ($i = 0, $size = count($liste); $i < $size; $i++) {
			$liste[$i]['utilisateur'] = $this->utilisateurModel->getByid($liste[$i]['idexpe']);
			$liste[$i]['profil'] = $this->profilModel->getByid($liste[$i]['idexpe']);

			$this->messageModel->setMessageLu($liste[$i]['idmp']);
		}


        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Utilisateur/listeMessage.php';
        require 'View/footer.php';
    }

    public function filMp() {
    	$pseudo=$_GET['ami'];
    	$liste = $this->utilisateurModel->getByPseudo(bdSql($pseudo));
		$id = $liste[0]['iduser'];

		$liste = $this->messageModel->getEchange(bdSql($_SESSION['id']), bdSql($id), bdSql($id), bdSql($_SESSION['id']));
		for ($i = 0, $size = count($liste); $i < $size; $i++) {
			$liste[$i]['utilisateur'] = $this->utilisateurModel->getByid($liste[$i]['idexpe']);
			$liste[$i]['profil'] = $this->profilModel->getByid($liste[$i]['idexpe']);

			$this->messageModel->setMessageLu($liste[$i]['idmp']);
		}

		header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Utilisateur/filMp.php';
        require 'View/footer.php';
    }

    public function formMp() {
    	$pseudo=$_GET['ami'];
    	$liste = $this->utilisateurModel->getByPseudo(bdSql($pseudo));
		$id = $liste[0]['iduser'];
		$liste = $this->utilisateurModel->getAmi(bdSql($id), bdSql($_SESSION['id']));
		$err = '';

		if(!empty($id)) {	
					if(count($liste)>0) {
						$err = 	'<h3 class="featurette-heading">Message privé pour <span class="muted">'.$pseudo.'</span></h3>
								<div class="well"><form action="index.php?module=Message&action=envoiMp" method="post">
									<p><label for="message">Votre message:</label>
									<input type="hidden" name="pseudo" value="'.$pseudo.'"> 
									<textarea class="span6" name="message" id="message"></textarea></p>
									<p><button class="btn btn-large btn-primary" type="submit">Envoyer</button></p>
		    					</form></div>';
					} else {
						$err = '<p>Vous n\'êtes pas ami</p>';
					}
		} else {
					$err = '<p>Membre inexistant !</p>';
		}	

		$this->listeMessage();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function envoiMp() {
    	$err = '';
    	$pseudo=$_POST['pseudo'];
		$message=$_POST['message'];
		$liste = $this->utilisateurModel->getByPseudo(bdSql($pseudo));
		$id = $liste[0]['iduser'];
		$liste = $this->utilisateurModel->getAmi(bdSql($id), bdSql($_SESSION['id']));

		if(!empty($message)) {	
			if(!empty($id)) {	
				if(count($liste)>0) {
					$this->messageModel->envoiMessage($_SESSION['id'], $id, bdSql($message));
					$err = '<p>Message envoyé !</p>';

				} else {
					$err =  '<p>Vous n\'êtes pas ami</p>';
				}
			} else {
				$err =  '</p>Membre inexistant !</p>';
			}	
		} else {
			$err = '<p>Pas de message vide !</p>';
		}

		$this->listeMessage();
        if (!empty($err)) {
            require 'View/err.php';
        }	
    }

    public function rafraichirMp() {
    	$liste = $this->messageModel->getByIddestAndLu(bdSql($_SESSION['id']));
    	for ($i = 0, $size = count($liste); $i < $size; $i++) {
    		$idmp = $liste[$i]['idmp'];
    		$this->messageModel->setMessageLu($idmp);
		}

		$this->listeMessage();
    }

    public function suppUnMessage() {
    	//$this->rafraichirMp();
    	$idmp=$_GET['mp'];
		$err = '';
    	$liste = $this->messageModel->getByIdmp(bdSql($idmp));
    	$nb = count($liste);
    	$idexpe = $liste[0]['idexpe'];
    	$iddest = $liste[0]['iddest'];
    	$dest=-1;
					
		if($iddest==$_SESSION['id']) {
			$dest=1;
		} else if($idexpe==$_SESSION['id']) {
			$dest=0;
		}


		if($nb>0) {
			if($dest==0) {
				$this->messageModel->setExpeByIdmp($idmp);
				$err = '</p>Message supprimé</p>';
			} else if ($dest==1) {
				$this->messageModel->setDestByIdmp($idmp);
				$err = '</p>Message supprimé</p>';
			}

			$expesupp = $liste[0]['expesupp'];
			$destsupp = $liste[0]['destsupp'];
			if($expesupp==1 AND $destsupp==1) {
				$this->messageModel->removeByIdmp($idmp);
			}

		} else {
			$err = '</p>Message inexistant</p>';
		}

		$this->listeMessage();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function suppAllMessages() {
    	$allPseudo=$_GET['allMp'];
    	$err = '';
    	$liste = $this->utilisateurModel->getByPseudo(bdSql($allPseudo));
		$id = $liste[0]['iduser'];

		$liste = $this->messageModel->getAllMessageAmi($_SESSION['id'], $id, $id, $_SESSION['id']);
		for ($i = 0, $size = count($liste); $i < $size; $i++) {
			$iddest = $liste[$i]['iddest'];
			$idexpe = $liste[$i]['idexpe'];
			$idmp = $liste[$i]['idmp'];

			$dest=-1;
			if($iddest==$_SESSION['id']) {
				$dest=1;
			} else if($idexpe==$_SESSION['id']) {
				$dest=0;
			}

			if($dest==0) {
				$this->messageModel->setExpeByIdmp($idmp);
				$err =  '</p>Message supprimé</p>';
			} else if ($dest==1) {
				$this->messageModel->setDestByIdmp($idmp);
				$err =  '</p>Message supprimé</p>';
			}

			$expesupp = $liste[$i]['expesupp'];
			$destsupp = $liste[$i]['destsupp'];
			if($expesupp==1 AND $destsupp==1) {
				$this->messageModel->removeByIdmp($idmp);
			}

		}

		$this->listeMessage();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }


 
}
?>
