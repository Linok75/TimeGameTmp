<div class="page-header"><h1>Page de <?php echo strtoupper(html($pseudo)); ?></h1></div>

<?php

    echo 	'<div class="featurette container-fluid">
             	<img class="featurette-image pull-left span3 img-polaroid" src="avatar/'.$avatar.'">
				<h3 class="featurette-heading offset3">- Voici la page de '.strtoupper(html($pseudo)).' -</h3>
				<p class="lead offset3">Son statut: '.html($statut).'</p>
				<p class="lead offset3">Sa description: '.html($description).'</p>
				<p class="lead offset3 paragraphe">Son anime favoris est: '.html($titreAnime).'</p>
				<p class="lead offset3 paragraphe">Son mangas favoris est: '.html($titreManga).'</p>
				<p class="lead offset3 paragraphe">Son genre favoris est: '.html($titreGenre).'</p>
			</div>
			<hr class="featurette-divider">';

			echo '<p class="lead offset1">Ses amis sont ';
			$etreAmi=false;
			for ($i = 0, $size = count($liste); $i < $size; $i++) {
				$pseudoAmi=html($liste[$i]['utilisateur'][0]['pseudo']);								
				$avatar=$liste[$i]['profil'][0]['avatar'];

				if($pseudoAmi==$_SESSION['pseudo']) {
					$etreAmi=true;
				}

				echo 	'&nbsp;<a href="index.php?module=Ami&action=pagePerso&pseudo='.$pseudoAmi.'"><img class="featurette-image img-polaroid" alt="'.$pseudoAmi.'" title="'.$pseudoAmi.'" src="avatar/'.$avatar.'" height="50" width="50"></a>&nbsp;';
				//$affichage++;
			}

			if($i==0) {
				echo ': <span class="muted">Ah bah il en a pas !</span>';
			}
			echo '</p><hr class="featurette-divider">';	
						

			if(html($pseudo)!==$_SESSION['pseudo'] AND $etreAmi==false) {
				echo '<a href="index.php?module=Ami&action=demandeAmi&ami='.html($pseudo).'" role="button" class="btn">Veut tu devenir mon ami ?</a>';
			} 

			if($etreAmi==true) {
				echo '<a href="index.php?module=Ami&action=suppAmi&ami='.html($pseudo).'" role="button" class="btn">Veut tu annuler notre amitié ?</a>';
			} 				

?>	