<?php
if(isset($_POST['valeur'])){
	$valide=true;
	$lastEp=trim($_POST['valeur']);
	
	if($lastEp!=""){
		if(!preg_match("#^[0-9]+$#",$lastEp)){
			echo 'Le numéro du dernier épisode est obligatoirement un nombre ! (exemple : 25)';
		}else{
			echo $valide;
		}
	}else{
		echo $valide;
	}
}
?>



