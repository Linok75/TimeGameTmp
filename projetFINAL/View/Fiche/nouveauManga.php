<script src="scripts/nouvelleFiche.js"></script>
<h2>Nouvelle Fiche</h2>
			<h3 class="offset1">Le Manga</h3>
			<form class="span7 offset2 form-horizontal" name="manga" method="POST" enctype="multipart/form-data" action="index.php?module=Fiche&action=addManga">
				<div class="control-group">
				<label  for="noManga">Si l'animé que vous souhaitez ajouter n'est associé à aucun manga cocher cette case. <input id="noManga" type="checkbox" name="noManga" value="noManga" ></label>
				</div>
				<div id="manga">
				<div class="control-group">
				<label class="control-label" for="titre">Titre*</label><div class="controls"><input class="test nonNull" id="titre" name="titre" type="text" value="<?php if(isset($valide['titre'])) echo $valide['titre']; ?>" required="required"></div>
				<span class="help-block err"><?php if(isset($erreur['titre'])) echo $erreur['titre']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="titreAlt">Titre alternatif</label><div class="controls"><input id="titreAlt" name="titreAlt" type="text" value="<?php if(isset($valide['alt'])) echo $valide['alt']; ?>"></div>
				</div>
				<div class="control-group">
				<label class="control-label" for="genre">Genre*</label>
				<div class="controls"><select class="nonNull" id="genre" name="genre[]" multiple="multiple" required="required">
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
				<label class="control-label" for="parution">Année de parution*</label><div class="controls"><input required="required" class="test nonNull" id="parution" name="parution" type="text" value="<?php if(isset($valide['parution'])) echo $valide['parution']; ?>"></div>
				<span class="help-block err"><?php if(isset($erreur['parution'])) echo $erreur['parution']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="editeur">&Eacute;diteur d'origine*</label><div class="controls"><input class="nonNull" required="required" id="editeur" name="editeur" type="text" value="<?php if(isset($valide['editeur'])) echo $valide['editeur']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['editeur'])) echo $erreur['editeur']; ?></span>
				</div>
				<div class="control-group">
				<label class="control-label" for="lastChap">Dernier chapitre*</label><div class="controls"><input required="required" class="test nonNull" id="lastChap" name="lastChap" type="text" value="<?php if(isset($valide['lastChap'])) echo $valide['lastChap']; ?>"></div>
				<span class="help-block err"><?php if(isset($erreur['lastChap'])) echo $erreur['lastChap']; ?></span>
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
				<label class="control-label" for="couverture">Couverture*</label><div class="controls"><input required="required" class="nonNull" id="couverture" name="couverture" type="file" value="<?php if(isset($valide['couverture'])) echo $valide['couverture']; ?>"></div>
				<span class="help-block"><?php if(isset($erreur['couverture'])) echo $erreur['couverture'].'<br/>'; ?>(Extension Valide : jpg,jpeg,png,gif | Taille maximal : 1Mo)</span>
				</div>
				<div class="control-group">
				<label class="control-label" for="resume">Résumé*</label><div class="controls"><textarea class="nonNull" required="required" id="resume" name="resume"><?php if(isset($valide['resume'])) echo $valide['resume']; ?></textarea></div>
				<span class="help-block"><?php if(isset($erreur['resume'])) echo $erreur['resume']; ?></span>
				</div>
				</div>
				<input class="btn btn-success btn-block" id="next" type="submit" value="Suivant" name="suivant">
			</form>

