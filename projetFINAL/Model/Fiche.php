<?php

/*
  La classe modèle pour les livres.
  Le constructeur permet de préparer trois requêtes de sélection de livres. Deux nouvelles propriétés sont définies par rapport à la classe Model/Template ; "selectByAuthor" et "selectByCategory". De la même manière, on retrouve plus loin les méthodes pour exécuter et récupérer les résultats de ces requêtes.
 */

class Model_Fiche extends Model_Template {

    protected $selectAll;
    protected $insertion;
    protected $selectNote;
    protected $UpidNote;
    protected $UpidAime;
    protected $UpidCom;
    protected $selectAime;
    protected $insertAime;
    protected $insertNote;
    protected $upFiche;
    protected $avgNote;
    protected $sommeAime;
    protected $delAime;
    protected $delNote;
    protected $delManga;
    protected $selectAllCom;
    protected $selectCom;
    protected $delCom;
    
    protected $addCom;


    protected $delNoteByFiche;
    protected $delAimeByFiche;
    /*     * ******UP SAMIR************* */
    protected $delMangabyFiche;
    protected $delAnimebyFiche;
    protected $delCommentairebyFiche;
    /*     * *********************** */

    public function __construct() {
        parent::__construct();
        $sql = 'DELETE FROM Commentaire WHERE idcom=?';
        $this->delCom = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT * FROM Commentaire WHERE idcom=?';
        $this->selectCom = Controller_Template::$db->prepare($sql);
        
        $sql = 'INSERT INTO Commentaire (idanime, idmanga, iduser, datepost, texte) VALUES (?, ?, ?, NOW(), ?)';
        $this->addCom = Controller_Template::$db->prepare($sql);
        
        $sql = 'SELECT idcom,idanime,idmanga,datepost,texte,(SELECT pseudo FROM Utilisateur WHERE Utilisateur.iduser=Commentaire.iduser) as pseudo,(SELECT avatar FROM Profil WHERE Profil.iduser=Commentaire.iduser) as avatar FROM Commentaire WHERE idanime=? AND idmanga=? ORDER BY idcom DESC';
        $this->selectAllCom = Controller_Template::$db->prepare($sql);
        
        $sql = 'DELETE FROM Note WHERE idmanga=? AND idanime=?';
        $this->delNoteByFiche = Controller_Template::$db->prepare($sql);
        
        $sql = 'DELETE FROM Aimer WHERE idmanga=? AND idanime=?';
        $this->delAimeByFiche = Controller_Template::$db->prepare($sql);
        
        $sql = 'UPDATE Note SET idmanga=?, idanime=? WHERE idmanga=? AND idanime=?';
        $this->UpidNote = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Aimer SET idmanga=?, idanime=? WHERE idmanga=? AND idanime=?';
        $this->UpidAime = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Commentaire SET idmanga=?, idanime=? WHERE idmanga=? AND idanime=?';
        $this->UpidCom = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Fiche';
        $this->selectAll = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT SUM(Aimer.aime) as nbAime, (SELECT AVG(Note.note) FROM Note WHERE Note.idmanga=Aimer.idmanga AND Note.idanime=Aimer.idanime GROUP BY Note.idmanga,Note.idanime) as note, Aimer.idmanga, Aimer.idanime FROM Aimer GROUP BY Aimer.idmanga,Aimer.idanime ORDER BY nbAime DESC, note DESC';
        $this->sommeAime = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT AVG(Note.note) as note, (SELECT SUM(Aimer.aime) FROM Aimer WHERE Note.idmanga=Aimer.idmanga AND Note.idanime=Aimer.idanime GROUP BY Aimer.idmanga,Aimer.idanime)  as nbAime , Note.idmanga, Note.idanime FROM Note  GROUP BY Note.idmanga,Note.idanime  ORDER BY note DESC, nbAime DESC';
        $this->avgNote = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM Aimer WHERE iduser=? AND idmanga=? AND idanime=?';
        $this->delAime = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Aimer(idanime, idmanga, iduser, aime) VALUES(?, ?, ?, ?)';
        $this->insertAime = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE FROM Note WHERE idmanga=? AND idanime=? AND iduser=?';
        $this->delNote = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Note(idanime, idmanga, iduser, note) VALUES(?, ?, ?, ?)';
        $this->insertNote = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Aimer WHERE iduser=?  AND idmanga=? AND idanime=?';
        $this->selectAime = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Note WHERE iduser=? AND idmanga=? AND idanime=?';
        $this->selectNote = Controller_Template::$db->prepare($sql);

        $sql = 'SELECT * FROM Fiche Where idmanga=? OR idanime=?';
        $this->selectById = Controller_Template::$db->prepare($sql);

        $sql = 'INSERT INTO Fiche (idmanga, idanime) VALUES (?,?)';
        $this->insertion = Controller_Template::$db->prepare($sql);

        $sql = 'UPDATE Fiche SET idmanga=?,idanime=?,storycompar=?,artcompar=? WHERE idmanga=? AND idanime=?';
        $this->upFiche = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Fiche where idmanga = ? AND idanime=?';
        $this->delManga = Controller_Template::$db->prepare($sql);


        /*         * *****************UP SAMIR*************** */
        $sql = 'DELETE from Manga where idmanga = ?';
        $this->delMangabyFiche = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Anime where idanime = ?';
        $this->delAnimebyFiche = Controller_Template::$db->prepare($sql);

        $sql = 'DELETE from Commentaire where idmanga = ? and idanime=?';
        $this->delCommentairebyFiche = Controller_Template::$db->prepare($sql);
        /*         * ****************************************** */
    }
    
