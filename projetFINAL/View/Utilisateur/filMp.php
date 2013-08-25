<div class="page-header"><h1>Fil de discussion</h1></div>

<?php
	for ($i = 0, $size = count($liste); $i < $size; $i++) {						
		$pseudo=html($liste[$i]['utilisateur'][0]['pseudo']);
		$iduser=$liste[$i]['utilisateur'][0]['iduser'];									
		$avatar=$liste[$i]['profil'][0]['avatar'];
		$idmp=$liste[$i]['idmp'];
		$date=$liste[$i]['date'];
		$message=html($liste[$i]['message']);
		
		
?>
		<div class="featurette container-fluid">
			<a href="index.php?module=Ami&action=pagePerso&pseudo=<?php echo $pseudo; ?>"><img class="featurette-image pull-left span2 img-polaroid" src="avatar/<?php echo $avatar; ?>" height="100" width="100"></a>
			<a href="index.php?module=Message&action=suppUnMessage&mp=<?php echo $idmp; ?>"><i class="icon-remove pull-right"></i></a>
			<div class="offset2">
<?php 
				if($iduser!=$_SESSION['id']) {
					echo '<a class="btn" href="index.php?module=Message&action=formMp&ami='.$pseudo.'"><i class="icon-envelope"></i> Répondre</a>';
				}
?>
				<h3 class="featurette-heading">Message privé de <span class="muted"><?php echo $pseudo; ?></span></h3>
				<p><?php echo date("d/m/Y H:i:s",strtotime($date)); ?></p>
				<p class="lead" id="paragraphe"><?php echo $message; ?></p>
			</div>	
		</div>
		<hr class="featurette-divider">	
<?php								
	}
		
?>	
