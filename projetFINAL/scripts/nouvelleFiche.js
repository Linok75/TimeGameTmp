 $(document).ready( function() {
	//formulaire de manga (validation)
	i=true;
    $("#noManga").click(
    function() {
    	if (i) { i=false; $("#manga").hide(); setRequire(); $("#next").removeAttr("disabled");}
    	else { i=true; $("#manga").show(); setRequire(); verif();}
	}); 
	
	function setRequire(){
		$(".nonNull").each(
			function(){
				if($(this).attr("required")){
					$(this).removeAttr("required");
				}else{
					$(this).attr("required","required");
				}
			});
	}
	
	function verif(){
			$(".err").each(
				function(){
					if(($.trim($(this).html()))!=""){
						$("#next").attr("disabled","disabled");
						return false;
					}else{
						$("#next").removeAttr("disabled");
					}
			});
	}
	
	$(".test").blur(function(){
		var name=($(this).attr("name"));
		var value=($(this).attr("value"));
		var url = "";
	
	
		if(name=="titre"){
			url="./scriptsValidation/validTitreManga.php";
		}

		if(name=="parution"){
			url="./scriptsValidation/validParutionManga.php";
		}
		
		if(name=="lastChap"){
			url="./scriptsValidation/validLastChapManga.php";
		}
		

		if(url!=""){
			$.ajax({
					type: "POST",
					url: url,
					data: { valeur: value }
				}).done(function( msg ) {
					if(msg!=true){
						$("label[for="+name+"] ~ span").html(msg);
						$("label[for="+name+"] ~ span").css({color: '#B9121B'});
						$("#next").attr("disabled","disabled");
					}else{
						$("label[for="+name+"] ~ span").empty();
						verif();
					}
			});
		}
	});

});
