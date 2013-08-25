<?php
require '../include/fonctions.php';
require '../include/EinfosBd.php';
require '../MyPDO.php';
$dbh = new MyPDO('mysql:host=database-etudiants;dbname='.$dbname, $login, $pass);
//$dbh = new MyPDO('mysql:host=localhost;dbname='.$dbname, $login, $pass);
if(isset($_POST['valeur'])){
	$valide=true;
	$titre=trim($_POST['valeur']);
	
	if($titre!=""){
		$selectManga=$dbh->prepare('SELECT idmanga FROM Manga Where titre LIKE "'.bdSql($titre).'"');
		
		try {
			// Récupération des résultats, ligne par ligne, par indice numérique
			$selectManga->setFetchMode(PDO::FETCH_NUM);
			$selectManga->execute();
									
			if ($selectManga->fetchColumn() > 0) {
				$selectManga->execute();
				while ($ligne = $selectManga->fetch()) {
					echo 'Une fiche sur ce manga existe déjà ici : <a href="./index.php?module=Fiche&action=displayFiche&idmanga='.html($ligne[0]).'">'.$titre.'</a>';
				}
			}else {
				echo $valide;
			}
		} catch (PDOException $e2) {
			print $e2->getMessage();
		}
	}else{
		echo $valide;
	}
}
?>
