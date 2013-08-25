$(document).ready( function() {
	//formulaire d'anmie (validation)
	i=true;
	$("#fiche").hide();
	
    $("#noComp").click(
    function() {
    	if (i) { i=false; $("#versus").hide(); $("#fiche").show();}
    	else { i=true; $("#versus").show(); $("#fiche").hide();}
	}); 
});
