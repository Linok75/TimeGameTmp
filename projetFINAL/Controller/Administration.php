<?php

class Controller_Administration extends Controller_Template {

    private $ficheModel;
    private $mangaModel;
    private $animeModel;
    private $genreModel;
    private $statutModel;
    private $utilisateurModel;
    private $profilModel;

    public function __construct() {
        parent::__construct();
        $this->ficheModel = new Model_Fiche();
        $this->mangaModel = new Model_Manga();
        $this->animeModel = new Model_Anime();
        $this->genreModel = new Model_Genre();
        $this->statutModel = new Model_Statut();
        $this->utilisateurModel = new Model_Utilisateur();
        $this->profilModel = new Model_Profil();
    }

    public function displayAdmin() {
        $utilisateurs = $this->utilisateurModel->getAll();

        for ($i = 0, $size = count($utilisateurs); $i < $size; $i++) {
            $utilisateurs[$i]['profil'] = $this->profilModel->getAvatarStatut($utilisateurs[$i]['iduser']);
        }

        $fiches = $this->ficheModel->getALl();

        for ($i = 0, $size = count($fiches); $i < $size; $i++) {
            $fiches[$i]['manga'] = $this->mangaModel->getById($fiches[$i]['idmanga']);
            if (!empty($fiches[$i]['manga'])) {
                $fiches[$i]['manga'][0]['statut'] = $this->statutModel->getById($fiches[$i]['manga'][0]['statut']);
            }
            $fiches[$i]['anime'] = $this->animeModel->getById($fiches[$i]['idanime']);
            if (!empty($fiches[$i]['anime'])) {
                $fiches[$i]['anime'][0]['statut'] = $this->statutModel->getById($fiches[$i]['anime'][0]['statut']);
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Administration/administration.php';
        require 'View/footer.php';
    }

    public function gestionProfil() {
        $utilisateur = $this->utilisateurModel->getById($_GET['iduser']);
        $profil = $this->profilModel->getById($_GET['iduser']);

        if ($profil[0]['civilite'] == 1) {
            $civilite = 'Mr';
        } else if ($profil[0]['civilite'] == 2) {
            $civilite = 'Mme';
        } else if ($profil[0]['civilite'] == 3) {
            $civilite = 'Mlle';
        } else {
            $civilite = '"Non renseigné"';
        }

        if (empty($description)) {
            $description = '"Non renseigné"';
        }

        if ($profil[0]['animefav'] == 0) {
            $anime[0]['titre'] = '"Non renseigné"';
        } else {
            $anime = $this->animeModel->getById($profil[0]['animefav']);
        }
        if ($profil[0]['mangafav'] == 0) {
            $manga[0]['titre'] = '"Non renseigné"';
        } else {
            $manga = $this->mangaModel->getById($profil[0]['mangafav']);
        }
        if ($profil[0]['genrefav'] == 0) {
            $genre[0]['genre'] = '"Non renseigné"';
        } else {
            $genre = $this->genreModel->getById($profil[0]['genrefav']);
        }

        $explodeDate = explode('-', $utilisateur[0]['datenaiss']);
        $allGenre = $this->genreModel->getAll();
        $allManga = $this->mangaModel->getAllTitre();
        $allAnime = $this->animeModel->getAllTitre();
        $allType = $this->utilisateurModel->getAllTypeUser();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Administration/gestionProfil.php';
        require 'View/footer.php';
    }

    public function editerProfil() {
        $err = '';
        if (isset($_POST['civilite'])) {
            $civilite = $_POST['civilite'];
        } else {
            $civilite = 0;
        }
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $mail = trim($_POST['mail']);
        $date = $_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour'];
        $description = trim($_POST['description']);
        $statut = trim($_POST['statut']);

        $animeFav = $_POST['animeFav'];

        $mangaFav = $_POST['manga'];

        $genreFav = $_POST['genre'];

        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['iduser'])) {
			if($_POST['idtype']==3){
				$setAime = $this->utilisateurModel->setAimeByUser(2, $_POST['iduser']);
				$setType = $this->utilisateurModel->setTypeUser($_POST['idtype'], $_POST['iduser']);
            }else{
				$setAime = $this->utilisateurModel->setAimeByUser(1, $_POST['iduser']);
				$setType = $this->utilisateurModel->setTypeUser($_POST['idtype'], $_POST['iduser']);
			}
				
			$setStatut = $this->profilModel->setStatut(bdSql($statut), $_POST['iduser']);
			
            $anime = $this->animeModel->getIdByTitre(bdSql($animeFav));
            $manga = $this->mangaModel->getIdByTitre(bdSql($mangaFav));
            $genre = $this->genreModel->getByGenre(bdSql($genreFav));

            $this->utilisateurModel->setUtilisateur(bdSql($nom), bdSql($prenom), bdSql($mail), $date, $_POST['iduser']);

            $this->profilModel->setProfil(bdSql($description), $civilite, $anime[0]['idanime'], $manga[0]['idmanga'], $genre[0]['idgenre'], $_POST['iduser']);

            if (isset($_POST['noAvat'])) {
                $avatar = $this->profilModel->getAvatarStatut($_POST['iduser']);
                if ($avatar[0]['avatar'] != 'defaut.png') {
                    unlink('avatar/' . $avatar[0]['avatar']);
                }
                $setAvatar = $this->profilModel->setAvatar('defaut.png', $_POST['iduser']);
            }

            $err = 'Profil mis à jour !<br/>';
        } else {
            $err = '<p>* Veuillez remplir correctement le formulaire !</p>';
        }

        // $err = $anime.$manga.$genre;

        $this->displayAdmin();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function gestionFiche() {
        if (isset($_GET['idmanga'])) {
            if (!empty($_GET['idmanga'])) {
                $idmanga = $_GET['idmanga'];
            } else {
                $idmanga = 0;
            }
        } else {
            $idmanga = 0;
        }
        if (isset($_GET['idanime'])) {
            if (!empty($_GET['idanime'])) {
                $idanime = $_GET['idanime'];
            } else {
                $idanime = 0;
            }
        } else {
            $idanime = 0;
        }

        if ($idanime != 0) {
            $fiche = $this->ficheModel->getById(-1, bdSql($idanime));
        } else if ($idmanga != 0) {
            $fiche = $this->ficheModel->getById(bdSql($idmanga), -1);
        } else {
            $fiche = '';
        }

        if (empty($fiche)) {
            $require = 'View/Administration/administration.php';
        } else {
            $idmanga = $fiche[0]['idmanga'];
            $idanime = $fiche[0]['idanime'];

            if ($idmanga != 0) {
                $mangaGenre = $this->mangaModel->getMangaGenre(bdSql($idmanga));
                $manga = $this->mangaModel->getById(bdSql($idmanga));
                $mangaStatut = $this->statutModel->getById(bdSql($manga[0]['statut']));
            } else {
                $require = 'View/Administration/addManga.php';
            }
            if ($idanime != 0) {
                $animeGenre = $this->animeModel->getAnimeGenre(bdSql($idanime));
                $anime = $this->animeModel->getById(bdSql($idanime));
                $animeStatut = $this->statutModel->getById(bdSql($anime[0]['statut']));
            } else {
                $require = 'View/Administration/addAnime.php';
            }

            if ($idmanga != 0 && $idanime != 0) {
                $require = 'View/Administration/editerFiche.php';
            }

            $allStatut = $this->statutModel->getAll();
            $allGenre = $this->genreModel->getAll();
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function addManga() {
        $titre = trim($_POST['titre']);
        $alt = trim($_POST['titreAlt']);
        $auteur = trim($_POST['auteur']);
        $parution = trim($_POST['parution']);
        $editeur = trim($_POST['editeur']);
        $lastchap = trim($_POST['lastChap']);
        $statut = trim($_POST['statut']);
        $resume = trim($_POST['resume']);
        $couverture = $_FILES['couverture'];
        $idanime = $_POST['idanime'];

        if (!isset($_POST['genre']) || empty($_POST['genre'])) {
            $erreur['genre'] = '<span class="erreur">(*) champ obligatoire</span>';
        } else {
            $genre = $_POST['genre'];
            $valide['genre'] = $genre;
        }

        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        if (!empty($titre)) {
            $idbytitre = $this->mangaModel->getidbytitre(bdsql($titre));
            if (count($idbytitre) > 0) {
                $erreur['titre'] = '<span class="erreur">une fiche sur ce manga existe déjà ici : <a href="./ficheviewer.php?idmanga=' . html($idbytitre[0]['idmanga']) . '">' . $titre . '</a></span>';
            } else {
                $valide['titre'] = $titre;
            }
        } else {
            $erreur['titre'] = '<span class="erreur">(*) champ obligatoire</span>';
        }

        $valide['alt'] = $alt;

        if (!empty($auteur)) {
            $valide['auteur'] = $auteur;
        } else {
            $erreur['auteur'] = '<span class="erreur">(*) champ obligatoire</span>';
        }

        if (!empty($parution)) {
            if (!preg_match("#^[0-9]+$#", $parution) || strlen($parution) != 4) {
                $erreur['parution'] = '<span class="erreur">l\' année de parution est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else {
                $valide['parution'] = $parution;
            }
        } else {
            $erreur['parution'] = '<span class="erreur">(*) champs obligatoire</span>';
        }

        if (!empty($editeur)) {
            $valide['editeur'] = $editeur;
        } else {
            $erreur['editeur'] = '<span class="erreur">(*) champ obligatoire</span>';
        }

        if (!empty($lastchap)) {
            if (!preg_match("#^[0-9]+$#", $lastchap)) {
                $erreur['lastchap'] = '<span class="erreur">le numéro du dernier chapitre est obligatoirement un nombre ! (exemple : 25)</span>';
            } else {
                $valide['lastchap'] = $lastchap;
            }
        } else {
            $erreur['lastchap'] = '<span class="erreur">(*) champs obligatoire</span>';
        }

        $valide['statut'] = $statut;

        if (!empty($resume)) {
            $valide['resume'] = $resume;
        } else {
            $erreur['resume'] = '<span class="erreur">(*) champ obligatoire</span>';
        }


        $maxsize = 1048576;
        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
        $nomrandom = "";
        $chemin = "";

        if ($couverture['error'] > 0)
            $erreur['couverture'] = '<span class="erreur">(*) champ obligatoire</span>';
        if (!isset($erreur['couverture'])) {
            $extension_upload = strtolower(substr(strrchr($couverture['name'], '.'), 1));
            $nomrandom = md5(uniqid(rand(), true));
            $nomrandom = $nomrandom . "." . $extension_upload;
            if ($couverture['size'] > $maxsize) {
                if (!isset($erreur['couverture'])) {
                    $erreur['couverture'] = '<span class="erreur">';
                }
                $erreur['couverture'] = $erreur['couverture'] . ' le fichier est trop gros ! ';
            }
            if (!in_array($extension_upload, $extensions_valides)) {
                if (!isset($erreur['couverture'])) {
                    $erreur['couverture'] = '<span class="erreur">';
                }
                $erreur['couverture'] = $erreur['couverture'] . ' extension non valide ! ';
            }
        }
        if (!isset($erreur['couverture'])) {
            $valide['couverture'] = $couverture['tmp_name'];
        } else {
            $erreur['couverture'] = $erreur['couverture'] . '</span>';
        }


        if (isset($erreur)) {
            $require = 'View/Administration/addManga.php';
        } else {
            $couverurebycouverture = $this->mangaModel->getcouverturebycouverture(bdsql($nomrandom));
            if (count($couverurebycouverture) > 0) {
                $verifimg = false;
                while (!$verif) {
                    $nomrandom = md5(uniqid(rand(), true));
                    $nomrandom = $nomrandom . "." . $extension_upload;
                    $couverurebycouverture = $this->mangaModel->getcouverturebycouverture(bdsql($nomrandom));
                    if (count($couverurebycouverture) <= 0) {
                        $verifimg = true;
                    }
                }
            }

            $chemin = "./couvertures/" . $nomrandom;
            $transfert = move_uploaded_file($couverture['tmp_name'], $chemin);

            if ($transfert) {
                $insertion = $this->mangaModel->addmanga(bdsql($titre), bdsql($alt), bdsql($auteur), bdsql($parution), bdsql($editeur), bdsql($lastchap), bdsql($statut), bdsql($nomrandom), bdsql($resume));
                $idbytitre = $this->mangaModel->getidbytitre(bdsql($titre));

                for ($i = 0, $size = count($genre); $i < $size; ++$i) {
                    $insertiongenre = $this->mangaModel->addgenre(bdsql($idbytitre[0]['idmanga']), bdsql($genre[$i]));
                }

                $upFiche = $this->ficheModel->setFiche(bdSql($idbytitre[0]['idmanga']), bdSql($idanime), '', '', 0, bdSql($idanime));
                $upNote = $this->ficheModel->setIdNote(bdSql($idbytitre[0]['idmanga']), $idanime, 0, $idanime);
                $upAime = $this->ficheModel->setIdAime(bdSql($idbytitre[0]['idmanga']), $idanime, 0, $idanime);
                $upCom = $this->ficheModel->setIdCom(bdSql($idbytitre[0]['idmanga']), $idanime, 0, $idanime);

                $idmanga = $idbytitre[0]['idmanga'];
                $fiche = $this->ficheModel->getById(bdSql($idmanga), bdSql($idanime));
                $require = 'View/Administration/editerFiche.php';
            } else {
                $erreur['couverture'] = '<span class="erreur">upload de la couverture échoué pour une raison inconnu !</span>';
                $valide['couverture'] = '';
                $require = 'View/Administration/addManga.php';
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function addAnime() {
        $titre = trim($_POST['titre']);
        $alt = trim($_POST['titreAlt']);
        $auteur = trim($_POST['auteur']);
        $dessinateur = trim($_POST['dessinateur']);
        $diffusion = trim($_POST['diffusion']);
        $lastEp = trim($_POST['lastEp']);
        $studio = trim($_POST['studio']);
        $statut = trim($_POST['statut']);
        $illustration = $_FILES['illustration'];
        $synopsis = trim($_POST['synopsis']);
        $idmanga = $_POST['idmanga'];


        if (!isset($_POST['genre']) || empty($_POST['genre'])) {
            $erreur['genre'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        } else {
            $genre = $_POST['genre'];
            $valide['genre'] = $genre;
        }


        if ($titre != "") {
            $idByTitre = $this->animeModel->getIdByTitre(bdSql($titre));
            if (count($idByTitre)) {
                $erreur['titre'] = '<span class="erreur">Une fiche sur cet anime existe déjà ici : <a href="./ficheViewer.php?idanime=' . html($idByTitre[0]['idanime']) . '">' . $titre . '</a></span>';
            } else {
                $valide['titre'] = $titre;
            }
        } else {
            $erreur['titre'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        }

        $valide['alt'] = $alt;

        if ($auteur != "") {
            $valide['auteur'] = $auteur;
        } else {
            $erreur['auteur'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        }

        if ($dessinateur != "") {
            $valide['dessinateur'] = $dessinateur;
        } else {
            $erreur['dessinateur'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        }

        if ($diffusion != "") {
            if (!preg_match("#^[0-9]+$#", $diffusion)) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else if (strlen($diffusion) != 4) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else {
                $valide['diffusion'] = $diffusion;
            }
        } else {
            $erreur['diffusion'] = '<span class="erreur">(*) Champs Obligatoire</span>';
        }

        if ($lastEp != "") {
            if (!preg_match("#^[0-9]+$#", $lastEp)) {
                $erreur['lastEp'] = '<span class="erreur">Le numéro du dernier épisode est obligatoirement un nombre ! (exemple : 25)</span>';
            } else {
                $valide['lastEp'] = $lastEp;
            }
        } else {
            $erreur['lastEp'] = '<span class="erreur">(*) Champs Obligatoire</span>';
        }

        if ($studio != "") {
            $valide['studio'] = $studio;
        } else {
            $erreur['studio'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        }

        $valide['statut'] = $statut;

        if ($synopsis != "") {
            $valide['synopsis'] = $synopsis;
        } else {
            $erreur['synopsis'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        }


        $maxSize = 1048576;
        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
        $nomRandom = "";
        $chemin = "";

        if ($illustration['error'] > 0)
            $erreur['illustration'] = '<span class="erreur">(*) Champ Obligatoire</span>';
        if (!isset($erreur['illustration'])) {
            $extension_upload = strtolower(substr(strrchr($illustration['name'], '.'), 1));
            $nomRandom = md5(uniqid(rand(), true));
            $nomRandom = $nomRandom . "." . $extension_upload;
            if ($illustration['size'] > $maxSize) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Le fichier est trop gros ! ';
            }
            if (!in_array($extension_upload, $extensions_valides)) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Extension non valide ! ';
            }
        }
        if (!isset($erreur['illustration'])) {
            $valide['illustration'] = $illustration['tmp_name'];
        } else {
            $erreur['illustration'] = $erreur['illustration'] . '</span>';
        }


        if (isset($erreur)) {
            $require = 'View/Administration/addAnime.php';
        } else {
            $illustrationByIllustration = $this->animeModel->getIllustrationByIllustration(bdSql($nomRandom));

            if (count($illustrationByIllustration) > 0) {
                $verif = false;
                while (!$verif) {
                    $nomRandom = md5(uniqid(rand(), true));
                    $nomRandom = $nomRandom . "." . $extension_upload;
                    $illustrationByIllustration = $this->animeModel->getIllustrationByIllustration(bdSql($nomRandom));
                    if (count($illustrationByIllustration) > 0) {
                        $verif = true;
                    }
                }
            }

            $chemin = "./illustrations/" . $nomRandom;
            $transfert = move_uploaded_file($illustration['tmp_name'], $chemin);

            if ($transfert) {
                $addAnime = $this->animeModel->addAnime(bdSql($titre), bdSql($alt), bdSql($auteur), bdSql($dessinateur), bdSql($diffusion), bdSql($studio), bdSql($lastEp), bdSql($statut), bdSql($nomRandom), bdSql($synopsis));
                $idByTitre = $this->animeModel->getIdByTitre(bdSql($titre));

                $idanime = $idByTitre[0]['idanime'];

                for ($i = 0, $size = count($genre); $i < $size; ++$i) {
                    $inserGenre = $this->animeModel->addGenre(bdSql($idanime), bdSql($genre[$i]));
                }


                $upFiche = $this->ficheModel->setFiche(bdSql($idmanga), bdSql($idanime), '', '', bdSql($idmanga), 0);
                $upNote = $this->ficheModel->setIdNote(bdSql($idmanga), $idanime, $idmanga, 0);
                $upAime = $this->ficheModel->setIdAime(bdSql($idmanga), $idanime, $idmanga, 0);
                $upCom = $this->ficheModel->setIdCom(bdSql($idmanga), $idanime, $idmanga, 0);

                $fiche = $this->ficheModel->getById(bdSql($idmanga), bdSql($idanime));

                $require = 'View/Administration/editerFiche.php';
            } else {
                $erreur['illustration'] = '<span class="erreur">Upload de l\'illustration échoué pour une raison inconnu !</span>';
                $valide['illustration'] = '';
                $require = 'View/Administration/addAnime.php';
            }
        }

        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();


        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function gestionAnime() {
        $anime = $this->animeModel->getById(bdSql($_GET['idanime']));
        $idanime = $anime[0]['idanime'];
        if ($idanime != 0) {
            $animeGenre = $this->animeModel->getAnimeGenre(bdSql($idanime));
            $animeStatut = $this->statutModel->getById(bdSql($anime[0]['statut']));

            $allStatut = $this->statutModel->getAll();
            $allGenre = $this->genreModel->getAll();

            $require = 'View/Administration/setAnime.php';
        } else {
            $require = 'View/Administration/administration.php';
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function setAnime() {
        $titre = trim($_POST['titre']);
        $alt = trim($_POST['titreAlt']);
        $auteur = trim($_POST['auteur']);
        $dessinateur = trim($_POST['dessinateur']);
        $diffusion = trim($_POST['diffusion']);
        $lastEp = trim($_POST['lastEp']);
        $studio = trim($_POST['studio']);
        $statut = trim($_POST['statut']);
        $illustration = $_FILES['illustration'];
        $synopsis = trim($_POST['synopsis']);
        $idanime = $_POST['idanime'];


        $anime = $this->animeModel->getById(bdSql($idanime));
        $animeGenre = $this->animeModel->getAnimeGenre(bdSql($idanime));
        $animeStatut = $this->statutModel->getById(bdSql($anime[0]['statut']));

        if (!isset($_POST['genre']) || empty($_POST['genre'])) {
            for ($i = 0, $size = count($animeGenre); $i < $size; $i++) {
                $genre[$i] = $animeGenre[$i]['idgenre'];
            }
            $valide['genre'] = $genre;
        } else {
            $genre = $_POST['genre'];
            $valide['genre'] = $genre;
        }


        if ($titre != "") {
            if ($titre != $anime[0]['titre']) {
                $idByTitre = $this->animeModel->getIdByTitre(bdSql($titre));
                if (count($idByTitre)) {
                    $erreur['titre'] = '<span class="erreur">Une fiche sur cet anime existe déjà ici : <a href="./ficheViewer.php?idanime=' . html($idByTitre[0]['idanime']) . '">' . $titre . '</a></span>';
                } else {
                    $valide['titre'] = $titre;
                }
            } else {
                $valide['titre'] = $titre;
            }
        } else {
            $titre = $anime[0]['titre'];
            $valide['titre'] = $titre;
        }

        if ($alt != "") {
            $valide['alt'] = $alt;
        } else {
            $alt = $anime[0]['titreAlt'];
            $valide['alt'] = $alt;
        }

        if ($auteur != "") {
            $valide['auteur'] = $auteur;
        } else {
            $auteur = $anime[0]['auteur'];
            $valide['auteur'] = $auteur;
        }

        if ($dessinateur != "") {
            $valide['dessinateur'] = $dessinateur;
        } else {
            $dessinateur = $anime[0]['dessinateur'];
            $valide['dessinateur'] = $dessinateur;
        }

        if ($diffusion != "") {
            if (!preg_match("#^[0-9]+$#", $diffusion)) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else if (strlen($diffusion) != 4) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else {
                $valide['diffusion'] = $diffusion;
            }
        } else {
            $diffusion = $anime[0]['anneedediff'];
            $valide['diffusion'] = $diffusion;
        }

        if ($lastEp != "") {
            if (!preg_match("#^[0-9]+$#", $lastEp)) {
                $erreur['lastEp'] = '<span class="erreur">Le numéro du dernier épisode est obligatoirement un nombre ! (exemple : 25)</span>';
            } else {
                $valide['lastEp'] = $lastEp;
            }
        } else {
            $lastEp = $anime[0]['lastEp'];
            $valide['lastEp'] = $lastEp;
        }

        if ($studio != "") {
            $valide['studio'] = $studio;
        } else {
            $studio = $anime[0]['studio'];
            $valide['studio'] = $studio;
        }

        $valide['statut'] = $statut;

        if ($synopsis != "") {
            $valide['synopsis'] = $synopsis;
        } else {
            $synopsis = $anime[0]['synopsis'];
            $valide['synopsis'] = $synopsis;
        }


        if ($illustration['error'] > 0) {
            $nomRandom = $anime[0]['image'];
        }
        if (!isset($nomRandom)) {
            $maxSize = 1048576;
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $nomRandom = "";
            $chemin = "";

            $extension_upload = strtolower(substr(strrchr($illustration['name'], '.'), 1));
            $nomRandom = md5(uniqid(rand(), true));
            $nomRandom = $nomRandom . "." . $extension_upload;
            if ($illustration['size'] > $maxSize) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Le fichier est trop gros ! ';
            }
            if (!in_array($extension_upload, $extensions_valides)) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Extension non valide ! ';
            }
        }
        if (!isset($erreur['illustration'])) {
            $valide['illustration'] = $illustration['tmp_name'];
        } else {
            $erreur['illustration'] = $erreur['illustration'] . '</span>';
        }


        if (isset($erreur)) {
            $require = 'View/Administration/setAnime.php';
        } else {
            if ($nomRandom != $anime[0]['image']) {
                $illustrationByIllustration = $this->animeModel->getIllustrationByIllustration(bdSql($nomRandom));

                if (count($illustrationByIllustration) > 0) {
                    $verif = false;
                    while (!$verif) {
                        $nomRandom = md5(uniqid(rand(), true));
                        $nomRandom = $nomRandom . "." . $extension_upload;
                        $illustrationByIllustration = $this->animeModel->getIllustrationByIllustration(bdSql($nomRandom));
                        if (count($illustrationByIllustration) > 0) {
                            $verif = true;
                        }
                    }
                }

                unlink('illustrations/' . $anime[0]['image']);


                $chemin = "./illustrations/" . $nomRandom;
                $transfert = move_uploaded_file($illustration['tmp_name'], $chemin);
            } else {
                $transfert = true;
            }
            if ($transfert) {
                $addAnime = $this->animeModel->setAnime(bdSql($titre), bdSql($alt), bdSql($auteur), bdSql($dessinateur), bdSql($diffusion), bdSql($studio), bdSql($lastEp), bdSql($statut), bdSql($nomRandom), bdSql($synopsis), $idanime);

                $delGenre = $this->animeModel->delGenreByAnime($idanime);
                for ($i = 0, $size = count($genre); $i < $size; ++$i) {
                    $inserGenre = $this->animeModel->addGenre(bdSql($idanime), bdSql($genre[$i]));
                }

                $fiche = $this->ficheModel->getById(bdSql($idmanga), bdSql($idanime));

                header('Location: ./index.php?module=Fiche&action=displayFiche&idanime=' . $idanime);
            } else {
                $erreur['illustration'] = '<span class="erreur">Upload de l\'illustration échoué pour une raison inconnu !</span>';
                $valide['illustration'] = '';
                $require = 'View/Administration/setAnime.php';
            }
        }

        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function gestionManga() {
        $manga = $this->mangaModel->getById(bdSql($_GET['idmanga']));
        $idmanga = $manga[0]['idmanga'];
        if ($idmanga != 0) {
            $mangaGenre = $this->mangaModel->getMangaGenre(bdSql($idmanga));
            $mangaStatut = $this->statutModel->getById(bdSql($manga[0]['statut']));

            $allStatut = $this->statutModel->getAll();
            $allGenre = $this->genreModel->getAll();

            $require = 'View/Administration/setManga.php';
        } else {
            $require = 'View/Administration/administration.php';
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function setManga() {
        $titre = trim($_POST['titre']);
        $alt = trim($_POST['titreAlt']);
        $auteur = trim($_POST['auteur']);
        $diffusion = trim($_POST['diffusion']);
        $lastEp = trim($_POST['lastEp']);
        $studio = trim($_POST['studio']);
        $statut = trim($_POST['statut']);
        $illustration = $_FILES['illustration'];
        $synopsis = trim($_POST['synopsis']);
        $idmanga = $_POST['idmanga'];


        $manga = $this->mangaModel->getById(bdSql($idmanga));
        $mangaGenre = $this->mangaModel->getMangaGenre(bdSql($idmanga));
        $mangaStatut = $this->statutModel->getById(bdSql($manga[0]['statut']));

        if (!isset($_POST['genre']) || empty($_POST['genre'])) {
            for ($i = 0, $size = count($mangaGenre); $i < $size; $i++) {
                $genre[$i] = $mangaGenre[$i]['idgenre'];
            }
            $valide['genre'] = $genre;
        } else {
            $genre = $_POST['genre'];
            $valide['genre'] = $genre;
        }


        if ($titre != "") {
            if ($titre != $manga[0]['titre']) {
                $idByTitre = $this->mangaModel->getIdByTitre(bdSql($titre));
                if (count($idByTitre)) {
                    $erreur['titre'] = '<span class="erreur">Une fiche sur cet anime existe déjà ici : <a href="./ficheViewer.php?idanime=' . html($idByTitre[0]['idanime']) . '">' . $titre . '</a></span>';
                } else {
                    $valide['titre'] = $titre;
                }
            } else {
                $valide['titre'] = $titre;
            }
        } else {
            $titre = $manga[0]['titre'];
            $valide['titre'] = $titre;
        }

        if ($alt != "") {
            $valide['alt'] = $alt;
        } else {
            $alt = $manga[0]['titreAlt'];
            $valide['alt'] = $alt;
        }

        if ($auteur != "") {
            $valide['auteur'] = $auteur;
        } else {
            $auteur = $manga[0]['auteur'];
            $valide['auteur'] = $auteur;
        }

        if ($diffusion != "") {
            if (!preg_match("#^[0-9]+$#", $diffusion)) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else if (strlen($diffusion) != 4) {
                $erreur['diffusion'] = '<span class="erreur">L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)</span>';
            } else {
                $valide['diffusion'] = $diffusion;
            }
        } else {
            $diffusion = $manga[0]['anneeparution'];
            $valide['diffusion'] = $diffusion;
        }

        if ($lastEp != "") {
            if (!preg_match("#^[0-9]+$#", $lastEp)) {
                $erreur['lastEp'] = '<span class="erreur">Le numéro du dernier épisode est obligatoirement un nombre ! (exemple : 25)</span>';
            } else {
                $valide['lastEp'] = $lastEp;
            }
        } else {
            $lastEp = $manga[0]['dernierchap'];
            $valide['lastEp'] = $lastEp;
        }

        if ($studio != "") {
            $valide['studio'] = $studio;
        } else {
            $studio = $manga[0]['editeurori'];
            $valide['studio'] = $studio;
        }

        $valide['statut'] = $statut;

        if ($synopsis != "") {
            $valide['synopsis'] = $synopsis;
        } else {
            $synopsis = $manga[0]['synopsis'];
            $valide['synopsis'] = $synopsis;
        }


        if ($illustration['error'] > 0) {
            $nomRandom = $manga[0]['couverture'];
        }
        if (!isset($nomRandom)) {
            $maxSize = 1048576;
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $nomRandom = "";
            $chemin = "";

            $extension_upload = strtolower(substr(strrchr($illustration['name'], '.'), 1));
            $nomRandom = md5(uniqid(rand(), true));
            $nomRandom = $nomRandom . "." . $extension_upload;
            if ($illustration['size'] > $maxSize) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Le fichier est trop gros ! ';
            }
            if (!in_array($extension_upload, $extensions_valides)) {
                if (!isset($erreur['illustration'])) {
                    $erreur['illustration'] = '<span class="erreur">';
                }
                $erreur['illustration'] = $erreur['illustration'] . ' Extension non valide ! ';
            }
        }
        if (!isset($erreur['illustration'])) {
            $valide['illustration'] = $illustration['tmp_name'];
        } else {
            $erreur['illustration'] = $erreur['illustration'] . '</span>';
        }


        if (isset($erreur)) {
            $require = 'View/Administration/setManga.php';
        } else {
            if ($nomRandom != $manga[0]['couverture']) {
                $illustrationByIllustration = $this->mangaModel->getCouvertureByCouverture(bdSql($nomRandom));

                if (count($illustrationByIllustration) > 0) {
                    $verif = false;
                    while (!$verif) {
                        $nomRandom = md5(uniqid(rand(), true));
                        $nomRandom = $nomRandom . "." . $extension_upload;
                        $illustrationByIllustration = $this->mangaModel->getCouvertureByCouverture(bdSql($nomRandom));
                        if (count($illustrationByIllustration) > 0) {
                            $verif = true;
                        }
                    }
                }


                unlink('couvertures/' . $manga[0]['couverture']);

                $chemin = "./couvertures/" . $nomRandom;
                $transfert = move_uploaded_file($illustration['tmp_name'], $chemin);
            } else {
                $transfert = true;
            }
            if ($transfert) {
                $addManga = $this->mangaModel->setManga(bdSql($titre), bdSql($alt), bdSql($auteur), bdSql($diffusion), bdSql($studio), bdSql($lastEp), bdSql($statut), bdSql($nomRandom), bdSql($synopsis), $idmanga);

                $delGenre = $this->mangaModel->delGenreByManga($idmanga);
                for ($i = 0, $size = count($genre); $i < $size; ++$i) {
                    $inserGenre = $this->mangaModel->addGenre(bdSql($idmanga), bdSql($genre[$i]));
                }

                $fiche = $this->ficheModel->getById(bdSql($idmanga), bdSql($idanime));

                header('Location: ./index.php?module=Fiche&action=displayFiche&idmanga=' . $idmanga);
            } else {
                $erreur['illustration'] = '<span class="erreur">Upload de l\'illustration échoué pour une raison inconnu !</span>';
                $valide['illustration'] = '';
                $require = 'View/Administration/setManga.php';
            }
        }

        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function suppFiche() {
        if (isset($_GET['idmanga'])) {
            if (!empty($_GET['idmanga'])) {
                $idmanga = $_GET['idmanga'];
            } else {
                $idmanga = 0;
            }
        } else {
            $idmanga = 0;
        }
        if (isset($_GET['idanime'])) {
            if (!empty($_GET['idanime'])) {
                $idanime = $_GET['idanime'];
            } else {
                $idanime = 0;
            }
        } else {
            $idanime = 0;
        }

        $this->ficheModel->removeFiche($_GET['idmanga'], $_GET['idanime']);

        $manga = $this->mangaModel->getById($_GET['idmanga']);
        if (!empty($manga)) {
            unlink('couvertures/' . $manga[0]['couverture']);
        }

        $anime = $this->animeModel->getById($_GET['idanime']);
        if (!empty($anime)) {
            unlink('illustrations/' . $anime[0]['image']);
        }

        $this->mangaModel->removeManga($_GET['idmanga']);
        $this->animeModel->removeAnime($_GET['idanime']);
        $this->ficheModel->delCommentairebyFiche($_GET['idmanga'], $_GET['idanime']);
        $this->ficheModel->delNoteByFiche($_GET['idmanga'], $_GET['idanime']);
        $this->ficheModel->delAimeByFiche($_GET['idmanga'], $_GET['idanime']);

        $this->displayAdmin();
    }

    public function suppManga() {

        $fiche = $this->ficheModel->getById($_GET['idmanga'], -1);
        if (!empty($fiche)) {
            if ($fiche[0]['idanime'] == 0) {
                $this->ficheModel->removeFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delCommentairebyFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delNoteByFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delAimeByFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
            } else {

                $this->ficheModel->setFiche(0, $fiche[0]['idanime'], '', '', $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdNote(0, $fiche[0]['idanime'], $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdAime(0, $fiche[0]['idanime'], $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdCom(0, $fiche[0]['idanime'], $fiche[0]['idmanga'], $fiche[0]['idanime']);
            }

            $manga = $this->mangaModel->getById($_GET['idmanga']);
            if (!empty($manga)) {
                unlink('couvertures/' . $manga[0]['couverture']);
            }
            $this->mangaModel->removeManga($_GET['idmanga']);
        }
        $this->displayAdmin();
    }

    public function suppAnime() {

        $fiche = $this->ficheModel->getById(-1, $_GET['idanime']);
        if (!empty($fiche)) {
            if ($fiche[0]['idmanga'] == 0) {
                $this->ficheModel->removeFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delCommentairebyFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delNoteByFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->delAimeByFiche($fiche[0]['idmanga'], $fiche[0]['idanime']);
            } else {

                $this->ficheModel->setFiche($fiche[0]['idmanga'], 0, '', '', $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdNote($fiche[0]['idmanga'], 0, $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdAime($fiche[0]['idmanga'], 0, $fiche[0]['idmanga'], $fiche[0]['idanime']);
                $this->ficheModel->setIdCom($fiche[0]['idmanga'], 0, $fiche[0]['idmanga'], $fiche[0]['idanime']);
            }

            $anime = $this->animeModel->getById($_GET['idanime']);
            if (!empty($anime)) {
                unlink('illustrations/' . $anime[0]['image']);
            }
            $this->animeModel->removeAnime($_GET['idanime']);
        }
        $this->displayAdmin();
    }

    public function suppUser() {

        $this->utilisateurModel->removeUserById($_GET['iduser']);
        $this->utilisateurModel->delAllAmi($_GET['iduser']);
        $this->utilisateurModel->delProfil($_GET['iduser']);
        $this->utilisateurModel->delAllNote($_GET['iduser']);
        $this->utilisateurModel->delAllAime($_GET['iduser']);
        
        $this->displayAdmin();
    }

}

?>
