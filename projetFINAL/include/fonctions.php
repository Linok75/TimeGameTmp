<?php

function html($chaine) {
    $chainePropre = utf8_encode($chaine);
    $chainePropre = htmlspecialchars($chainePropre);
    return $chainePropre;
}

function bdSql($chaine) {
    $chainePropre = utf8_decode($chaine);
    return $chainePropre;
}

function generic_autoload($class) {
    require_once str_replace('_', '/', $class) . '.php';
}

?>
