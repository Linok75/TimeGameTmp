<?php

/*
  La classe modèle pour les livres.
  Le constructeur permet de préparer trois requêtes de sélection de livres. Deux nouvelles propriétés sont définies par rapport à la classe Model/Template ; "selectByAuthor" et "selectByCategory". De la même manière, on retrouve plus loin les méthodes pour exécuter et récupérer les résultats de ces requêtes.
 */

class Model_Manga extends Model_Template {

    protected $selectMangaEnX;
    protected $selectMangaGenre;
    protected $selectIdByTitre;
    protected $selectCouverureByCouverture;
    protected $selectForListe;
    protected $selectAllTitre;
    protected $insertion;
    protected $insertionGenre;
    protected $delGenreByManga;
    protected $upManga;
    protected $delManga;


    /*     * *******************TRISTAN********************* */
    protected $rechercheTitre;

    /*     * ********************************************** */

    public function __construct() {
        parent::__construct();
        $sql = 'DELETE FROM MangaGenre WHERE idmanga=?';
        $this->delGenreByManga = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idmanga FROM Manga Where titre LIKE ?';
        $this->selectIdByTitre = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Manga WHERE idmanga=?';
        $this->selectById = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT genre FROM Genre, MangaGenre WHERE MangaGenre.idgenre=Genre.idgenre AND MangaGenre.idmanga=?';
        $this->selectMangaGenre = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idmanga,titre,dernierchap,statut,auteur FROM Manga WHERE titre LIKE ? ORDER BY titre';
        $this->selectMangaEnX = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT couverture FROM Manga WHERE couverture LIKE ?';
        $this->selectCouverureByCouverture = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Manga (titre,titreAlt,auteur,anneeparution,editeurori,dernierchap,statut,couverture,synopsis,dernieremaj) VALUES (?,?,?,?,?,?,?,?,?,?)';
        $this->insertion = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO MangaGenre (idmanga,idgenre) VALUES (?,?)';
        $this->insertionGenre = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Manga SET titre=?, titreAlt=?, auteur=?, anneeparution=? ,  editeurori=? ,  	dernierchap=? , statut=? , couverture=?, synopsis=? ,dernieremaj=? WHERE idmanga=?';
        $this->upManga = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Manga where idmanga = ?';
        $this->delManga = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idmanga,titre,dernierchap,Statut.statut,auteur FROM Manga, Statut WHERE Manga.statut=Statut.idstatut AND titre LIKE ?';
        $this->selectForListe = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT idmanga,titre FROM Manga ORDER BY titre';
        $this->selectAllTitre = Controller_Template::$db->prepare($sql);

        /*         * ***************************TRISTAN************************** */
        $sql = 'SELECT * FROM Manga WHERE titre LIKE ? OR titreAlt LIKE ? ORDER BY titre';
        $this->rechercheTitre = Controller_Template::$db->prepare($sql);
        /*         * **************************************************** */
    }

    public function delGenreByManga($idmanga) {
        return $this->delGenreByManga->execute(array($idmanga));
    }

    public function getIdByTitre($titre) {
        $this->selectIdByTitre->execute(array($titre));
        return $this->selectIdByTitre->fetchAll();
    }

    public function getById($id) {
        $this->selectById->execute(array($id));
        return $this->selectById->fetchAll();
    }

    public function getMangaGenre($id) {
        $this->selectMangaGenre->execute(array($id));
        return $this->selectMangaGenre->fetchAll();
    }

    public function getMangaEnX($char) {
        $this->selectMangaEnX->execute(array($char));
        return $this->selectMangaEnX->fetchAll();
    }

    public function getCouvertureByCouverture($couverture) {
        $this->selectMangaEnX->execute(array($couverture));
        return $this->selectMangaEnX->fetchAll();
    }

    public function addManga($titre, $alt, $auteur, $parution, $editeur, $lastChap, $statut, $nomRandom, $resume) {
        return $this->insertion->execute(array($titre, $alt, $auteur, $parution, $editeur, $lastChap, $statut, $nomRandom, $resume, date('Y-m-d')));
    }

    public function addGenre($idmanga, $idgenre) {
        return $this->insertionGenre->execute(array($idmanga, $idgenre));
    }

    public function setManga($titre, $alt, $auteur, $parution, $editeur, $lastChap, $statut, $nomRandom, $resume, $idmanga) {
        return $this->upManga->execute(array($titre, $alt, $auteur, $parution, $editeur, $lastChap, $statut, $nomRandom, $resume, date('Y-m-d'), $idmanga));
    }

    public function removeManga($id) {
        return $this->delManga->execute(array($id));
    }

    public function getForListe($critere) {
        $this->selectForListe->execute(array($critere));
        return $this->selectForListe->fetchAll();
    }

    public function getAllTitre() {
        $this->selectAllTitre->execute();
        return $this->selectAllTitre->fetchAll();
    }

    /*     * ***********************TRISTANT************************** */

    public function rechercheTitre($titre) {
        $this->rechercheTitre->execute(array($titre,$titre));
        return $this->rechercheTitre->fetchAll();
    }

    /*     * ************************************************************ */
}
