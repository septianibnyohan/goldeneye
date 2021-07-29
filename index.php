<?php
session_start();

require_once("__init.php");
require_once($__CFG_dir_class . "globalclassdata.php");

spl_autoload_register(function($class){
	include_once "system/libs/".$class.".php";
});

/*
include_once "system/libs/Main.php";
include_once "system/libs/DController.php";
include_once "system/libs/DModel.php";
include_once "system/libs/Database.php";
include_once "system/libs/Load.php";
*/


//echo $_SESSION['userid'];
$url = isset($_GET['url']) ? $_GET['url'] : NULL;
if ($url != NULL){
	$url = rtrim($url, '/');
	$url = explode("/", filter_var($url, FILTER_SANITIZE_URL));
} else {
	//$url[0] = "Home";
	//$url[1] = "index";
}

if (isset($url[0])) {
	include 'app/controllers/'.$url[0].'.php';
	$ctlr = new $url[0]();
	if (isset($url[2])) {
		$ctlr->$url[1]($url[2]);
	} else {
		if (isset($url[1])) {
			$method = $url[1];
			$ctlr->$method();
			//$ctlr->url[1]();
		} else {
			$ctlr->index();
		}
	}
	
} else {
	include 'app/controllers/Home.php';
	$ctrl = new Home();
	$ctrl->index();
}


?>