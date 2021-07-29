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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sewatama - CRM System</title>
	<link rel="shortcut icon" href="http://crispr.staging.integrasolusimandiri.com/assets/images/logo_sewatama.png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"
          integrity="sha512-0S+nbAYis87iX26mmj/+fWt1MmaKCv80H+Mbo+Ne7ES4I6rxswpfnC6PxmLiw33Ywj2ghbtTw0FkLbMWqh4F7Q=="
          crossorigin="anonymous"/>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css"
          integrity="sha512-rVZC4rf0Piwtw/LsgwXxKXzWq3L0P6atiQKBNuXYRbg2FoRbSTIY0k2DxuJcs7dk4e/ShtMzglHKBOJxW8EQyQ=="
          crossorigin="anonymous"/>

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
          crossorigin="anonymous"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page" style="background-image:url('http://crispr.staging.integrasolusimandiri.com/assets/images/bg.jpeg');background-size: cover;  background-repeat: no-repeat;">
<div class="login-box">

<style>
.login-logo, .register-logo {
    font-size: 1.6rem;
}
.input-login,.input-login:focus,.input-login:hover {
    background: transparent;
    border-left: none;
    border-right: none;
    border-top: none;
    border-radius:0;
    padding-left: 0px;
    color:white;
}
.input-group-text {
    border-left: none;
    border-right: none;
    border-top: none;	
    border-radius:0;
}
.input-login::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: white;
  opacity: 1; /* Firefox */
}

.input-login:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: white;
}

.input-login::-ms-input-placeholder { /* Microsoft Edge */
  color: white;
}
.login-card-body .input-group .input-group-text, .register-card-body .input-group .input-group-text {
    color: #e84f47;
    border-radius: 0px;
    padding-right: 2px;
}
input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  transform: scale(6);
  padding: 10px;
}

/* Might want to wrap a span around your checkbox text */
.checkboxtext
{
  /* Checkbox text */
  font-size: 110%;
  display: inline;
}
.input-login, .input-login:focus, .input-login:hover {
    font-size: 13.5px;
}
.login-box, .register-box {
    width: 420px;
}
.squaredThree label {
    cursor: pointer;
    position: absolute;
    width: 20px;
    height: 20px;
    top: 0;
    border-radius: 4px;
    -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
    background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
    background: -o-linear-gradient(top, #222 0%, #45484d 100%);
    background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
    background: linear-gradient(top, #222 0%, #45484d 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
}
.invalid-feedback {
	display: block;
    color: #ffdbdb;
    margin-bottom: 10px;
    font-size: 14px;
}

.content-divider {
    position: relative;
    z-index: 1;
}

.content-divider>span {
    background-color: #fff;
    background-color: #f5f5f5;
    display: inline-block;
}

.pl-2, .px-2 {
    padding-left: .625rem!important;
    padding-right: .625rem!important;
}

</style>

    <!-- /.login-box-body -->
    <div class="card"  style="background:transparent">
        <div class="card-body login-card-body" style="background:transparent;">
		<div style="position:absolute;width:100%;height:100%;    background: #2b2b2b;
    opacity: 0.6;z-index:-1;margin: -20px;border-radius:7px"></div>
			<div style="padding:40px">
				<!-- /.login-logo -->
				<img src="http://crispr.staging.integrasolusimandiri.com/assets/images/logo.png" alt="Sewatama Logo" title="Sewatama Logo" style="
				display:inline-block;
				margin: 12px auto 20px auto;
				width: 100%;"/>
				<div class="text-center" style="color:white;" href="http://crispr.staging.integrasolusimandiri.com/home"><b>CRISPR</b></div>
				<div class="login-logo">
					
				</div>
				
				<br/>
				<form role="form" method="post">
					<input type="hidden" name="_token" value="x3rKqWZIu3b7hLFXQpLqlnQmOMJkxWxl5F0AGZcr">										<div class="input-group mb-4">
						<input type="text"
							   name="username"
							   value=""
							   placeholder="Username"
							   required
							   class="input-login form-control ">
						<div class="input-group-append">
							<div class="input-group-text"><span class="fas fa-user"></span></div>
						</div>
											</div>

					<div class="input-group mb-2">
						<input type="password"
							   name="password"
							   placeholder="Password"
							   required
							   class="input-login form-control ">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-12">
							<a style="color: #fff;
									float: right;
									font-size: 13px;" class="pull-right" href="http://crispr.staging.integrasolusimandiri.com/password/reset">Forgot password?</a>
						</div>
						<br/><br/>
						

						
						<div class="col-8 mb-3">


							<!-- Squared THREE -->
							<div class="squaredThree">
								<input type="checkbox" value="None" id="squaredThree" name="check" />
								<label for="squaredThree"></label>
								
							</div>
							<span style="color:#fff;margin-left:10px;font-size:13.5px">Remember Me</span>
						</div>

						<div class="col-12" style="padding: 0 5px;">
							<button type="submit" class="btn btn-danger btn-block" style="background-color:#e84f47;">LOG IN</button>
						</div>
                        <div class="col-12 mt-3 mb-3">
                            <hr style="border-top: 1px solid #ffffff">
                        </div>
                        <div class="col-12">
                            <div class="form-group text-center content-divider">
                                
                                <a href="http://crispr.staging.integrasolusimandiri.com/create-lead" class="btn btn-sm btn-default" style="font-size: 13px;" >Create Lead</a>
                            </div>
                        </div>

					</div>
				</form>

				<p class="mb-1">
					
					
					
				</p>
							</div>
        </div>
        <!-- /.login-card-body -->
    </div>

</div>
<!-- /.login-box -->
<style>

input[type=checkbox] {
	visibility: hidden;
}

/* SQUARED THREE */
.squaredThree {
	display: inline-block;
}

.squaredThree label {
    cursor: pointer;
    position: absolute;
    width: 21px;
    height: 20px;
    top: 2px;
    left: 5px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,.4);
    background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
    background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
    background: -o-linear-gradient(top, #222 0%, #45484d 100%);
    background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
    background: linear-gradient(top, #222 0%, #45484d 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
}

.squaredThree label:after {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    opacity: 0;
    content: '';
    position: absolute;
    width: 12px;
    height: 7px;
    background: transparent;
    top: 4px;
    left: 4px;
    border: 3px solid #fcfff4;
    border-top: none;
    border-right: none;
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
}

.squaredThree label:hover::after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	filter: alpha(opacity=30);
	opacity: 0.3;
}

.squaredThree input[type=checkbox]:checked + label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	opacity: 1;
}

</style>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"
        integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA=="
        crossorigin="anonymous"></script>

</body>
</html>
