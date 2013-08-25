<?php
if(isset($_POST['valeur'])){
	$valide=true;
	$diffusion=trim($_POST['valeur']);
	
	if($diffusion!=""){
		if(!preg_match("#^[0-9]+$#",$diffusion)){
			echo 'L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)';
		}else if(strlen($diffusion)!=4){
			echo 'L\' année de diffusion est composée de 4 chiffres ! (exemple : 2008)';
		}else{
			echo $valide;
		}
	}else{
		echo $valide;
	}
}
?>

