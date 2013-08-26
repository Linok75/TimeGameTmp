<?php
define("PROD_ROOT", dirname(dirname(__FILE__)));
define("PROD_ROOT_LONG", dirname(dirname(__FILE__)));

define("ROOT", PROD_ROOT);
define("ROOT_URL", ROOT . 'index.php');
define("ROOT_LONG", PROD_ROOT_LONG);
set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_LONG);

require 'Include/InfosDb.php';
require 'Include/Function.php';

spl_autoload_register('generic_autoload');

Controller_Template::$db = new MyPDO('mysql:host=localhost;dbname='.$dbname, $login, $pass);

session_start();

if(!empty($_SESSION)){

}else{

}
?>
