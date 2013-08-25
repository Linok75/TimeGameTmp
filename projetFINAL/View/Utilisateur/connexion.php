<div class="page-header"><h1>Connexion</h1></div>

			<?php
				echo '<p>Echec de connexion !</p>';
			?>
					<form class="form-signin well" method="post" action="index.php?module=Utilisateur&action=connexion">
        					<input type="text" class="input-block-level" name="pseudo" placeholder="Pseudo">
        					<input type="password" class="input-block-level" name="mdp" placeholder="Mot de passe">
        					<button class="btn btn-large btn-primary" type="submit">Connexion</button>
      					</form>

