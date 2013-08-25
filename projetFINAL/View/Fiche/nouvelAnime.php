<script src="scripts/nouvelAnime.js"></script>
<h2>Nouvelle Fiche</h2>
			<h3 class="offset1">L' Anime</h3>
			<form class="span7 offset2 form-horizontal" name="anime" method="POST" enctype="multipart/form-data" action="index.php?module=Fiche&action=addAnime">
				<?php if( $idmanga!=0 ){ ?>
				<input type="hidden" name="idmanga" id="idmanga" value="<?php echo $idmanga; ?>" />
				<div class="control-group">
				<label  for="noAnime">Si le manga que vous avez ajouter n'est associé à aucun anime cocher cette case. <input id="noAnime" type="checkbox" name="noAnime" value="noAnime"></label>
				</div>
				<?php } ?>
				<div id="anime">
				<div class="control-group">
				<label class="control-label" for="titre">Titre*</label><div class="controls"><input class="test nonNull" required="required" id="titre" name="titre" type="text" value="<?php if(isset($valide['titre'])) echo $valide['titre']; ?>"></div>
				<span class="help-block err"><?php if(isset($erreur['titre'])) echo $erreur['titre']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="titreAlt">Titre alternatif</label><div class="controls"><input id="titreAlt" name="titreAlt" type="text" value="<?php if(isset($valide['alt'])) echo $valide['alt']; ?>"></div>
				</div>
				<div class="control-group">
				<label class="control-label" for="genre">Genre*</label>
				<div class="controls"><select class="nonNull" required="required" id="genre" name="genre[]" multiple="multiple">
					<?php
							$i=0;
							
							for($j=0, $size=count($allGenre);$j<$size;++$j){
								echo '<option value="'.$allGenre[$j]['idgenre'].'"';
								if(isset($valide['genre'])){
									if($valide['genre'][$i]==$allGenre[$j]['idgenre']){
										 echo ' selected="selected"';
										 $i++;
									}
								}
								echo '>'.html($allGenre[$j]['genre']).'</option>';
							}
					?>
				</select></div>
				<span class="help-block"><?php if(isset($erreur['genre'])) echo $erreur['genre']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="auteur">Auteur*</label><div class="controls"><input class="nonNull" required="required" id="auteur" name="auteur" type="text" value="<?php if(isset($valide['auteur'])) echo $valide['auteur']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['auteur'])) echo $erreur['auteur']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="dessinateur">Dessinateur*</label><div class="controls"><input class="nonNull" required="required" id="dessinateur" name="dessinateur" type="text" value="<?php if(isset($valide['dessinateur'])) echo $valide['dessinateur']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['dessinateur'])) echo $erreur['dessinateur']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="diffusion">Année de diffusion*</label><div class="controls"><input class="test nonNull" required="required" id="diffusion" name="diffusion" type="text" value="<?php if(isset($valide['diffusion'])) echo $valide['diffusion']; ?>"></div>
				<span class="help-block err"><?php if(isset($erreur['diffusion'])) echo $erreur['diffusion']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="studio">Studio d'origine*</label><div class="controls"><input class="nonNull" required="required" id="studio" name="studio" type="text" value="<?php if(isset($valide['studio'])) echo $valide['studio']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['studio'])) echo $erreur['studio']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="lastEp">Dernier épisode*</label><div class="controls"><input class="test nonNull" required="required" id="lastEp" name="lastEp" type="text" value="<?php if(isset($valide['lastEp'])) echo $valide['lastEp']; ?>"></div>
				<span class="help-block err"><?php if(isset($erreur['lastEp'])) echo $erreur['lastEp']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="statut">Statut*</label>
				<div class="controls"><select id="statut" name="statut">
					<?php
							for($i=0, $size=count($allStatut);$i<$size;++$i){
								echo '<option value="'.$allStatut[$i]['idstatut'].'"';
								if(isset($valide['statut'])){
									if($valide['statut']==$allStatut[$i]['idstatut']){
										 echo ' selected="selected"';
									}
								}
								echo '>'.html($allStatut[$i]['statut']).'</option>';
							}
					?>
				</select></div>
				</div>
				<div class="control-group">
				<label class="control-label" for="illustration">Illustration*</label><div class="controls"><input class="nonNull" required="required" id="illustration" name="illustration" type="file" value="<?php if(isset($valide['illustration'])) echo $valide['illustration']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['illustration'])) echo $erreur['illustration'].'<br/>'; ?>(Extension Valide : jpg,jpeg,png,gif | Taille maximal : 1Mo)</span>
				</div>
				<div class="control-group">
				<label class="control-label" for="synopsis">Synopsis*</label><div class="controls"><textarea class="nonNull" required="required" id="synopsis" name="synopsis"><?php if(isset($valide['synopsis'])) echo $valide['synopsis']; ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['synopsis'])) echo $erreur['synopsis']; ?></span>
				</div>
				</div>
				<input class="btn btn-success btn-block" id="next" type="submit" value="Suivant" name="suivant" >
			</form>

