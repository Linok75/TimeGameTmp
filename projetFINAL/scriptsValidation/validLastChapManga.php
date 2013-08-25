<?php
if(isset($_POST['valeur'])){
	$valide=true;
	$lastChap=trim($_POST['valeur']);
	
	if($lastChap!=""){
		if(!preg_match("#^[0-9]+$#",$lastChap)){
			echo 'Le numéro du dernier chapitre est obligatoirement un nombre ! (exemple : 25)';
		}else{
			echo $valide;
		}
	}else{
		echo $valide;
	}
}
?>


