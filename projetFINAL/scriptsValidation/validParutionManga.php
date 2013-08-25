<?php
if(isset($_POST['valeur'])){
	$valide=true;
	$parution=trim($_POST['valeur']);
	
	if($parution!=""){
		if(!preg_match("#^[0-9]+$#",$parution)){
			echo 'L\' année de parution est composée de 4 chiffres ! (exemple : 2008)';
		}else if(strlen($parution)!=4){
			echo 'L\' année de parution est composée de 4 chiffres ! (exemple : 2008)';
		}else{
			echo $valide;
		}
	}else{
		echo $valide;
	}
}
?>

