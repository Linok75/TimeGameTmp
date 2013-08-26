<?php
function generic_autoload($class) {
    require_once str_replace('_', '/', $class) . '.php';
}
?>
