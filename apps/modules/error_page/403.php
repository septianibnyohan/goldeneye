<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from themepixels.com/themes/demo/webpage/amanda/notfound.html by HTTrack Website Copier/3.x [XR&CO'2010], Mon, 17 Sep 2012 06:18:34 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>403 Forbidden Page</title>
<link rel="stylesheet" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/style.default.css" type="text/css" />
<script type="text/javascript" src="<?=$__CFG_http_js?>plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?=$__CFG_http_js?>plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?=$__CFG_http_js?>plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$__CFG_http_js?>custom/general.js"></script>
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body>

<div class="bodywrapper">
    <div class="topheader orangeborderbottom5">
        <div class="left">
            <h1 class="logo"><a href="<?=$__CFG_http_apps?>">AP<span>SIMA</span></a></h1>
            <span class="slogan">Sistem Informasi Manajemen</span>
			            
            <br clear="all" />
            
        </div><!--left-->
		
		<div class="right">
			<div class="topnav">
				<a class="logout" href="<?=$__CFG_http_apps?>logout.php"><span>Sign Out</span></a>
			</div>
		</div>
        
    </div><!--topheader-->
    
    
    <div class="contentwrapper padding10">
    	<div class="errorwrapper error403">
        	<div class="errorcontent">
                <h1>403 Forbidden Access</h1>
                <h3>Your dont' have permission to access this page.</h3>
                
                <p>This is likely to be caused by one of the following</p>
                <ul>
                    <li>The author of the page has intentionally limited access to it.</li>
                    <li>The computer on which the page is stored is unreachable.</li>
                    <li>You like this page.</li>
                </ul>
                <br />
                <button class="stdbtn btn_black" onclick="history.back()">Go Back to Previous Page</button> &nbsp; 
                <button onclick="location.href='<?=$__CFG_http_apps?>'" class="stdbtn btn_orange">Go Back to Index</button>
            </div><!--errorcontent-->
        </div><!--errorwrapper-->
    </div>   
    
    
</div><!--bodywrapper-->

</body>
</html>