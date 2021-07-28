<?php
# filename		: config.php
# author		: aris meika (aris.meika@gmail.com)
# website		: http://arisme.com
# remark		: parameter to configuration application

# DB Config
$__CFG_dbhost 			= "localhost"; 	# database host/server address
$__CFG_dbuser 			= "root"; 		# database username
$__CFG_dbpass 			= "";			# database password
$__CFG_dbname 			= "golden_eye";		# database name


# Define DB Connection Variable
define("DB_HOST", $__CFG_dbhost);
define("DB_USER", $__CFG_dbuser);
define("DB_PASS", $__CFG_dbpass);
define("DB_NAME", $__CFG_dbname);

# Define Path Config
define( "APP_PATH", "sepframework" ); # set path if your app is on your root web server
define( "BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/" . APP_PATH . ( APP_PATH=="" ? "" : "/" ) );
define( "BASE_DIR", $_SERVER["DOCUMENT_ROOT"] . "/" . APP_PATH . ( APP_PATH=="" ? "" : "/" ) );


# URL Path Config
$__CFG_http_lib 		= BASE_URL . "lib/";
$__CFG_http_js		 	= BASE_URL . "js/";
$__CFG_http_component 	= BASE_URL . "component/";
//$__CFG_http_apps 		= BASE_URL . "apps/";
$__CFG_http_apps 		= BASE_URL;
$__CFG_http_class 		= $__CFG_http_apps . "class/";
$__CFG_http_layout 		= $__CFG_http_apps . "layout/";
$__CFG_http_themes 		= $__CFG_http_apps . "themes/";
$__CFG_http_media 		= $__CFG_http_apps . "media/";

# Greybox URL Path
$__CFG_http_gb			= $__CFG_http_component . "greybox/";

# Dir Path Config
$__CFG_dir_lib 			= BASE_DIR . "lib/";
$__CFG_dir_js 			= BASE_DIR . "js/";
$__CFG_dir_component 	= BASE_DIR . "component/";
$__CFG_dir_apps 		= BASE_DIR . "apps/";
$__CFG_dir_class 		= $__CFG_dir_apps . "class/";
//$__CFG_dir_layout 		= $__CFG_dir_apps . "layout/";
$__CFG_dir_layout 		= BASE_DIR;
$__CFG_dir_themes 		= $__CFG_dir_apps . "themes/";
$__CFG_dir_media	  	= $__CFG_dir_apps . 'media/';

# Application Variable Config
$__CFG_page_count 		= 10; # page count per group will show
$__CFG_page_offset 		= 10; # datarow count per page
//$__CFG_app_layout 		= "pdca-02";
$__CFG_app_layout 		= "inc";
$__CFG_app_themes 		= "pdca-02";
?>
