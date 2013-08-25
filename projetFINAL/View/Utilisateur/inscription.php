<form class="form-signin well" method="post" action="index.php?module=Utilisateur&action=inscription">
	<input type="text" class="input-block-level" name="pseudo" placeholder="Pseudo">
	<input type="password" class="input-block-level" name="mdp" placeholder="Mot de passe">
	<input type="text" class="input-block-level" name="nom" placeholder="Nom">
	<input type="text" class="input-block-level" name="prenom" placeholder="Prénom">
	<input type="email" class="input-block-level" name="mail" placeholder="Adresse e-mail">

	<div class="control-group">
			<label class="control-label" >Date de naissance</label>
		<div class="controls">
			<?php
				echo '<select class="span1" name="jour">';
					for($i=1; $i<=31; $i++) {
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				echo '</select>';
			?>
				

			<?php
				echo '<select class="span1" name="mois">';
					for($i=1; $i<=12; $i++) {
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				echo '</select>';
			?>
				
			<?php
				echo '<select class="span1" name="annee">';
					for($i=(date('Y')-18); $i>=(date('Y')-99); $i--) {
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				echo '</select>';
			?>
		</div>			
	</div>
				
	<button class="btn btn-large btn-primary" type="submit">Inscription</button>
</div>
</form>
