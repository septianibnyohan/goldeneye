<?php
global $__not_show_all_footer;

if(!$__not_show_all_footer):
?>

					</div><!-- /CONTENT-->
				</div>
			</div>
		</div>
		<div class="footer-tools">
			<span class="go-top"><i class="fa fa-chevron-up"></i> Top</span>
		</div>
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY UI-->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/bootstrap-dist/js/bootstrap.min.js"></script>
	<!-- BOOTBOX -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/bootbox/bootbox.min.js"></script>
		
	<!-- DATE PICKER -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/picker.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datepicker/picker.time.js"></script>
	
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- BLOCK UI -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
	<!-- SPARKLINES -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/sparklines/jquery.sparkline.min.js"></script>
	
	<!-- EASY PIE CHART -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-easing/jquery.easing.min.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/easypiechart/jquery.easypiechart.min.js"></script>
	<!-- DATA TABLES -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/media/assets/js/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datatables/extras/TableTools/media/js/ZeroClipboard.min.js"></script>
	<!-- TODO -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jquery-todo/js/paddystodolist.js"></script>
	<!-- TIMEAGO -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/timeago/jquery.timeago.min.js"></script>
	<!-- FULL CALENDAR -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/fullcalendar/fullcalendar.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- GRITTER -->
	<script type="text/javascript" src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/gritter/js/jquery.gritter.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/script.js"></script>
	
	<script>
	jQuery(document).ready(function() {		
		//App.setPage("mom");  //Set current page
		//App.setPage("calendar");  //Set current page
		  //Set current page
		App.init(); //Initialise plugins and elements
		//Charts.initOtherCharts();
	});
	
	</script>
	
	<!-- /JAVASCRIPTS -->
</body>
</html>
<?php endif; ?>