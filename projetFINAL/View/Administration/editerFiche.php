<div id="versus">
<h2>Éditer Fiche</h2>
			<h3 class="offset1">Comparaison</h3>
			<form class="span7 offset2" name="anime" method="POST" enctype="multipart/form-data" action="index.php?module=Fiche&action=setCompar">
				<input type="hidden" name="idmanga" id="idmanga" value="<?php echo $idmanga; ?>" />
				<input type="hidden" name="idanime" id="idanime" value="<?php echo $idanime; ?>" />
				<label>Comparaison de l'histoire</label><div class="offset1 span10"><textarea class="span11" id="compStory" name="compStory"><?php if(isset($valide['compStory'])){ echo $valide['compStory'];}else{ echo html($fiche[0]['storycompar']);} ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['compStory'])) echo $erreur['compStory']; ?></span>
				<label>Comparaison des dessins</label><div class="offset1 span10"><textarea class="span11" id="compArt" name="compArt"><?php if(isset($valide['compArt'])){ echo $valide['compArt'];}else{ echo html($fiche[0]['artcompar']);} ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['compArt'])) echo $erreur['compArt']; ?></span>
				<input class="btn btn-success btn-block" id="next" type="submit" value="Fini" name="Fini" >
			</form>
</div>