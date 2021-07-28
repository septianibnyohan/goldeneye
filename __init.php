<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Jakarta');
session_start();

# init config dir
$__array_dir_apps = explode("/", $_SERVER["REQUEST_URI"]);
$__dir_path = $__array_dir_apps[1];
$__dir_config = $_SERVER["DOCUMENT_ROOT"] . "/" . ( $__dir_path == "" ? "" : $__dir_path . "/" );

# include config file
require_once($__dir_config . "config.php");
require_once($__CFG_dir_lib . "loadpages.php");
require_once($__CFG_dir_lib . "function.php");
require_once($__CFG_dir_lib . "mydbi.php");

# init database
$db = new MyDBI();
$db->hostname = $__CFG_dbhost;
$db->username = $__CFG_dbuser;
$db->password = $__CFG_dbpass;
$db->dbname = $__CFG_dbname;
$db->connect($__CFG_dbname);

# init loading pages
$load = new LoadPages($_SERVER['PATH_INFO']);

//$_SESSION["LINK"] = $_SERVER['PATH_INFO'];
# init sites id
// if($_GET["siteid"]!="")
	// $_SESSION["SITE_ID"] = $_GET["siteid"];

# init page and mode
$__var_page = "home";
$__var_mode = "index";

# get page and mode if not blank
if( $load->get_page() != "" ) $__var_page = $load->get_page();
// if( $load->get_mode() != "" && $_SESSION["SITE_ID"] != "" ) $__var_mode = $load->get_mode();
if( $load->get_mode() != "" ) $__var_mode = $load->get_mode();

# get code, page redirection and page address
$__var_code = $load->get_code();
$__var_pageredir = $__CFG_http_apps . "index.php/" . $__var_page . "/" . $__var_mode . "/";
$__var_pageaddr = $__CFG_dir_apps . "modules/" . $__var_page . "/" . $__var_mode . ".php";

if($kode=="") $kode = $__var_code;

# check if error internal server
if(count(error_get_last()) < 0) {
	$__var_errortype = "500";
	$__var_pageaddr = $__CFG_dir_apps . "modules/error_page/". $__var_errortype .".php";
	$_SESSION["SITE_ID"] = null;
}

# check if file is not exist
if(!file_exists($__var_pageaddr)) {
	echo "error file : ".$__var_pageaddr; die();
  $__var_errortype = "404";
  $__var_pageaddr = $__CFG_dir_apps . "modules/error_page/". $__var_errortype .".php";
}

# check if logged in
// if ( !$__is_logged )
// {
	// if ( $__VAR_page != "signin" )
	// {
		// require_once("login.php");
		// exit;
	// }
// }
?>