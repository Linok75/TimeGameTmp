$(document).ready( function() {
    //formulaire d'anmie (validation)
    i=true;
    $("#orderByAime").hide();
	
    $(".order").click(
        function() {
            if (i) {
                i=false;
                $("#orderByNote").hide();
                $("#orderByAime").show();
            }
            else {
                i=true;
                $("#orderByNote").show();
                $("#orderByAime").hide();
            }
        }); 
});
