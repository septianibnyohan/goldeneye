<?php
require_once("__init.php");
require_once($__CFG_dir_class . "globalclassdata.php");
/*
$sys_menu->SetMenuID("");
$sys_menu->SetMenuHeadID("");

$auth->last_login();
$auth->logout();
*/
if ($_SESSION['userid']) {
	$query = new GCD("SELECT * from users WHERE hide=0 AND username = ".QuotedStringTrim($__VAR_username));
	//$users = $query->getSingleData("");
	$query->updateData("logged_in_user", array("is_login", "logout_date"), array(0, date("Y-m-d H:i:s")), "user_id = ".$_SESSION['userid']." And is_login = 1");
	session_destroy();
	header("location: " . $__CFG_http_apps . "login.php");
}
?>