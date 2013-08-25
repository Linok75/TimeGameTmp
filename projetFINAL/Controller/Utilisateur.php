<?php

class Controller_Utilisateur extends Controller_Template {

    public function __construct() {
        parent::__construct();
        $this->utilisateurModel = new Model_Utilisateur();
        $this->profilModel = new Model_Profil();
    }

    public function connexion() {
        $require = '';
        $id = $this->utilisateurModel->getByPseudoPass($_POST['pseudo'], sha1($_POST['mdp']));

        if (!empty($id)) {
            $_SESSION['id'] = $id[0]['iduser'];
            $_SESSION['pseudo'] = $id[0]['pseudo'];
            $_SESSION['type'] = $id[0]['idtype'];
            $this->profilModel->setLastCo($_SESSION['id']);
            $require = 'index.php';
        }

        if ($require == 'index.php') {

            Controller_Template::$profil->index();
        } else {
            header('Content-Type: text/html; charset=utf-8');
            require 'View/header.php';
            Controller_Template::$profil->menuGauche();
            require 'View/Utilisateur/connexion.php';
            require 'View/footer.php';
        }
    }

    public function inscription() {
        $pseudo = trim($_POST['pseudo']);
        $mdp = sha1(trim($_POST['mdp']));
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $mail = trim($_POST['mail']);
        $date = trim($_POST['annee']) . '-' . trim($_POST['mois']) . '-' . trim($_POST['jour']);
        $err = '';

        if (!empty($pseudo) && !empty($mdp) && !empty($nom) && !empty($prenom) &&
                !empty($mail)) {

            $idByPseudo = $this->utilisateurModel->getByPseudo(html($pseudo));

            if (!empty($idByPseudo)) {
                $require = 'View/Utilisateur/inscription.php';
                $err = '<p>* Le login existe deja !</p>';
            } else {
                $addUtilisateur = $this->utilisateurModel->addUtilisateur(bdSql($pseudo), bdSql($mdp), bdSql($nom), bdSql($prenom), bdSql($mail), bdSql($date));
                $idByPseudo = $this->utilisateurModel->getByPseudo(bdSql($pseudo));
                $addProfil = $this->profilModel->addProfil($idByPseudo[0]['iduser']);
            }
        } else {
            $require = 'View/Utilisateur/inscription.php';
            $err = '<p>* Tous les champs sont obligatoires</p>';
        }


        if (empty($err)) {
            $_SESSION['id'] = $idByPseudo[0]['iduser'];
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['type'] = 4;
            $this->profilModel->setLastCo($_SESSION['id']);
            header('Content-Type: text/html; charset=utf-8');
            require 'View/header.php';
            Controller_Template::$profil->menuGauche();
            require 'View/Profil/index.php';
        } else {
            header('Content-Type: text/html; charset=utf-8');
            require 'View/header.php';
            Controller_Template::$profil->menuGauche();
            echo $err;
            require 'View/Utilisateur/inscription.php';
        }
        require 'View/footer.php';
    }

    public function deconnexion(){
        session_start();
	session_unset();
	session_destroy();

	header('Location: index.php');
    }
    
}