    public function delCom($idcom){
        return $this->delCom->execute(array($idcom));
    }
    
    public function getCom($idcom){
        $this->selectCom->execute(array($idcom));
        return $this->selectCom->fetchAll();
    }
    
    public function addCom($idAnime, $idManga, $iduser, $message){
        return $this->addCom->execute(array($idAnime, $idManga, $iduser, $message));
    }

    public function getAllCom($idmanga,$idanime){
        $this->selectAllCom->execute(array($idanime, $idmanga));
        return $this->selectAllCom->fetchAll();
    }
    
    public function setIdNote($idmanga, $idanime, $oldIdManga, $oldIdAnime) {
        return $this->UpidNote->execute(array($idmanga, $idanime, $oldIdManga, $oldIdAnime));
    }

    public function setIdAime($idmanga, $idanime, $oldIdManga, $oldIdAnime) {
        return $this->UpidAime->execute(array($idmanga, $idanime, $oldIdManga, $oldIdAnime));
    }

    public function setIdCom($idmanga, $idanime, $oldIdManga, $oldIdAnime) {
        return $this->UpidCom->execute(array($idmanga, $idanime, $oldIdManga, $oldIdAnime));
    }

    public function getALl() {
        $this->selectAll->execute();
        return $this->selectAll->fetchAll();
    }

    public function getSumAime() {
        $this->sommeAime->execute();
        return $this->sommeAime->fetchAll();
    }

    public function getAvgNote() {
        $this->avgNote->execute();
        return $this->avgNote->fetchAll();
    }

    public function delAime($idanime, $idmanga, $iduser) {
        return $this->delAime->execute(array($iduser, $idmanga, $idanime));
    }

    public function addAime($idanime, $idmanga, $iduser, $val) {
        return $this->insertAime->execute(array($idanime, $idmanga, $iduser, $val));
    }

    public function delNote($idmanga, $idanime, $iduser) {
        return $this->delNote->execute(array($idmanga, $idanime, $iduser));
    }

    public function addNote($idanime, $idmanga, $iduser, $note) {
        return $this->insertNote->execute(array($idanime, $idmanga, $iduser, $note));
    }

    public function getAime($iduser, $idmanga, $idanime) {
        $this->selectAime->execute(array($iduser, $idmanga, $idanime));
        return $this->selectAime->fetchAll();
    }

    public function getNote($iduser, $idmanga, $idanime) {
        $this->selectNote->execute(array($iduser, $idmanga, $idanime));
        return $this->selectNote->fetchAll();
    }

    public function getById($idmanga, $idanime) {
        $this->selectById->execute(array($idmanga, $idanime));
        return $this->selectById->fetchAll();
    }

    public function addFiche($idmanga, $idanime) {
        return $this->insertion->execute(array($idmanga, $idanime));
    }

    public function setFiche($idmangaNew, $idanimeNew, $storyComp, $artComp, $idmangaOld, $idanimeOld) {
        return $this->upFiche->execute(array($idmangaNew, $idanimeNew, $storyComp, $artComp, $idmangaOld, $idanimeOld));
    }

    public function removeFiche($idmanga, $idanime) {
        return $this->delManga->execute(array($idmanga, $idanime));
    }
    
    public function delAimeByFiche($idmanga,$idanime){
        return $this->delAimeByFiche->execute(array($idmanga,$idanime));
    }
    
    public function delNoteByFiche($idmanga,$idanime){
        return $this->delNoteByFiche->execute(array($idmanga,$idanime));
    }
	
    public function delCommentairebyFiche($idmanga, $idanime) {
        return $this->delCommentairebyFiche->execute(array($idmanga, $idanime));
    }

}
