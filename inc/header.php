<?php
global $__page_title;
global $__CFG_dir_class;
global $db;
global $__CFG_http_themes;
global $__CFG_app_themes;
global $__CFG_http_apps;

if($__page_title=="") {
	$__page_title = "Selamat Datang di Aplikasi LISA";
}
//include page for GCD class
require_once($__CFG_dir_class . "globalclassdata.php");

//$SQL = mysql_query( "Select * from userlevel where levelId = ".$_SESSION['level']."");
//$hasil = mysql_fetch_array($SQL);
//$levelname = $hasil['levelName'];
$levelname = $_SESSION['levelname'];
$empid = $_SESSION['userid'];
$total = array();

//get parent menu navigation
//$sql = new GCD("select * from menu");
//$parents = $sql->listAllData("parentId = 0 order by ordering");

function IntervalDays($CheckIn,$CheckOut){
	$CheckInX = explode("-", $CheckIn);
	$CheckOutX =  explode("-", $CheckOut);
	$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
	$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
	$interval =($date2 - $date1)/(3600*24);

	// returns numberofdays
	return  $interval ;

}




//query untuk data employee
$qryEmp = new GCD("select * from employee");
// PDCA ==> department = 1 (mutlak sudah ditentukan)
$getPDCA = $qryEmp->listAllData("department = 1");

// generate alert for issue not yet to be project (issue reminder/IR)
$sqlfind = "select a.*,c.pdca_owner from mom_issue a join mom b on a.momid = b.id join meeting c on b.code=c.code Where a.id not in (select distinct issueid from projects) ";
$qryIR = new GCD($sqlfind);
$getIR = $qryIR->listAllData("");
//$hasilfind = mysql_query($sqlfind);

for ($i=0;$i<count($getIR);$i++) {
	$date1=$getIR[$i]->updated;
	$date2=date('Y-m-d H:m:s');
	$diff=IntervalDays($date1,$date2);
	//print_r($diff);
	if ($diff > 0){
		//jika user login adalah pic issue
		if ($getIR[$i]->pic == $_SESSION['userid']){
			$sqlCek = "Select * from zhistory where jenis = 'Issue Project' and substring(createddate,1,10) = '".date("Y-m-d")."' and projid = '".$getIR[$i]->id."' and empid = '".$getIR[$i]->pic."'";
			$qryCek = new GCD($sqlCek);
			$cekHistory = $qryCek->getSingleData("");
				
			if ($cekHistory->idhistory == "") {
				$qryCek->insertData("zhistory", array("jenis","projid","createddate","empid","createdby"), array('Issue Project', $getIR[$i]->id, date("Y-m-d H:i:s"), $getIR[$i]->pic, $getIR[$i]->pic));
			}
			
		}
		//generate notif if you are PDCA
		/*if ($getIR[$i]->pdca_owner == "1" && $_SESSION['department'] == 1) {
			$sqlCek = "Select * from zhistory where jenis = 'Issue Project' and substring(createddate,1,10) = '".date("Y-m-d")."' and projid = '".$getIR[$i]->id."' and empid = '".$_SESSION['userid']."'";
			$qryCek = new GCD($sqlCek);
			$cekHistory = $qryCek->getSingleData("");
			
			if ($cekHistory->idhistory == "") {
				$qryIR->insertData("zhistory", array("jenis","projid","createddate","empid","createdby"), array('Issue Project', $getIR[$i]->id, date("Y-m-d H:i:s"), $_SESSION['userid'], $getIR[$i]->pic));
			}
		}
		*/
		
	}
}
$q = "select akseslegal from employee where EmpId='".$_SESSION['userid']."' ";
				$hasil = mysqli_query($db->dbh, $q);
				$hasilx = mysqli_fetch_array($hasil);
				$akseslegal= $hasilx['akseslegal'];
				
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>LEGAL WORKFLOW Application | <?php echo $__html_title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />

		<!-- WEB FONTS : use %7C instead of | (pipe) -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/timeline/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/timeline/css/style.css"> <!-- Resource style -->
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/cloud-admin.css" >
	<link rel="stylesheet" type="text/css"  href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/themes/night.css" id="skin-switcher" >
	<link rel="stylesheet" type="text/css"  href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/responsive.css" >
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- JQUERY UI-->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.min.css" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/animatecss/animate.min.css" />
	<!-- GRITTER -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/gritter/css/jquery.gritter.css" />
	<!-- FONTS -->
	<link href='<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/css/font.css' rel='stylesheet' type='text/css'>
	<!-- FULL CALENDAR -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/fullcalendar/fullcalendar.min.css" />
	<!-- DATE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/themes/default.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/themes/default.date.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/themes/default.time.min.css" />
	<!-- DATA TABLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/media/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/media/assets/css/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/extras/TableTools/media/css/TableTools.min.css" />
  
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- FONTS -->
	<!-- JQUERY -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery/jquery-2.0.3.min.js"></script>
	<script type='text/javascript' src='<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery/jquery-migrate-1.2.1.min.js'></script>
	<!-- VALIDATE -->
	<link href='<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-validationEngine/css/validationEngine.jquery.css' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-validationEngine/jquery.validationEngine.js"></script>
	<script type='text/javascript' src='<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-validationEngine/languages/jquery.validationEngine-en.js'></script>
	<!-- SELECT2 -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/select2/select2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/select2/select2.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/uniform/css/uniform.default.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/bootstrap-wizard/wizard.css" />
	<!-- FLOT CHARTS -->
	<!-- FLOT CHARTS -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.min.js"></script>
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.time.min.js"></script>
    <script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.selection.min.js"></script>
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.resize.min.js"></script>
    <script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.pie.min.js"></script>
    <script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.stack.min.js"></script>
    <script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.crosshair.min.js"></script>
    <script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.tooltip.min.js"></script>
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/flot/jquery.flot.tooltip.min.js"></script>

	
		<!-- CKEDITOR -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/ckeditor/ckeditor.js"></script>
		
	
