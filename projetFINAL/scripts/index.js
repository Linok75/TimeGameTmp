$(document).ready( function() {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("rss").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","./include/rss.php",true);
    xmlhttp.send();
    
});
