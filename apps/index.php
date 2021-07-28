<?php
global $custom_footer, $__not_show_timer;
ini_set('display_error', 1);
# include init function
require_once("__init.php");
# Redirect to login page if user is not logged in

if (!isset($_SESSION['userid'])){
	$_SESSION['LINK'] = $_SERVER['REQUEST_URI'];
	header("location:".$__CFG_http_apps."login.php");
	exit();
}

list($usec, $sec) = explode(" ", microtime());
$time_start = (float)$usec + (float)$sec;

# include pages
require_once($__var_pageaddr);

list($usec, $sec) = explode(" ", microtime());
$time_end = (float)$usec + (float)$sec;

$__var_time = $time_end - $time_start;

$__var_timer = "";
if(!$__not_show_timer)
	$__var_timer = "<div style=\"position: absolute; bottom: 0; left: 0; width=100%; font-family: arial; font-size: 10px; color: #c5c5c5; text-align: center; border-top: 1px solid #cecece; padding-top: 5px;\">This page loaded in ". $__var_time ." seconds</div>";
	
if(!$custom_footer) 
	//require_once($__CFG_dir_layout . $__CFG_app_layout . "/footer.php");
	require_once(BASE_DIR."/inc/footer.php");
?>