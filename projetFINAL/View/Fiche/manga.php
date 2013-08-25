<div class="row-fluid"><div class="span6"><h2><?php echo html($manga[0]['titre']); ?></h2><h6>(Manga)</h6></div>
<?php
if (!empty($_SESSION) && $_SESSION['type'] <= 2) {
?>	
<div class="pull-right">
   <a href="index.php?module=Administration&action=gestionManga&idmanga=<?php echo $idmanga; ?>" role="button" class="btn"><i class="icon-pencil"></i>Manga</a>
   <a href="index.php?module=Administration&action=suppManga&idmanga=<?php echo $idmanga; ?>" role="button" class="btn"><i class="icon-remove"></i>Manga</a>
</div>
<?php
    }
?>
</div>
<div class="row-fluid">
<img class="offset2 couverture span8" src="couvertures/<?php echo html($manga[0]['couverture']); ?>" alt="Couverture de <?php echo html($manga[0]['titre']); ?>" />
<div class="row-fluid">
<div class="span4 offset2">
	<div>Titre Alternatif : </div>
	<div>Genre : </div>
	<div>Auteur : </div>
	<div>Année de parution : </div>
	<div>Studio : </div>
	<div>Dernier chapitre : </div>
	<div>Statut : </div>
</div>
<div class="span4">
<div><?php echo html($manga[0]['titreAlt']); ?></div>
<div><?php
echo html($mangaGenre[0]['genre']); 
for($i = 1, $size = count($mangaGenre); $i < $size; ++$i) {
	echo ', '.html($mangaGenre[$i]['genre']); 
}
?></div>
<div><?php echo html($manga[0]['auteur']); ?></div>
<div><?php echo html($manga[0]['anneeparution']); ?></div>
<div><?php echo html($manga[0]['editeurori']); ?></div>
<div><?php echo html($manga[0]['dernierchap']); ?></div>
<div><?php echo html($mangaStatut[0]['statut']); ?></div>
</div>
</div>
<div class="row-fluid">
<div class="span2 offset1">Synopsis : </div><div class="span9 offset2"><?php echo html($manga[0]['synopsis']); ?></div>
</div>
<div class="row-fluid">
<span class="offset6 span6 lastMaj">Dernière mise à jour : <?php $lastMajManga=date("d-m-Y",strtotime(html($manga[0]['dernieremaj']))); echo $lastMajManga; ?></span>
</div>
</div>