</head>
<body>
	<!-- HEADER -->
	<header class="navbar clearfix navbar-fixed-top" id="header">
		<div class="container">
				<div class="navbar-brand">
					<!-- COMPANY LOGO -->
					<a href="<?php echo $__CFG_http_apps ?>">
						<img src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/logo.png" alt="Cloud Admin Logo" class="img-responsive">
					</a>
					<!-- /COMPANY LOGO -->
					<!-- TEAM STATUS FOR MOBILE -->
					<div class="visible-xs">
						<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
							<i class="fa fa-users"></i>
						</a>
					</div>
					<!-- /TEAM STATUS FOR MOBILE -->
					<!-- SIDEBAR COLLAPSE -->
					<div id="sidebar-collapse" class="sidebar-collapse btn">
						<i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /SIDEBAR COLLAPSE -->
				</div>
				<!-- NAVBAR LEFT -->
				<ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
					<li class="dropdown">
						<a href='#' class="team-status-toggle dropdown-toggle tip-bottom" data-toggle="tooltip" title="Toggle Team View">
							<i class="fa fa-users"></i>
							<span class="name">Team Status</span>
							<i class="fa fa-angle-down"></i>
						</a>
					</li>
					<!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<span class="name">Skins</span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu skins">
							<li class="dropdown-title">
								<span><i class="fa fa-leaf"></i> Theme Skins</span>
							</li>
							<li><a href="#" data-skin="default">Subtle (default)</a></li>
							<li><a href="#" data-skin="night">Night</a></li>
							<li><a href="#" data-skin="earth">Earth</a></li>
							<li><a href="#" data-skin="utopia">Utopia</a></li>
							<li><a href="#" data-skin="nature">Nature</a></li>
							<li><a href="#" data-skin="graphite">Graphite</a></li>
						 </ul>
					</li> -->
				</ul>
				<!-- /NAVBAR LEFT -->
		
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<li class="dropdown" id="header-notification">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
							<?php if ($notif>0){  ?>
							<span class="badge"><?php echo $notif; ?></span>						
							<?php }?>
						</a>
						<ul class="dropdown-menu notification">
							<li class="dropdown-title">
								<span><i class="fa fa-bell"></i> <?php echo $notif; ?> Notifications</span>
							</li>
							
							
							
							<li class="footer">
								<a href="#">See all notifications <i class="fa fa-arrow-circle-right"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					
					
					
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user" id="header-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php $photo = $_SESSION['photo'] == "" ? "default.jpg" : $_SESSION['photo']?>
							<img alt="" src="<?php echo $__CFG_http_apps."media/profile/thumbnail/".$photo ?>" />
							<span class="username"><?php echo $_SESSION['name']?><?php //echo ' / '.$_SESSION['jobtitle'].' / '.$_SESSION['divisi'].' / '.$_SESSION['department']?></span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $__CFG_http_apps?>index.php/system/profile"><i class="fa fa-user"></i> My Profile</a></li>
							<li><a href="<?php echo $__CFG_http_apps?>home/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
		</div>
		<?php if ($_SESSION['jobtitle'] == "1"){ //jika jobtitle adalah BOD ?>
		<!-- DIV STATUS -->
		<div class="container team-status" id="team-status">
			<div id="scrollbar">
				<div class="handle"></div>
			</div>
			<div id="teamslider">
				<ul class="team-list">
					<?php
					//$where = $_SESSION['divisi'] == 0 ? "" : "WHERE divid = ". $_SESSION['divisi']." order by DepartmentName";
					//$query = new GCD("SELECT * FROM `department` $where");
					$query = new GCD("SELECT * FROM `divisi` order by divisiName");
					$getDiv = $query->listAllData("");
					
					for ($i=0;$i<count($getDiv);$i++){
			  		?>
					<li class="current">
						<a href="<?php echo $__CFG_http_apps."index.php/report/project?division=".$getDiv[$i]->divisiid ?>">
							<span class="image"> <img src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/avatars/avatar2.jpg" alt="" /></span> 
							<span class="title"> <?php echo $getDiv[$i]->divisiName; ?></span> 
							<?php
							$query2 = new GCD("Select realisasi,count(*) as total from `viewprojects` where hide=0 and divisi = ".$getDiv[$i]->divisiid." GROUP BY realisasi");
							$getProject = $query2->listAllData("");
							//set variable 0
							$finished = 0; $waiting = 0; $hold = 0; $planning = 0; $running = 0; $pending = 0;
							$suksespersen=0; $pendingpersen=0; $progresspersen=0; $waitingpersen=0; $holdpersen=0; $planningpersen=0;
							
							if (count($getProject) > 0) {
								$finished;
								foreach ($getProject as $r){
									if ($r->realisasi == 0) {
										$planning = $r->total;
									} elseif ($r->realisasi == 1) {
										$qry = new GCD("Select count(*) as total from `viewprojects` where realisasi=1 and EndDate < now() and hide=0 and divisi=".$getDiv[$i]->divisiid);
										$data = $qry->getSingleData("");
										$pending = $data->total;
										$running = $r->total - $pending;
									} elseif ($r->realisasi == 2) {
										$hold = $r->total;
									} elseif ($r->realisasi == 3) {
										$finished = $r->total;
									} elseif ($r->realisasi == 4) {
										$waiting = $r->total;
									}
								}
							}
							$total = $finished + $pending + $running + $waiting + $hold + $planning;
							
							if ($total != 0){
								$suksespersen = ($finished / $total) * 100;
								$pendingpersen = ($pending / $total) * 100;
								$progresspersen = ($running / $total) * 100;
								$waitingpersen = ($waiting / $total) * 100;
								$holdpersen = ($hold / $total) * 100;
								$planningpersen = ($planning / $total) * 100;
							}
							?>
							<div class="progress">
								<div class="progress-bar progress-bar-success" style="width: <?php echo $suksespersen?>%">
									<span class="sr-only"><?php echo $suksespersen?>% Finished (success)</span>
								</div>
								<div class="progress-bar progress-bar-primary" style="width: <?php echo $waitingpersen?>%">
									<span class="sr-only"><?php echo $waitingpersen?>% Waiting Confirm (yellow)</span>
								</div>
								<div class="progress-bar progress-bar-info" style="width: <?php echo $progresspersen?>%">
									<span class="sr-only"><?php echo $progresspersen?>% Running (warning)</span>
								</div>
								<div class="progress-bar progress-bar-danger" style="width: <?php echo $pendingpersen?>%">
									<span class="sr-only"><?php echo $pendingpersen?>% Running-Late (danger)</span>
								</div>
								<div class="progress-bar progress-bar-pink" style="width: <?php echo $planningpersen?>%">
									<span class="sr-only"><?php echo $planningpersen?>% Planning (pink)</span>
								</div>
								<div class="progress-bar progress-bar-dark" style="width: <?php echo $holdpersen?>%">
									<span class="sr-only"><?php echo $holdpersen?>% Hold (dark)</span>
								</div>
							</div> 
							<span class="status">
								<div class="field">
									<span class="badge badge-green"> <?php echo $finished ?></span> Finished <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-primary"> <?php echo $waiting ?></span> Waiting <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-blue"> <?php echo $running?></span> running <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-red"> <?php echo $pending?></span> running-late <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-pink"> <?php echo $planning?></span> Planning <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge"> <?php echo $hold ?></span> Hold <span class="pull-right fa fa-check"></span>
								</div>
							</span>
						</a>
					</li>
					<?php }	?>
				</ul>
			</div>
		</div>
		<!-- /DIV STATUS --><?php } ?>
		<?php if ($_SESSION['jobtitle'] == "2" || $_SESSION['jobtitle'] == "7"){ //jobtitle for Div Head atau Branch Coordinator ?>
		<!-- DEPT STATUS -->
		<div class="container team-status" id="team-status">
			<div id="scrollbar">
				<div class="handle"></div>
			</div>
			<div id="teamslider">
				<ul class="team-list">
					<?php
					$where = $_SESSION['divisi'] == 0 ? "" : "WHERE divid = ". $_SESSION['divisi']." order by DepartmentName";
					$query = new GCD("SELECT * FROM `department` $where");
					$getDept = $query->listAllData("");
					
					for ($i=0;$i<count($getDept);$i++){
			  		?>
					<li class="current">
						<a href="<?php echo $__CFG_http_apps."index.php/report/project?division=".$getDept[$i]->divid."&department=".$getDept[$i]->id ?>">
							<span class="image"> <img src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/img/avatars/avatar4.jpg" alt="" /></span> 
							<span class="title"> <?php echo $getDept[$i]->DepartmentName; ?></span> 
							<?php
							$query2 = new GCD("Select realisasi,count(*) as total from `viewprojects` where hide=0 and deptid = ".$getDept[$i]->id." GROUP BY realisasi");
							$getProject = $query2->listAllData("");
							//set variable 0
							$finished = 0; $waiting = 0; $hold = 0; $planning = 0; $running = 0; $pending = 0;
							$suksespersen=0; $pendingpersen=0; $progresspersen=0; $waitingpersen=0; $holdpersen=0; $planningpersen=0;
							
							if (count($getProject) > 0) {
								$finished;
								foreach ($getProject as $r){
									if ($r->realisasi == 0) {
										$planning = $r->total;
									} elseif ($r->realisasi == 1) {
										$qry = new GCD("Select count(*) as total from `viewprojects` where realisasi=1 and EndDate < now() and hide=0 and deptid=".$getDept[$i]->id);
										$data = $qry->getSingleData("");
										$pending = $data->total;
										$running = $r->total - $pending;
									} elseif ($r->realisasi == 2) {
										$hold = $r->total;
									} elseif ($r->realisasi == 3) {
										$finished = $r->total;
									} elseif ($r->realisasi == 4) {
										$waiting = $r->total;
									}
								}
							}
							$total = $finished + $pending + $running + $waiting + $hold + $planning;
							
							if ($total != 0){
								$suksespersen = ($finished / $total) * 100;
								$pendingpersen = ($pending / $total) * 100;
								$progresspersen = ($running / $total) * 100;
								$waitingpersen = ($waiting / $total) * 100;
								$holdpersen = ($hold / $total) * 100;
								$planningpersen = ($planning / $total) * 100;
							}
							?>
							<div class="progress">
								<div class="progress-bar progress-bar-success" style="width: <?php echo $suksespersen?>%">
									<span class="sr-only"><?php echo $suksespersen?>% Finished (success)</span>
								</div>
								<div class="progress-bar progress-bar-primary" style="width: <?php echo $waitingpersen?>%">
									<span class="sr-only"><?php echo $waitingpersen?>% Waiting Confirm (yellow)</span>
								</div>
								<div class="progress-bar progress-bar-info" style="width: <?php echo $progresspersen?>%">
									<span class="sr-only"><?php echo $progresspersen?>% Running (warning)</span>
								</div>
								<div class="progress-bar progress-bar-danger" style="width: <?php echo $pendingpersen?>%">
									<span class="sr-only"><?php echo $pendingpersen?>% Running-Late (danger)</span>
								</div>
								<div class="progress-bar progress-bar-pink" style="width: <?php echo $planningpersen?>%">
									<span class="sr-only"><?php echo $planningpersen?>% Planning (pink)</span>
								</div>
								<div class="progress-bar progress-bar-dark" style="width: <?php echo $holdpersen?>%">
									<span class="sr-only"><?php echo $holdpersen?>% Hold (dark)</span>
								</div>
							</div> 
							<span class="status">
								<div class="field">
									<span class="badge badge-green"> <?php echo $finished ?></span> Finished <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-primary"> <?php echo $waiting ?></span> Waiting <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-blue"> <?php echo $running?></span> running <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-red"> <?php echo $pending?></span> running-late <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-pink"> <?php echo $planning?></span> Planning <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge"> <?php echo $hold ?></span> Hold <span class="pull-right fa fa-check"></span>
								</div>
							</span>
						</a>
					</li>
					<?php }	?>
				</ul>
			</div>
		</div>
		<!-- /DEPT STATUS --><?php } ?>
		<?php if ($_SESSION['jobtitle'] == "3" || $_SESSION['jobtitle'] == "4"){ //jobtitle 3=dept head, 4=section head ?>
		<!-- TEAM STATUS -->
		<div class="container team-status" id="team-status">
			<div id="scrollbar">
				<div class="handle"></div>
			</div>
			<div id="teamslider">
				<ul class="team-list">
					<?php
					$where = $_SESSION['department'] == 0 ? "WHERE divid = ". $_SESSION['divisi'] : "WHERE department = ". $_SESSION['department'];
					$query = new GCD("SELECT * FROM `employee` $where order by jobtitle, EmpName");
					$getTeam = $query->listAllData("");
					
					for ($i=0;$i<count($getTeam);$i++){
						$avatar3 = $getTeam[$i]->photo == "" ? "default.jpg" : $getTeam[$i]->photo;
			  		?>
					<li class="current">
						<a href="<?php echo $__CFG_http_apps."index.php/report/project?division=".$getTeam[$i]->division."&department=".$getTeam[$i]->department."&pic=".$getTeam[$i]->EmpId ?>">
							<span class="image"> <img src="<?php echo $__CFG_http_apps."media/profile/thumbnail/".$avatar3 ?>" alt="" /></span> 
							<span class="title"> <?php echo $getTeam[$i]->EmpName; ?></span> 
							<?php
							//$query3 = new GCD("Select realisasi,EndDate,count(*) as total from `viewprojects` where hide=0 and projectChief = ".$getTeam[$i]->EmpId." GROUP BY realisasi,EndDate");
							$query3 = new GCD("Select realisasi,count(*) as total from `viewprojects` where hide=0 and projectChief = ".$getTeam[$i]->EmpId." GROUP BY realisasi");
							$getProject = $query3->listAllData("");
							$query4 = new GCD("Select count(*) as total from `viewprojects` where realisasi = 1 and EndDate >= now() and hide=0 and projectChief = ".$getTeam[$i]->EmpId);
							$getRun = $query4->getSingleData("");
							//set variable 0
							$finished = 0; $waiting = 0; $hold = 0; $planning = 0; $running = 0; $pending = 0;
							$suksespersen=0; $pendingpersen=0; $progresspersen=0; $waitingpersen=0; $holdpersen=0; $planningpersen=0;
							
							if (count($getProject) > 0) {
								$finished;
								foreach ($getProject as $r){
									if ($r->realisasi == 0) {
										$planning = $r->total;
									} elseif ($r->realisasi == 1) {
										$running = $getRun->total;
										//if ($r->EndDate < date("Y-m-d")) {
											$pending = $r->total - $running;
										//} else {
										//}
									} elseif ($r->realisasi == 2) {
										$hold = $r->total;
									} elseif ($r->realisasi == 3) {
										$finished = $r->total;
									} elseif ($r->realisasi == 4) {
										$waiting = $r->total;
									}
								}
							}
							$total = $finished + $pending + $running + $waiting + $hold + $planning;
							
							if ($total != 0){
								$suksespersen = ($finished / $total) * 100;
								$pendingpersen = ($pending / $total) * 100;
								$progresspersen = ($running / $total) * 100;
								$waitingpersen = ($waiting / $total) * 100;
								$holdpersen = ($hold / $total) * 100;
								$planningpersen = ($planning / $total) * 100;
							}
							?>
							<div class="progress">
								<div class="progress-bar progress-bar-success" style="width: <?php echo $suksespersen?>%">
									<span class="sr-only"><?php echo $suksespersen?>% Finished (success)</span>
								</div>
								<div class="progress-bar progress-bar-primary" style="width: <?php echo $waitingpersen?>%">
									<span class="sr-only"><?php echo $waitingpersen?>% Waiting Confirm (yellow)</span>
								</div>
								<div class="progress-bar progress-bar-info" style="width: <?php echo $progresspersen?>%">
									<span class="sr-only"><?php echo $progresspersen?>% Running (warning)</span>
								</div>
								<div class="progress-bar progress-bar-danger" style="width: <?php echo $pendingpersen?>%">
									<span class="sr-only"><?php echo $pendingpersen?>% Running-Late (danger)</span>
								</div>
								<div class="progress-bar progress-bar-pink" style="width: <?php echo $planningpersen?>%">
									<span class="sr-only"><?php echo $planningpersen?>% Planning (pink)</span>
								</div>
								<div class="progress-bar progress-bar-dark" style="width: <?php echo $holdpersen?>%">
									<span class="sr-only"><?php echo $holdpersen?>% Hold (dark)</span>
								</div>
							</div> 
							<span class="status">
								<div class="field">
									<span class="badge badge-green"> <?php echo $finished ?></span> Finished <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-primary"> <?php echo $waiting ?></span> Waiting <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-blue"> <?php echo $running?></span> running <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-red"> <?php echo $pending?></span> running-late <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge badge-pink"> <?php echo $planning?></span> Planning <span class="pull-right fa fa-check"></span>
								</div>
								<div class="field">
									<span class="badge"> <?php echo $hold ?></span> Hold <span class="pull-right fa fa-check"></span>
								</div>
							</span>
						</a>
					</li>
					<?php }	?>
				</ul>
			</div>
		</div>
		<!-- /TEAM STATUS --><?php } ?>
	</header>
	<!--/HEADER -->
    
    <!-- PAGE -->
	<section id="page">
				<!-- SIDEBAR -->
				<div id="sidebar" class="sidebar">
					<div class="sidebar-menu nav-collapse">
						<div class="divide-20"></div>
						<!-- SEARCH BAR
						<div id="search-bar">
							<input class="search" type="text" placeholder="Search"><i class="fa fa-search search-icon"></i>
						</div> -->
						<!-- /SEARCH BAR -->
						
						<!-- SIDEBAR QUICK-LAUNCH -->
						<!-- <div id="quicklaunch">-->
						<!-- /SIDEBAR QUICK-LAUNCH -->
						
						<!-- SIDEBAR MENU -->
						<ul>
							<!--
							<li<?php echo $pageActive == "beranda" ? ' class="active"' : ''?>>
								<a href="<?php echo $__CFG_http_apps ?>">
								<i class="fa fa-home fa-fw"></i> <span class="menu-text">Beranda</span>
								<span class="selected"></span>
								</a>					
							</li>
							-->
							<li<?php echo $pageActive == "beranda" ? ' class="active"' : ''?>>
								<a href="<?php echo $__CFG_http_apps ?>">
								<i class="fa fa-home fa-fw"></i> <span class="menu-text">Home</span>
								<span class="selected"></span>
								</a>					
							</li>
							
							<!--
							<li class="has-sub<?php echo $pageActive == "dokumen permohonan" ? ' active' : ''?>">
								<a href="javascript:;" class="">
								<i class="fa fa-th-large fa-fw"></i> <span class="menu-text">Permohonan</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
								<?php if ($akseslegal =="1"){?>
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/documentwizard/?idtype=1"><span class="icon-user"></span> Surat Kuasa</a></li>
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/documentwizard_offline/?idtype=3"><span class="icon-user"></span> Instrumen Perjanjian ( Offline )</a></li>

								<?php } ?>
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/documentwizard/?idtype=2"><span class="icon-user"></span> Korespondensi</a></li>
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/documentwizard/?idtype=3"><span class="icon-user"></span> Instrumen Perjanjian</a></li>
																	</ul>
							</li>
							-->
							<li class="has-sub<?php echo $pageActive == "dokumen permohonan" ? ' active' : ''?>">
								<a href="javascript:;" class="">
								<i class="fa fa-th-large fa-fw"></i> <span class="menu-text">Request for Review</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>request"><span class="icon-user"></span> Create New</a></li>
									<li<?php echo $pageCurrent == "mom" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>request/list"><span class="icon-user"></span> List of Request</a></li>
								</ul>
							</li>
							<li class="has-sub<?php echo $pageActive == "laporan2" ? ' active' : ''?>">
								<a href="javascript:;" class="">
								<i class="fa fa-file fa-fw"></i> <span class="menu-text">Approval</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li<?php echo $pageCurrent == "report2" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/report/reportdocument"><span class="icon-user"></span> Laporan Dokumen</a></li>
								</ul>
							</li>
							<?php if ($akseslegal =="1"){?>
							<li class="has-sub<?php echo $pageActive == "master" ? ' active' : ''?>">
								<a href="javascript:;" class="">
								<i class="fa fa-table fa-fw"></i> <span class="menu-text">Dokumen</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
								<li<?php echo $pageCurrent == "master" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/documentMHU"><span class="icon-user"></span> Dokumen MHU</a></li>

									<!--<li<?php echo $pageCurrent == "master" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/master/docMHU"><span class="icon-user"></span> Drafter</a></li>-->
									
								</ul>
							</li>
							
							
	

							 <li class="has-sub<?php echo $pageActive == "laporan" ? ' active' : ''?>">
								<a href="javascript:;" class="">
								<i class="fa fa-file-text fa-fw"></i> <span class="menu-text">Laporan</span>
								<span class="arrow"></span>
								</a>
								<ul class="sub">
									<li<?php echo $pageCurrent == "report" ? ' class="active"' : ''?>><a class="" href="<?php echo $__CFG_http_apps?>index.php/report/reportdocument"><span class="icon-user"></span> Laporan Dokumen</a></li>
								</ul>
							</li>
							<?php } ?>
						</ul>
						<!-- /SIDEBAR MENU -->
					</div>
				</div>
				<!-- /SIDEBAR -->
		<div id="main-content" class="margin-top-50">
			<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<!-- STYLER -->
									
									<!-- /STYLER -->
									<!-- BREADCRUMBS -->
									<ul class="breadcrumb">
										<li>
											<i class="fa fa-home"></i>
											<a href="<?php echo $__CFG_http_apps ?>">Home</a>
										</li>
										<?php echo $__navigation?>
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="clearfix">
										<h3 class="content-title pull-left"><?php echo $__page_title?></h3>
									</div>
									<!-- <div class="description">Overview, Statistics and more</div> -->
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						
						