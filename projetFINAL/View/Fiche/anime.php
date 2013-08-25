<div class="row-fluid"><div class="span6"><h2><?php echo html($anime[0]['titre']); ?></h2><h6>(Anime)</h6></div>
<?php
if (!empty($_SESSION) && $_SESSION['type'] <= 2) {
?>	
<div class="pull-right">
   <a href="index.php?module=Administration&action=gestionAnime&idanime=<?php echo $idanime; ?>" role="button" class="btn"><i class="icon-pencil"></i>Anime</a>
   <a href="index.php?module=Administration&action=suppAnime&idanime=<?php echo $idanime; ?>" role="button" class="btn"><i class="icon-remove"></i> Anime</a>
</div>
<?php
    }
?>
</div>
<div class="row-fluid">
<img class="offset2 couverture span8" src="illustrations/<?php echo html($anime[0]['image']); ?>" alt="Illustration de <?php echo html($anime[0]['titre']); ?>" />
<div class="row-fluid">
<div class="span4 offset2">
	<div>Titre Alternatif : </div>
	<div>Genre : </div>
	<div>Auteur : </div>
	<div>Dessinateur : </div>
	<div>Année de diffusion : </div>
	<div>Studio : </div>
	<div>Dernier épisode : </div>
	<div>Statut : </div>
</div>
<div class="span4">
<div><?php echo html($anime[0]['titreAlt']); ?></div>
<div><?php
echo html($animeGenre[0]['genre']); 
for($i = 1, $size = count($animeGenre); $i < $size; ++$i) {
	echo ', '.html($animeGenre[$i]['genre']); 
}
?></div>
<div><?php echo html($anime[0]['auteur']); ?></div>
<div><?php echo html($anime[0]['dessinateur']); ?></div>
<div><?php echo html($anime[0]['anneedediff']); ?></div>
<div><?php echo html($anime[0]['studio']); ?></div>
<div><?php echo html($anime[0]['lastEp']); ?></div>
<div><?php echo html($animeStatut[0]['statut']); ?></div>
</div>
</div>
<div class="row-fluid">
<div class="span2 offset1">Synopsis : </div><div class="span9 offset2"><?php echo html($anime[0]['synopsis']); ?></div>
</div>
<div class="row-fluid">
<span class="offset6 span6 lastMaj">Dernière mise à jour : <?php $lastMajAnime=date("d-m-Y",strtotime(html($anime[0]['dernieremaj']))); echo $lastMajAnime; ?></span>
</div>
</div>

