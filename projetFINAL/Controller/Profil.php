<?php

class Controller_Profil extends Controller_Template {

    private $profilModel;
    private $utilisateurModel;
    private $mangaModel;
    private $animeModel;
    private $genreModel;

    public function __construct() {
        parent::__construct();
        $this->profilModel = new Model_Profil();
        $this->utilisateurModel = new Model_Utilisateur();
        $this->mangaModel = new Model_Manga();
        $this->animeModel = new Model_Anime();
        $this->genreModel = new Model_Genre();
    }

    public function menuGauche() {
        if (!empty($_SESSION)) {
            $avatarStatut = $this->profilModel->getAvatarStatut($_SESSION['id']);
            $demandeAmi = $this->profilModel->getDemandeAmi($_SESSION['id']);
            $messNonLu = $this->profilModel->getMessNonLu($_SESSION['id']);
        }
        require 'View/menuGauche.php';
    }

    public function index() {
        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        $this->menuGauche();
        require 'View/Profil/index.php';
        require 'View/footer.php';
    }

    public function setAvatar() {
        $err = '';
        if ($_FILES['avatar']['error'] == 0) {
            if ($_FILES['avatar']['size'] <= 1048576) {
                $infosfichier = pathinfo($_FILES['avatar']['name']);
                $extension_upload = strtolower($infosfichier['extension']);
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) {
                    $nomRandom = md5(uniqid(rand(), true));
                    $nomRandom = $nomRandom . "." . $extension_upload;
                    $location = 'avatar/' . $nomRandom;
                    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $location);
                    if ($resultat) {
                        $avatar = $this->profilModel->getAvatarStatut($_SESSION['id']);
                        if ($avatar[0]['avatar'] != 'defaut.png') {
                            unlink('avatar/' . $avatar[0]['avatar']);
                        }
                        $setAvatar = $this->profilModel->setAvatar($nomRandom, $_SESSION['id']);
                    }
                } else {
                    $err = 'Extension incorrecte !';
                }
            } else {
                $err = 'Le fichier est trop gros !';
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        $this->menuGauche();
        if (!empty($err)) {
            require 'View/err.php';
        }
        require 'View/Profil/index.php';
        require 'View/footer.php';
    }

    public function setStatut() {
        $setStatut = $this->profilModel->setStatut(bdSql($_POST['statut']), $_SESSION['id']);
        $this->index();
    }

    public function displayProfil() {
        $utilisateur = $this->utilisateurModel->getById($_SESSION['id']);
        $profil = $this->profilModel->getById($_SESSION['id']);

        $type = $this->utilisateurModel->getTypeById($utilisateur[0]['idtype']);

        if ($profil[0]['civilite'] == 1) {
            $civilite = 'Mr';
        } else if ($profil[0]['civilite'] == 2) {
            $civilite = 'Mme';
        } else if ($profil[0]['civilite'] == 3) {
            $civilite = 'Mlle';
        } else {
            $civilite = '"Non renseigné"';
        }

        if (empty($profil[0]['description'])) {
            $profil[0]['description'] = bdSql('"Non renseigné"');
        }

        if ($profil[0]['animefav'] == 0) {
            $anime[0]['titre'] = bdSql('"Non renseigné"');
        } else {
            $anime = $this->animeModel->getById($profil[0]['animefav']);
        }
        if ($profil[0]['mangafav'] == 0) {
            $manga[0]['titre'] = bdSql('"Non renseigné"');
        } else {
            $manga = $this->mangaModel->getById($profil[0]['mangafav']);
        }
        if ($profil[0]['genrefav'] == 0) {
            $genre[0]['genre'] = bdSql('"Non renseigné"');
        } else {
            $genre = $this->genreModel->getById($profil[0]['genrefav']);
        }

        $explodeDate = explode('-', $utilisateur[0]['datenaiss']);
        $allGenre = $this->genreModel->getAll();
        $allManga = $this->mangaModel->getAllTitre();
        $allAnime = $this->animeModel->getAllTitre();

        require 'View/header.php';
        $this->menuGauche();
        require 'View/Profil/profil.php';
        require 'View/footer.php';
    }

    public function editerProfil() {
        $err = '';
        if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['mail']) and !empty($_POST['jour']) and !empty($_POST['mois']) and !empty($_POST['annee'])) {

            $civilite = $_POST['civilite'];
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $mail = trim($_POST['mail']);
            $date = $_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour'];
            $description = trim($_POST['description']);

            $animeFav = $_POST['animeFav'];

            $mangaFav = $_POST['manga'];

            $genreFav = $_POST['genre'];

            $anime = $this->animeModel->getIdByTitre(bdSql($animeFav));
            $manga = $this->mangaModel->getIdByTitre(bdSql($mangaFav));
            $genre = $this->genreModel->getByGenre(bdSql($genreFav));

            $this->utilisateurModel->setUtilisateur(bdSql($nom), bdSql($prenom), bdSql($mail), $date, $_SESSION['id']);

            $this->profilModel->setProfil(bdSql($description), $civilite, $anime[0]['idanime'], $manga[0]['idmanga'], $genre[0]['idgenre'], $_SESSION['id']);

            $err = 'Profil mis à jour !<br/>';
        } else {
            $err = '<p>* Veuillez remplir correctement le formulaire !</p>';
        }

        if (!empty($_POST['mdpActuel']) AND !empty($_POST['mdp1']) AND !empty($_POST['mdp2'])) {
            $mdpActuel = sha1($_POST['mdpActuel']);
            $mdp1 = trim($_POST['mdp1']);
            $mdp2 = trim($_POST['mdp2']);

            $pass = $this->utilisateurModel->getById($_SESSION['id']);
            if ($mdpActuel == $pass[0]['pass']) {
                if ($mdp1 == $mdp2) {
                    $this->utilisateurModel->setPw(sha1($mdp1), $_SESSION['id']);
                    $err = $err . '<p>Mot de passe mis à jour !</p>';
                } else {
                    $err = $err . '<p>Vos deux mots de passe ne sont pas identiques, il ne sera pas modifié, veuillez reessayer !</p>';
                }
            } else {
                $err = $err . '<p>Votre mot de passe actuel ne concorde pas, il ne sera pas modifié, veuillez reessayer !</p>';
            }
        }

        // $err = $anime.$manga.$genre;

        $this->displayProfil();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

}

