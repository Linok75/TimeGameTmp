<div class="page-header"><h1>Profil</h1></div>

			<?php
				echo 	'<div class="featurette container-fluid offset1">
							<h3 class="featurette-heading">Informations personnelles</span></h3>
							<p class="lead">Civilite: '.$civilite.'</p>
							<p class="lead">Nom: '.html($utilisateur[0]['nom']).'</p>
							<p class="lead">Prenom: '.html($utilisateur[0]['prenom']).'</p>
							<p class="lead">Date de naissance: '.date("d/m/Y",strtotime($utilisateur[0]['datenaiss'])).'</p>
							<p class="lead">E-mail: '.html($utilisateur[0]['mail']).'</p>
							<h3 class="featurette-heading">Informations publique</span></h3>
							<p class="lead">Description: '.html($profil[0]['description']).'</p>
							<p class="lead">Anime favoris: '.html($anime[0]['titre']).'</p>
							<p class="lead">Mangas favoris: '.html($manga[0]['titre']).'</p>
							<p class="lead">Genre favoris: '.html($genre[0]['genre']).'</p>
							<h3 class="featurette-heading">Compte</span></h3>
							<p class="lead">Type de compte: '.html($type[0]['type']).'</p>
							<p class="lead">Date d\'inscription: '.date("d/m/Y H:i:s",strtotime($profil[0]['dateinscri'])).'</p>
							<p class="lead">Derniere connexion: '.date("d/m/Y H:i:s",strtotime($profil[0]['datelastco'])).'</p>
						</div>
						<hr class="featurette-divider">';

				echo '<a href="#profil" role="button" class="btn" data-toggle="modal"><i class="icon-user"></i> Editer profil</a>';


				//COMMENTAIRE
    			//require_once 'editerProfil.php';	
			?>

			<!-- FAIRE UN MODAL POUR L'EDITION DE PROFIL -->
			<!-- POPUP (MODAL) CHANGEMENT AVATAR-->
		    <div class="modal hide" id="profil">
		        <div class="modal-header"> <a class="close" data-dismiss="modal">×</a><h2>Gestion de Profil</h2></div>
		        <div class="modal-body">
		          	<div class="formulaire container-fluid">
			        <?php
			        	//GESTION PROFIL
    					require 'View/Profil/gestionProfil.php';
			        ?>	
		         	</div>
		        </div>
		        <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
		    </div>
