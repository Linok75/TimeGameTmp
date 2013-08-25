<script src="scripts/versus.js"></script>
<div class="control-group">
<label  for="noComp">Cocher la case pour ne pas faire de comparaison entre le manga et l'anime. <input id="noComp" type="checkbox" name="noComp" value="noComp"></label>
</div>
<div id="versus">
<h2>Nouvel Fiche</h2>
			<h3 class="offset1">Comparaison</h3>
			<form class="span7 offset2" name="anime" method="POST" enctype="multipart/form-data" action="index.php?module=Fiche&action=setCompar">
				<input type="hidden" name="idmanga" id="idmanga" value="<?php echo $_GET['idmanga']; ?>" />
				<input type="hidden" name="idanime" id="idanime" value="<?php echo $_GET['idanime']; ?>" />
				<label>Comparaison de l'histoire</label><div class="offset1 span10"><textarea class="span11" id="compStory" name="compStory"><?php if(isset($valide['compStory'])) echo $valide['compStory']; ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['compStory'])) echo $erreur['compStory']; ?></span>
				<label>Comparaison des dessins</label><div class="offset1 span10"><textarea class="span11" id="compArt" name="compArt"><?php if(isset($valide['compArt'])) echo $valide['compArt']; ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['compArt'])) echo $erreur['compArt']; ?></span>
				<input class="btn btn-success btn-block" id="next" type="submit" value="Fini" name="Fini" >
			</form>
</div>
<div id="fiche">
<?php
	require ('fiche.php');
?>
</div>
