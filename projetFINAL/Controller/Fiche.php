<?php

class Controller_Fiche extends Controller_Template {

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

    public function newFiche() {
        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/nouveauManga.php';
        require 'View/footer.php';
    }

    public function addManga() {
        if (!isset($_POST['noManga'])) {
            $titre = trim($_POST['titre']);
            $alt = trim($_POST['titreAlt']);
            $auteur = trim($_POST['auteur']);
            $parution = trim($_POST['parution']);
            $editeur = trim($_POST['editeur']);
            $lastChap = trim($_POST['lastChap']);
            $statut = trim($_POST['statut']);
            $resume = trim($_POST['resume']);
            $couverture = $_FILES['couverture'];

            if (!isset($_POST['genre']) || empty($_POST['genre'])) {
                $erreur['genre'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            } else {
                $genre = $_POST['genre'];
                $valide['genre'] = $genre;
            }


            if (!empty($titre)) {
                $IdByTitre = $this->mangaModel->getIdByTitre(bdSql($titre));
                if (count($IdByTitre) > 0) {
                    $erreur['titre'] = '<span class="erreur">Une fiche sur ce manga existe déjà ici : <a href="./ficheViewer.php?idmanga=' . html($IdByTitre[0]['idmanga']) . '">' . $titre . '</a></span>';
                } else {
                    $valide['titre'] = $titre;
                }
            } else {
                $erreur['titre'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            }

            $valide['alt'] = $alt;

            if (!empty($auteur)) {
                $valide['auteur'] = $auteur;
            } else {
                $erreur['auteur'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            }

            if (!empty($parution)) {
                if (!preg_match("#^[0-9]+$#", $parution) || strlen($parution) != 4) {
                    $erreur['parution'] = '<span class="erreur">L\' année de parution est composée de 4 chiffres ! (exemple : 2008)</span>';
                } else {
                    $valide['parution'] = $parution;
                }
            } else {
                $erreur['parution'] = '<span class="erreur">(*) Champs Obligatoire</span>';
            }

            if (!empty($editeur)) {
                $valide['editeur'] = $editeur;
            } else {
                $erreur['editeur'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            }

            if (!empty($lastChap)) {
                if (!preg_match("#^[0-9]+$#", $lastChap)) {
                    $erreur['lastChap'] = '<span class="erreur">Le numéro du dernier chapitre est obligatoirement un nombre ! (exemple : 25)</span>';
                } else {
                    $valide['lastChap'] = $lastChap;
                }
            } else {
                $erreur['lastChap'] = '<span class="erreur">(*) Champs Obligatoire</span>';
            }

            $valide['statut'] = $statut;

            if (!empty($resume)) {
                $valide['resume'] = $resume;
            } else {
                $erreur['resume'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            }


            $maxSize = 1048576;
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $nomRandom = "";
            $chemin = "";

            if ($couverture['error'] > 0)
                $erreur['couverture'] = '<span class="erreur">(*) Champ Obligatoire</span>';
            if (!isset($erreur['couverture'])) {
                $extension_upload = strtolower(substr(strrchr($couverture['name'], '.'), 1));
                $nomRandom = md5(uniqid(rand(), true));
                $nomRandom = $nomRandom . "." . $extension_upload;
                if ($couverture['size'] > $maxSize) {
                    if (!isset($erreur['couverture'])) {
                        $erreur['couverture'] = '<span class="erreur">';
                    }
                    $erreur['couverture'] = $erreur['couverture'] . ' Le fichier est trop gros ! ';
                }
                if (!in_array($extension_upload, $extensions_valides)) {
                    if (!isset($erreur['couverture'])) {
                        $erreur['couverture'] = '<span class="erreur">';
                    }
                    $erreur['couverture'] = $erreur['couverture'] . ' Extension non valide ! ';
                }
            }
            if (!isset($erreur['couverture'])) {
                $valide['couverture'] = $couverture['tmp_name'];
            } else {
                $erreur['couverture'] = $erreur['couverture'] . '</span>';
            }


            if (isset($erreur)) {
                $require = 'nouveauManga.php';
            } else {
                $CouverureByCouverture = $this->mangaModel->getCouvertureByCouverture(bdSql($nomRandom));
                if (count($CouverureByCouverture) > 0) {
                    $verifImg = false;
                    while (!$verif) {
                        $nomRandom = md5(uniqid(rand(), true));
                        $nomRandom = $nomRandom . "." . $extension_upload;
                        $CouverureByCouverture = $this->mangaModel->getCouvertureByCouverture(bdSql($nomRandom));
                        if (count($CouverureByCouverture) <= 0) {
                            $verifImg = true;
                        }
                    }
                }

                $chemin = "./couvertures/" . $nomRandom;
                $transfert = move_uploaded_file($couverture['tmp_name'], $chemin);

                if ($transfert) {
                    $insertion = $this->mangaModel->addManga(bdSql($titre), bdSql($alt), bdSql($auteur), bdSql($parution), bdSql($editeur), bdSql($lastChap), bdSql($statut), bdSql($nomRandom), bdSql($resume));
                    $IdByTitre = $this->mangaModel->getIdByTitre(bdSql($titre));

                    for ($i = 0, $size = count($genre); $i < $size; ++$i) {
                        $insertionGenre = $this->mangaModel->addGenre(bdSql($IdByTitre[0]['idmanga']), bdSql($genre[$i]));
                    }

                    $insertion = $this->ficheModel->addFiche(bdSql($IdByTitre[0]['idmanga']), 0);

                    $idmanga = $IdByTitre[0]['idmanga'];
                    $require = 'nouvelAnime.php';
                } else {
                    $erreur['couverture'] = '<span class="erreur">Upload de la couverture échoué pour une raison inconnu !</span>';
                    $valide['couverture'] = '';
                    $require = 'nouveauManga.php';
                }
            }
        } else {
            $idmanga = 0;
            $require = 'nouvelAnime.php';
        }
        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/' . $require;
        require 'View/footer.php';
    }

    public function formAnime() {
        $allStatut = $this->statutModel->getAll();
        $allGenre = $this->genreModel->getAll();

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/nouvelAnime.php';
        require 'View/footer.php';
    }

    public function addAnime() {
        if (!isset($_POST['noAnime'])) {
            if (isset($_POST['idmanga'])) {
                $idmanga = $_POST['idmanga'];
            } else {
                $idmanga = 0;
            }


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
                $require = 'retour';
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

                    if ($idmanga == 0) {
                        $addFiche = $this->ficheModel->addFiche(0, bdSql($idanime));
                    } else {
                        $addFiche = $this->ficheModel->setFiche(bdSql($idmanga), bdSql($idanime), '', '', bdSql($idmanga), 0);
                    }
                    $require = 'suite';
                } else {
                    $erreur['illustration'] = '<span class="erreur">Upload de l\'illustration échoué pour une raison inconnu !</span>';
                    $valide['illustration'] = '';
                    $require = 'retour';
                }
            }
        } else {
            $idmanga = $_POST['idmanga'];
            $idanime = 0;
            $require = 'suite';
        }

        if ($require == 'retour') {
            $allStatut = $this->statutModel->getAll();
            $allGenre = $this->genreModel->getAll();
            header('Content-Type: text/html; charset=utf-8');
            require 'View/header.php';
            Controller_Template::$profil->menuGauche();
            require 'View/Fiche/nouvelAnime.php';
            require 'View/footer.php';
        } else {
            if ($idmanga != 0 && $idanime != 0) {
                header('Location: ./index.php?module=Fiche&action=finalFiche&idmanga=' . $idmanga . '&idanime=' . $idanime);
            } else {
                if ($idmanga == 0) {
                    header('Location: ./index.php?module=Fiche&action=displayFiche&idanime=' . $idanime);
                } else {
                    header('Location: ./index.php?module=Fiche&action=displayFiche&idmanga=' . $idmanga);
                }
            }
        }
    }

    public function displayFiche() {
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
            $require = 'View/Profil/index.php';
        } else {
            $idmanga = $fiche[0]['idmanga'];
            $idanime = $fiche[0]['idanime'];

            if ($idmanga != 0) {
                $mangaGenre = $this->mangaModel->getMangaGenre(bdSql($idmanga));
                $manga = $this->mangaModel->getById(bdSql($idmanga));
                $mangaStatut = $this->statutModel->getById(bdSql($manga[0]['statut']));
            }
            if ($idanime != 0) {
                $animeGenre = $this->animeModel->getAnimeGenre(bdSql($idanime));
                $anime = $this->animeModel->getById(bdSql($idanime));
                $animeStatut = $this->statutModel->getById(bdSql($anime[0]['statut']));
            }

            $coms = $this->ficheModel->getAllCom($idmanga, $idanime);

            $require = 'View/Fiche/fiche.php';
            if (!empty($_SESSION)) {
                $note = $this->ficheModel->getNote($_SESSION['id'], $idmanga, $idanime);
                $aime = $this->ficheModel->getAime($_SESSION['id'], $idmanga, $idanime);
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require $require;
        require 'View/footer.php';
    }

    public function finalFiche() {
        $idmanga = $_GET['idmanga'];
        $idanime = $_GET['idanime'];

        $mangaGenre = $this->mangaModel->getMangaGenre(bdSql($idmanga));
        $manga = $this->mangaModel->getById(bdSql($idmanga));
        $mangaStatut = $this->statutModel->getById(bdSql($manga[0]['statut']));

        $animeGenre = $this->animeModel->getAnimeGenre(bdSql($idanime));
        $anime = $this->animeModel->getById(bdSql($idanime));
        $animeStatut = $this->statutModel->getById(bdSql($anime[0]['statut']));

        $note = $this->ficheModel->getNote($_SESSION['id'], $idmanga, $idanime);
        $aime = $this->ficheModel->getAime($_SESSION['id'], $idmanga, $idanime);

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/finalFiche.php';
        require 'View/footer.php';
    }

    public function setCompar() {
        $compStory = trim($_POST['compStory']);
        $compArt = trim($_POST['compArt']);
        $idmanga = $_POST['idmanga'];
        $idanime = $_POST['idanime'];

        $setFiche = $this->ficheModel->setFiche($idmanga, $idanime, bdSql($compStory), bdSql($compArt), $idmanga, $idanime);
        //echo $idmanga.$idanime;
        header('Location: ./index.php?module=Fiche&action=displayFiche&idmanga=' . $idmanga);
    }

    public function displayListe() {
        $critere = $_GET['char'] . '%';

        $manga = $this->mangaModel->getForListe(bdSql($critere));
        $anime = $this->animeModel->getForListe(bdSql($critere));

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/liste.php';
        require 'View/footer.php';
    }

    public function setNote() {
        if (isset($_SESSION['id'])) {
            $idmanga = $_GET['idmanga'];
            $idanime = $_GET['idanime'];
            $note = $_GET['note'];
            $getNote = $this->ficheModel->getNote($_SESSION['id'], $idmanga, $idanime);
            if ($note >= 0 AND $note <= 5) {
                if (count($getNote) == 0) {
                    $insertNote = $this->ficheModel->addNote($idanime, $idmanga, $_SESSION['id'], $note);
                    //$err = '<p>Note enregistrée !</p>';
                } else {
                    $err = 'Deja noté !';
                }
            } else {
                $err = 'Tricheur !';
            }
        }

        $this->displayFiche();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function delNote() {
        if (isset($_SESSION['id'])) {
            $idmanga = $_GET['idmanga'];
            $idanime = $_GET['idanime'];
            $delNote = $this->ficheModel->delNote($idmanga, $idanime, $_SESSION['id']);

            //$err = 'Note Supprimé';
        }

        $this->displayFiche();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function setAime() {
        if (isset($_SESSION['id'])) {
            $idmanga = $_GET['idmanga'];
            $idanime = $_GET['idanime'];

            $aime = $this->ficheModel->getAime($_SESSION['id'], $idmanga, $idanime);
            if (count($aime) == 0) {
                if ($_SESSION['type'] == 3) {
                    $insertAime = $this->ficheModel->addAime($idanime, $idmanga, $_SESSION['id'], 2);
                } else {
                    $insertAime = $this->ficheModel->addAime($idanime, $idmanga, $_SESSION['id'], 1);
                }
                //$err = 'Vous avez du goût !';
            } else {
                $err = 'Vous aimé déjà cette fiche !';
            }
        }

        $this->displayFiche();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function delAime() {
        if (isset($_SESSION['id'])) {
            $idmanga = $_GET['idmanga'];
            $idanime = $_GET['idanime'];
            $delNote = $this->ficheModel->delAime($idanime, $idmanga, $_SESSION['id']);

            //$err = 'Vous n\'aimez plus cette fiche...';
        }

        $this->displayFiche();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function displayTop50() {
        $avgNote = $this->ficheModel->getAvgNote();
        $sumAime = $this->ficheModel->getSumAime();

        $limit = 50;
        if (count($avgNote) < $limit) {
            $limit = count($avgNote);
        }

        for ($i = 0; $i < $limit; $i++) {
            $classementByNote[$i]['idmanga'] = $avgNote[$i]['idmanga'];
            $classementByNote[$i]['idanime'] = $avgNote[$i]['idanime'];
            $classementByNote[$i]['manga'] = $this->mangaModel->getById($avgNote[$i]['idmanga']);
            $classementByNote[$i]['anime'] = $this->animeModel->getById($avgNote[$i]['idanime']);
            $classementByNote[$i]['note'] = number_format($avgNote[$i]['note'], 2);
            $classementByNote[$i]['nbAime'] = $avgNote[$i]['nbAime'];
            if (!isset($classementByNote[$i]['nbAime'])) {
                $classementByNote[$i]['nbAime'] = 0;
            }
            if (empty($classementByNote[$i]['manga'])) {
                $classementByNote[$i]['manga'][0]['titre'] = '';
            }
            if (empty($classementByNote[$i]['anime'])) {
                $classementByNote[$i]['anime'][0]['titre'] = '';
            }
        }

        $limit = 50;
        if (count($sumAime) < $limit) {
            $limit = count($sumAime);
        }

        for ($i = 0; $i < $limit; $i++) {
            $classementByAime[$i]['idmanga'] = $sumAime[$i]['idmanga'];
            $classementByAime[$i]['idanime'] = $sumAime[$i]['idanime'];
            $classementByAime[$i]['manga'] = $this->mangaModel->getById($sumAime[$i]['idmanga']);
            $classementByAime[$i]['anime'] = $this->animeModel->getById($sumAime[$i]['idanime']);
            $classementByAime[$i]['note'] = number_format($sumAime[$i]['note'], 2);
            $classementByAime[$i]['nbAime'] = $sumAime[$i]['nbAime'];
            if ($classementByAime[$i]['note'] == 0) {
                $classementByAime[$i]['note'] = 'NC';
            }
            if (empty($classementByAime[$i]['manga'])) {
                $classementByAime[$i]['manga'][0]['titre'] = '';
            }
            if (empty($classementByAime[$i]['anime'])) {
                $classementByAime[$i]['anime'][0]['titre'] = '';
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        require 'View/header.php';
        Controller_Template::$profil->menuGauche();
        require 'View/Fiche/classement.php';
        require 'View/footer.php';
    }

    public function addCom() {
        $fiche = $this->ficheModel->getById($_POST['idManga'], $_POST['idAnime']);
        if (!empty($fiche)) {
            if (!empty($_POST['message']) && (!empty($_POST['idAnime']) || !empty($_POST['idManga'])) && isset($_SESSION['id'])) {
                $addCom = $this->ficheModel->addCom($_POST['idAnime'], $_POST['idManga'], $_SESSION['id'], bdSql($_POST['message']));
            } else {
                $err = 'Sans Commentaire...hum !';
            }

            $_GET['idmanga'] = $_POST['idManga'];
            $_GET['idanime'] = $_POST['idAnime'];
        } else {
            header('Location: ./index.php');
        }
        $this->displayFiche();
        if (!empty($err)) {
            require 'View/err.php';
        }
    }

    public function suppCom() {
        $com = $this->ficheModel->getCom($_GET['idcom']);
        if (!empty($com)) {
            if ($com[0]['iduser'] == $_SESSION['id'] || $_SESSION['type'] <= 2) {
                $delCom = $this->ficheModel->delCom($com[0]['idcom']);
                $_GET['idmanga'] = $com[0]['idmanga'];
                $_GET['idanime'] = $com[0]['idanime'];

                $this->displayFiche();
            } else {
                $err = 'Ce commentaire ne vous appartient pas !';
            }
        } else {
            $err = 'Commentaire innexistant !';
            Controller_Template::$profil->index();
            if (!empty($err)) {
                require 'View/err.php';
            }
        }
    }

    public function recherche() {
        $critere = trim($_POST['search']);
        $critere = '%' . $critere . '%';

        if ($_POST['type'] == 'fiche') {
            $manga = $this->mangaModel->rechercheTitre(bdSql($critere));
            $anime = $this->animeModel->rechercheTitre(bdSql($critere));

            header('Content-Type: text/html; charset=utf-8');
            require 'View/header.php';
            Controller_Template::$profil->menuGauche();
            require 'View/Fiche/liste.php';
            require 'View/footer.php';
        } else {
            $liste = $this->utilisateurModel->searchUser(bdSql($critere), $_SESSION['id']);

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
    }

}