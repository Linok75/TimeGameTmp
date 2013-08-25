<?php
$rss = new DOMDocument();
$rss->preserveWhiteSpace = false;
$rss->load("http://www.mata-web.com/japon/index.php?option=com_jlord_rss&task=feed&id=2");

$elem = $rss->getElementsByTagName('item');
for ($i = 0; $i < $elem->length; $i++) {

    echo '<div class="container-fluid"><div class="contenu"><div class="well"><div class="row-fluid"><div class="page-header"><h4>' . $elem->item($i)->childNodes->item(0)->nodeValue . '</h4></div> ';
    echo '<div class="span8 offset2"><div>' . $elem->item($i)->childNodes->item(3)->nodeValue;
    echo '<a class="offset9" href="' . $elem->item($i)->childNodes->item(1)->nodeValue . '">en savoir plus...</a></div> ';
    echo '<img class="span6 offset2" src="' . $elem->item($i)->childNodes->item(6)->getAttribute('url') . '"/></div></div></div></div></div>';
}
?>