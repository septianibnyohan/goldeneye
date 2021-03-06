<?php
//header("location:index.php");
# include init function
global $db;
global $__CFG_dir_class;
global $__CFG_http_themes;
global $__CFG_app_themes;

//require_once("/__init.php");
require_once($__CFG_dir_class . "globalclassdata.php");

# Redirect to index page if user is logged in
$linknya = str_replace("/lisa/apps/","",$_SESSION['LINK']);	

if (isset($_SESSION['userid'])){
	/*
	if (isset($_SESSION['LINK']))
	{
		header("Location: ".$__CFG_http_apps.$_SESSION['LINK']);
		exit();
	}
	else 
	{
		header("Location: ".$__CFG_http_apps."index.php");
		exit();
	}
	*/
}

$__VAR_username = mysqli_real_escape_string($db->dbh, $_POST["username"]);
$__VAR_password = $_POST["password"];

$msg = "";
if(isset($__VAR_username) && isset($__VAR_password)) {
	$isError = false;
	if ( $__VAR_username == "" ) {
		$isError = true;
		$msg = "Username is required!";
	}
	if ( $__VAR_password == "" ) {
		$isError = true;
		$msg .= ($msg != "" ? "<br />" : "") . "Password is required!";
	}

	if ( !$isError ){
		//$query = new GCD("SELECT DATABASE()");
		//$users = $query->getSingleData("");

		//var_dump($users); die();

		$query = new GCD("SELECT a.*, b.levelName from employee a left join userlevel b on a.AksesLevel=b.levelId WHERE Username = ".QuotedStringTrim($__VAR_username));
		$users = $query->getSingleData("");
		//var_dump($users);die();
		//print_r($users);
		// jika user adalah outsourcing, maka tidak boleh mengakses aplikasi
		if ($users->levelName == "Outsourcing"){ // (lihat table userlevel)
			$isError = true;
			$msg = "You don't have authorization to this application!";
		}
		//
		if ($users->lockout){ // (lihat table userlevel)
			$isError = true;
			$msg = "Your account has been locked out. Please contact your administrator to clear status.";
		} 
		if ( !$isError ){
			// jika username benar, selanjutnya pengecekan password
			//echo sha1($__VAR_password); die();
			//echo $users->Password; die();
			if ( $users->Password != "" ) {
				if ($users->Password == sha1($__VAR_password)) {
					//echo $users->id.";". session_id().";". $_SERVER['REMOTE_ADDR'].";". "now()";
					$arrFields = array("user_id", "session_id", "host_ip", "login_date");
					$arrValues = array($users->EmpId, session_id(), $_SERVER['REMOTE_ADDR'], date("Y-m-d H:i:s"));

					$query->insertData("logged_in_user", $arrFields, $arrValues);
					//session_start();
					$_SESSION['userid'] = $users->EmpId;
					$_SESSION['name'] = $users->EmpName;
					$_SESSION['jobtitle'] = $users->jobtitle;
					$_SESSION['department'] = (int) $users->department;
					$_SESSION['divisi'] = (int) $users->division;
					$_SESSION['superior'] = $users->SuperiorId;
					$_SESSION['photo'] = $users->photo;
					$_SESSION['level'] = $users->AksesLevel;
					$_SESSION['levelname'] = $users->levelName;
					$_SESSION['akseslegal'] = $users->akseslegal;

				
					if (isset($_SESSION['LINK']))
									{
										
										header("Location: ".$__CFG_http_apps.$linknya);
										exit();
									}
									else 
									{	
										header("Location: ".$__CFG_http_apps."index.php");
										exit();
									}
									
					
				} else {
					$isError = true;
					$msg = "You have entered wrong Password!";
				}
					
			} else {
				$isError = true;
				$msg = "You have entered wrong Username!";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Aplikasi LISA | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/cloud-admin.css" >
	
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/uniform/css/uniform.default.min.css" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/animatecss/animate.min.css" />
	<!-- FONTS -->
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery/jquery-2.0.3.min.js" rel="stylesheet" type="text/css">
</head>
<body class="login">	
	<!-- PAGE -->
	<section id="page">
			<!-- HEADER -->
			<header>
				<!-- NAV-BAR -->
				<div class="container">
					<div class="row">
						<div id="logo">
								<img src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/mhu7.png" alt="MHU - PDCA ROBOT" />
													</div>
						<!-- <div class="col-md-4 col-md-offset-4">
							
						</div> -->
					</div>
				</div>
				<!--/NAV-BAR -->
			</header>
			<!--/HEADER -->
			<!-- LOGIN -->
			<section id="login_bg" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="login-box-transparent">
								<!--<a class="tip-right" title="Hello, I'am Pedro."><img alt="Pedro" src="<?php echo $__CFG_http_apps?>media/images/pedro.png" style=""></a>-->
							</div>
						</div>
						<div class="col-md-4">
							<div class="login-box">
								<?php if ($isError){?><div class="alert alert-danger">            
				            	<a class="close" aria-hidden="true" href="#" data-dismiss="alert">??</a>
				                    <?php echo $msg?> 
				                </div><?php }?>
								<h3 class="bigintro"><font color="white" size="20"><b>LISA</b></font></h3><h3 class="bigintro"><font color="white" size="4">(Legal Integrated System Application)</font></h3>
								<div class="divide-20"></div>
								<form role="form" method="post">
								  <div class="form-group">
									<label for="exampleInputEmail1">Nama Pengguna</label>
									<i class="fa fa-user"></i>
									<input type="text" name="username" class="form-control" />
								  </div>
								  <div class="form-group"> 
									<label for="exampleInputPassword1">Kata Sandi</label>
									<i class="fa fa-lock"></i>
									<input type="password" name="password" class="form-control" id="exampleInputPassword1" />
								  </div>
								  <div>
									<label class="checkbox"> <input type="checkbox" class="uniform" value=""> Ingat saya</label>
									<button type="submit" class="btn btn-danger">Masuk</button>
								  </div>
								</form>
								<div class="divide-10"></div>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('forgot');return false;">Lupa Kata Sandi?</a> 
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="login-box-transparent">
								<!--<a class="tip-left" title="Hello, I'am Carolin"><img alt="Caroline" src="<?php echo $__CFG_http_apps?>media/images/cyntia.png"></a>-->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- <section id="login" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="login-box-transparent">
								<a class="tip-right" title="Hello, I'am Pedro."><img alt="Pedro" src="<?php echo $__CFG_http_apps?>media/images/pedro.png" style=""></a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="login-box-plain">
								<?php if ($isError){?><div class="alert alert-danger">            
				            	<a class="close" aria-hidden="true" href="#" data-dismiss="alert">??</a>
				                    <?php echo $msg?> 
				                </div><?php }?>
								<h2 class="bigintro">PDCA ROBOT</h2>
								<div class="divide-20"></div>
								<form role="form" method="post">
								  <div class="form-group">
									<label for="exampleInputEmail1">Username</label>
									<i class="fa fa-user"></i><input type="text" name="username" class="form-control" />
								  </div>
								  <div class="form-group"> 
									<label for="exampleInputPassword1">Password</label>
									<i class="fa fa-lock"></i><input type="password" name="password" class="form-control" id="exampleInputPassword1" />
								  </div>
								  <div class="form-actions">
									<label class="checkbox"> <input type="checkbox" class="uniform" value=""> Remember me</label>
									<button type="submit" class="btn btn-danger">Submit</button>
								  </div>
								</form>
								<div class="divide-20"></div>
								<div class="center">
									<strong>Your Partner To Organize and Monitoring Your Activity</strong>
								</div>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('forgot');return false;">Forgot Password?</a> 
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="login-box-transparent">
								<a class="tip-left" title="Hello, I'am Carolin"><img alt="Carolin" src="<?php echo $__CFG_http_apps?>media/images/cyntia.png"></a>
							</div>
						</div>
					</div>
				</div>
			</section> -->
			<!--/LOGIN -->
			
			<!-- FORGOT PASSWORD -->
			<section id="forgot">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box">
								<h2 class="bigintro">Reset Password</h2>
								<div class="divide-40"></div>
								<form role="form">
								  <div class="form-group">
									<label for="exampleInputEmail1">Enter your Email address</label>
									<i class="fa fa-envelope"></i>
									<input type="email" class="form-control" id="exampleInputEmail1" >
								  </div>
								  <div>
									<button type="submit" class="btn btn-info">Send Me Reset Instructions</button>
								  </div>
								</form>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login_bg');return false;">Back to Login</a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- FORGOT PASSWORD -->
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
	<!-- VALIDATE -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-validate/jquery.validate.min.js"></script>
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-validate/additional-methods.min.js"></script>
	
	<!-- UNIFORM -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/uniform/jquery.uniform.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<script type="text/javascript">
		function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#'+id).addClass('visible animated fadeInUp');
		}
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>
