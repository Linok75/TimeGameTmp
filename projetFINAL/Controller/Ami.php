<?php

class Controller_Ami extends Controller_Template {

    private $utilisateurModel;
    private $profilModel;
    private $animeModel;
    private $mangaModel;
    private $genreModel;

    public function __construct() {
        parent::__construct();
        $this->utilisateurModel = new Model_Utilisateur();
        $this->profilModel = new Model_Profil();
        $this->animeModel = new Model_Anime();
        $this->mangaModel = new Model_Manga();
        $this->genreModel = new Model_Genre();
    }

    public function listeAmi() {
        $liste = $this->utilisateurModel->getAllAmi($_SESSION['id']);
        
        for ($i = 0, $size = count($liste); $i < $size; $i++) {
			$liste[$i]['utilisateur'] = $this->utilisateurModel->getByid($liste[$i]['iduser']);
			$liste[$i]['profil'] = $this->profilModel->getByid($liste[$i]['iduser']);
		}
        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Utilisateur/listeAmi.php';
        require 'View/footer.php';
    }
    
    public function pagePerso() {
			$pseudo = $_GET['pseudo'];
			$liste = $this->utilisateurModel->getByPseudo(bdSql($pseudo));
			$id = $liste[0]['iduser'];
			
			$liste = $this->profilModel->getById($id);
			$statut = $liste[0]['statut']; 
			$avatar = $liste[0]['avatar']; 
			$description = $liste[0]['description']; 
			$manga = $liste[0]['mangafav']; 
			$anime = $liste[0]['animefav']; 
			$genre = $liste[0]['genrefav']; 
			
			if(empty($statut)) {
				$statut="NON RENSEIGNE";
			}
			if(empty($description)) {
				$description="NON RENSEIGNE";
			}

			if($anime==0) {
				$titreAnime='"NON RENSEIGNE"';
			} else {
				$liste = $this->animeModel->getById($anime);
				$titreAnime = $liste[0]['titre']; 
			}	

			if($manga==0) {
				$titreManga='"NON RENSEIGNE"';
			} else {
				$liste = $this->mangaModel->getById($manga);
				$titreManga = $liste[0]['titre'];
			}	

			if($genre==0) {
				$titreGenre='"NON RENSEIGNE"';
			} else {
				$liste = $this->genreModel->getById($genre);
				$titreGenre = $liste[0]['genre'];
			}	

			$liste = $this->utilisateurModel->getAllAmi($id);
			for ($i = 0, $size = count($liste); $i < $size; $i++) {
				$liste[$i]['utilisateur'] = $this->utilisateurModel->getByid($liste[$i]['iduser']);
				$liste[$i]['profil'] = $this->profilModel->getByid($liste[$i]['iduser']);
			}
        
			header('Content-Type: text/html; charset=utf-8');
			require 'View/header.php';
			Controller_Template::$profil->menuGauche();
			require 'View/Utilisateur/pagePerso.php';
			require 'View/footer.php';
    }

    public function demandeAmi() {
		$ami=$_GET['ami'];
		$err = '';

		$liste = $this->utilisateurModel->getByPseudo(bdSql($ami));
		$id = $liste[0]['iduser'];

		$liste = $this->utilisateurModel->getAmi(bdSql($id), bdSql($_SESSION['id']));

		if(!empty($id)) {
			if($_SESSION['pseudo']!==$ami) {
				if(count($liste)==0) {
					$this->utilisateurModel->demandeAmi($_SESSION['id'], $id);
					$err = 'Demande effectué, veuillez maintenant attendre sa réponse !';
				} else {
					$err = 'Vous êtes deja ami ou cette personne vous a déjà envoyé une demande, dans ce cas acceptez sa demande !';
				} 
			} else {
				$err = 'Vous ne pouvez pas vous ajouter en tant qu\'ami, c\'est trés illogique !';
			}
		} else {
			$err = 'Membre inexistant !';
		}	

		$this->listeAmi();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function ajoutAmi() {
		$ami=$_GET['ami'];
		$err = '';

		if($ami!=$_SESSION['pseudo']) {
			$liste = $this->utilisateurModel->getByPseudo(bdSql($ami));
			$id = $liste[0]['iduser'];

			$liste = $this->utilisateurModel->getAmi(bdSql($id), bdSql($_SESSION['id']));

			if(!empty($id)) {
				if(count($liste)>0) {
					$demande=$liste[0]['demande'];
					$iduser2=$liste[0]['iduser2'];
					if ($demande==0 AND $iduser2==$_SESSION['id']) {
						$this->utilisateurModel->acceptAmi(bdSql($id), bdSql($_SESSION['id']));
						$err = '<p>C\'est maintenant votre ami !</p>';
					} else {
						$err = '<p>Vous êtes deja ami ! ou demande déjà effectué !</p>';
					}
				} else {
					$err = '<p>Demande non faite, faites lui une demande d\'ami si vous voulez l\'ajouter !</p>';
				} 
			} else {
				$err = '<p>Membre inexistant !</p>';
			}	

    	} else {
			$err = '<p>Ca c\'est vous !</p>';
		}	

		$this->listeAmi();
        if (!empty($err)) {
            require 'View/err.php';
        }
	}

	public function suppAmi() {
		$ami=$_GET['ami'];
		$err = '';

		$liste = $this->utilisateurModel->getByPseudo(bdSql($ami));
		$id = $liste[0]['iduser'];

		$liste = $this->utilisateurModel->getAmi(bdSql($id), bdSql($_SESSION['id']));


		if($_SESSION['pseudo']!=$ami) {
			if(!empty($id)) {
				if(count($liste)!=0) {
					$this->utilisateurModel->supprAmi(bdSql($id), bdSql($_SESSION['id']));
					$err = '<p>Effectué !</p>';
				} else {
					$err = '<p>Ce n\'est pas votre ami !</p>';
				}				
			} else {
				$err = '<p>Membre inexistant !</p>';
			}	
		} else {
			$err = '<p>C\'est vous !</p>';
		}

		$this->listeAmi();
        if (!empty($err)) {
            require 'View/err.php';
        }	
	}

}
?>
