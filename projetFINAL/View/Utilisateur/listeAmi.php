<?php if (isset($critere)) { ?><div class="page-header"><h1>Vous connaissez peut être ?</h1></div><?php } else { ?><div class="page-header"><h1>Votre liste d'ami</h1></div><?php } ?>

<?php
$ami=false;
for ($i = 0, $size = count($liste); $i < $size; $i++) {
    $pseudoAmi = html($liste[$i]['utilisateur'][0]['pseudo']);
    $avatar = $liste[$i]['profil'][0]['avatar'];
    $description = html($liste[$i]['profil'][0]['description']);
    if (empty($description)) {
        $description = '"NON RENSEIGNE"';
    }
    if ($pseudoAmi != $_SESSION['pseudo']) {
        $ami = true;


        echo '<div class="featurette container-fluid">
					<a href="index.php?module=Ami&action=pagePerso&pseudo=' . $pseudoAmi . '"><img class="featurette-image pull-left span2 offset1 img-polaroid" alt="' . $pseudoAmi . '" title="' . $pseudoAmi . '" src="avatar/' . $avatar . '"></a>';
					if (!isset($critere)) { echo '<a href="index.php?module=Ami&action=suppAmi&ami=' . $pseudoAmi . '"><i class="icon-remove pull-right"></i></a>'; }
					echo '<div class="offset4"><p class="lead">Pseudo: ' . $pseudoAmi . '</p>
						<p class="lead">Description: ' . $description . '</p>';
					if (!isset($critere)) {	echo '<a class="btn" href="index.php?module=Message&action=formMp&ami=' . $pseudoAmi . '"><i class="icon-envelope"></i> Envoyer un MP</a>'; }else{ echo '<a href="index.php?module=Ami&action=demandeAmi&ami='.$pseudoAmi.'" role="button" class="btn">Veut tu devenir mon ami ?</a>'; }
					echo '</div>
				</div>
				<hr class="featurette-divider">';
    }
}

if (!$ami) {
    echo '<span class="muted">personne...snif...</span>';
}
?>	
