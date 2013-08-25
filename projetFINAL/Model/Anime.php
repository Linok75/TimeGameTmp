<?php

/*
  La classe modèle pour les livres.
  Le constructeur permet de préparer trois requêtes de sélection de livres. Deux nouvelles propriétés sont définies par rapport à la classe Model/Template ; "selectByAuthor" et "selectByCategory". De la même manière, on retrouve plus loin les méthodes pour exécuter et récupérer les résultats de ces requêtes.
 */

class Model_Anime extends Model_Template {

    protected $selectAnimeEnX;
    protected $selectAnimeGenre;
    protected $selectIdByTitre;
    protected $selectIllustrationByIllustration;
    protected $selectForListe;
    protected $selectAllTitre;
    protected $insertion;
    protected $insertionGenre;
    protected $upAnime;
    protected $delGenreByAnime;
    protected $delAnime;
    
    protected $rechercheTitre;

    public function __construct() {
        parent::__construct();
        $sql = 'SELECT * FROM Anime WHERE titre LIKE ? OR titreAlt LIKE ? ORDER BY titre';
        $this->rechercheTitre = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM AnimeGenre WHERE idanime=?';
        $this->delGenreByAnime = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idanime FROM Anime Where titre LIKE ?';
        $this->selectIdByTitre = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Anime WHERE idanime=?';
        $this->selectById = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT genre FROM Genre, AnimeGenre WHERE AnimeGenre.idgenre=Genre.idgenre AND AnimeGenre.idanime=?';
        $this->selectAnimeGenre = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idanime,titre,lastEp,statut,auteur FROM Anime WHERE titre LIKE ? ORDER BY titre';
        $this->selectAnimeEnX = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT image FROM Anime WHERE image LIKE ?';
        $this->selectIllustrationByIllustration = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Anime (titre,titreAlt,auteur,dessinateur,anneedediff,studio,lastEp,statut,image,synopsis,dernieremaj) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
        $this->insertion = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO AnimeGenre (idanime,idgenre) VALUES (?,?)';
        $this->insertionGenre = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Anime SET titre=?, titreAlt=?, auteur=?, dessinateur=? ,  anneedediff=? , studio=? , lastEp=?, statut=? ,image=?, synopsis=? ,dernieremaj=? WHERE idanime=?';
        $this->upAnime = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Anime where idanime = ?';
        $this->delAnime = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idanime,titre,lastEp,Statut.statut,auteur FROM Anime, Statut WHERE Anime.statut=Statut.idstatut AND titre LIKE ?';
        $this->selectForListe = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idanime,titre FROM Anime ORDER BY titre';
        $this->selectAllTitre = Controller_Template::$db->prepare($sql);
    }

    public function delGenreByAnime($idanime) {
        return $this->delGenreByAnime->execute(array($idanime));
    }

    public function getIdByTitre($titre) {
        $this->selectIdByTitre->execute(array($titre));
        return $this->selectIdByTitre->fetchAll();
    }

    public function getById($id) {
        $this->selectById->execute(array($id));
        return $this->selectById->fetchAll();
    }

    public function getAnimeGenre($id) {
        $this->selectAnimeGenre->execute(array($id));
        return $this->selectAnimeGenre->fetchAll();
    }

    public function getAnimeEnX($char) {
        $this->selectAnimeEnX->execute(array($char));
        return $this->selectAnimeEnX->fetchAll();
    }

    public function getIllustrationByIllustration($illustration) {
        $this->selectIllustrationByIllustration->execute(array($illustration));
        return $this->selectIllustrationByIllustration->fetchAll();
    }

    public function addAnime($titre, $alt, $auteur, $dessinateur, $parution, $studio, $lastEp, $statut, $image, $synopsis) {
        return $this->insertion->execute(array($titre, $alt, $auteur, $dessinateur, $parution, $studio, $lastEp, $statut, $image, $synopsis, date('Y-m-d')));
    }

    public function addGenre($idmanga, $idgenre) {
        return $this->insertionGenre->execute(array($idmanga, $idgenre));
    }

    public function setAnime($titre, $alt, $auteur, $dessinateur, $parution, $studio, $lastEp, $statut, $image, $synopsis, $idanime) {
        return $this->upAnime->execute(array($titre, $alt, $auteur, $dessinateur, $parution, $studio, $lastEp, $statut, $image, $synopsis, date('Y-m-d'), $idanime));
    }

    public function removeAnime($id) {
        return $this->delAnime->execute(array($id));
    }

    public function getForListe($critere) {
        $this->selectForListe->execute(array($critere));
        return $this->selectForListe->fetchAll();
    }

    public function getAllTitre() {
        $this->selectAllTitre->execute();
        return $this->selectAllTitre->fetchAll();
    }
    
    public function rechercheTitre($titre) {
        $this->rechercheTitre->execute(array($titre,$titre));
        return $this->rechercheTitre->fetchAll();
    }

}

