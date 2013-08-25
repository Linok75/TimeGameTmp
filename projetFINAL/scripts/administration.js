$(document).ready( function() {
    i=true;
    $(".admin").hide();
    if($(".link:first").attr('id')=='SU'){
        $("#AU").show();
    }else{
        $("#AF").show();
    }
    
    
	
    $("#SU").click(
        function() {
            $(".admin").hide();
            $("#AU").show();
        }); 
        
    $("#SF").click(
        function() {
            $(".admin").hide();
            $("#AF").show();
        }); 
        
    $("#SA").click(
        function() {
            $(".admin").hide();
            $("#AA").show();
        }); 
        
    $("#SM").click(
        function() {
            $(".admin").hide();
            $("#AM").show();
        }); 
});
