<?php 
$__not_show_all_footer = true;
$__not_show_timer = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>PDCA Project System | Error 404</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/cloud-admin.css" >
	<link rel="stylesheet" type="text/css"  href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/responsive.css" >
	
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/font.css' rel='stylesheet' type='text/css'>
</head>
<body>	
	<!-- PAGE -->
	<section id="page">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="divide-100"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 not-found text-center">
				   <div class="error">
					  404
				   </div>
				</div>
				<div class="col-md-4 col-md-offset-4 not-found text-center">
				   <div class="content">
					  <h3>Page not Found</h3>
					  <p>
						 Sorry, but the page you're looking for has not been found<br />
					  </p>
					  <div class="btn-group">
						<a href="javascript:history.back()" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Go Back</a>
						<a href="<?php echo $__CFG_http_apps?>" class="btn btn-default">Dashboard</a>
					  </div>
				   </div>
				</div>
			</div>
		</div>
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/bootstrap-dist/js/bootstrap.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("widgets_box");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>