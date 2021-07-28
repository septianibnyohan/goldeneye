<?php   
require_once($__CFG_dir_class . "globalclassdata.php"); 
$link= $__CFG_http_themes . $__CFG_app_themes; //echo $__CFG_http_themes . $__CFG_app_themes;//?>
<html lang="en">
    <head>
        <title>BERANDA</title>
		<meta charset="UTF-8" />
        <link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo $link?>/menu/css/style9.css" />
	
<link rel="stylesheet" type="text/css" href="<?php echo $link?>/css/cloud-admin.css" />
	 <link rel="stylesheet" type="text/css" href="<?php echo $link?>/menu/css/reset.css" /> 
	 <link rel="stylesheet" type="text/css" href="<?php echo $link?>/menu/css/websymbols/stylesheet.css" />
    </head>
    <body class="menuindex">
	
	<div id="logo" align="center">
								<img src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/mhu7.png" alt="MHU - PDCA ROBOT" />
													</div>
	
	 <span data-type="icon" class="sti-logo"></span>
		<div class="container">
		
		<br><br><br>
		
			<ul class="ca-menu">
                    <li>
                        <a href="<?php echo $__CFG_http_apps?>/index.php/home/index">
                            <span class="ca-icon">p</span>
                            <div class="ca-content">
                                <h2 class="ca-main"><font style="font-family: Arial Black; font-size: 19px;" ><b>BERANDA</b><font></h2>
                                <h3 class="ca-sub"><font style="font-family: Arial Black; font-size: 19px;" ><b>BERANDA</b><font></h3>
                            </div>
                        </a>                   
                    </li>
                    <li>
                        <a href="<?php echo $__CFG_http_apps?>/index.php/master/documentwizard/?idtype=1">
                            <span class="ca-icon">Z</span>
                            <div class="ca-content">
                                <h2 class="ca-main"><font style="font-family: Arial Black; font-size: 19px;" ><b>SURAT KUASA</b><font></h2>
                                <h3 class="ca-sub"><font style="font-family: Arial Black; font-size: 19px;" ><b>SURAT KUASA</b><font></h3>
                            </div>
                        </a>                   
                    </li>
                    <li>
                        <a href="<?php echo $__CFG_http_apps?>/index.php/master/documentwizard/?idtype=2">
                            <span class="ca-icon">24</span>
                            <div class="ca-content">
                                <h1 class="ca-main"><font style="font-family: Arial Black; font-size: 19px;" ><b>KORESPONDENSI</b><font></h1>
                                <h3 class="ca-sub"><font style="font-family: Arial Black; font-size: 19px;" ><b>KORESPONDENSI</b><font></h3>
                            </div>
                        </a>                    
                    </li>
                    <li>
                        <a href="<?php echo $__CFG_http_apps?>/index.php/master/documentwizard/?idtype=3">
                            <span class="ca-icon">F</span>
                            <div class="ca-content">
                                <h1 class="ca-main"><font style="font-family: Arial Black; font-size: 19px;" ><b>INSTRUMEN PERJANJIAN</b><font></h1>
                                <h3 class="ca-sub"><font style="font-family: Arial Black; font-size: 19px;" ><b>INSTRUMEN PERJANJIAN</b><font></h3>
                            </div>
                        </a>  
                    </li>
    </ul>
			
			
		</div>
		<script type="text/javascript" src="<?php echo $link?>/animated/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $link?>/animated/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo $link?>/animated/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="<?php echo $link?>/animated/js/jquery.iconmenu.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#sti-menu').iconmenu({
					animMouseenter	: {
						'mText' : {speed : 500, easing : 'easeOutExpo', delay : 200, dir : -1},
						'sText' : {speed : 500, easing : 'easeOutExpo', delay : 200, dir : -1},
						'icon'  : {speed : 700, easing : 'easeOutBounce', delay : 0, dir : 1}
					},
					animMouseleave	: {
						'mText' : {speed : 400, easing : 'easeInExpo', delay : 0, dir : -1},
						'sText' : {speed : 400, easing : 'easeInExpo', delay : 0, dir : 1},
						'icon'  : {speed : 400, easing : 'easeInExpo', delay : 0, dir : -1}
					}
				});
			});
		</script>
   