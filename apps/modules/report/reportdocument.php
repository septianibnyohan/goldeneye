<?php
$__page_title = "Laporan Dokumen";
$__html_title = $__page_title;
$pageActive = "laporan";

$__navigation = '<li><a href="#">Laporan</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';

# include header file
require_once($__CFG_dir_layout . $__CFG_app_layout."/header.php");





 $fromdate = mysqli_real_escape_string($db->dbh,$_REQUEST['fromdate']);
 $todate = mysqli_real_escape_string($db->dbh,$_REQUEST['todate']);
 $status = mysqli_real_escape_string($db->dbh,$_REQUEST['status']);
 $idtypedoc = mysqli_real_escape_string($db->dbh,$_REQUEST['idtypedoc']);



//echo $prid;
$q = "select description from legal_typedocument where idtypedoc='".$idtypedoc."' ";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$description= $hasilx['description'];


?>

<script type="text/javascript">
$(document).ready(function() {

	$("#createduser").val('<?php echo $_SESSION['userid']?>');	
	$("#namalengkap").val('<?php echo $_SESSION['name']?>');
	$("#createduser").attr('readonly', true);
	$("#namalengkap").attr('readonly', true);


})


</script>	
 <!-- export to excel-->
  <script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
 <!------------------------------------------------------------------------------->

<div class="row">
	<div class="col-md-12">
		<div class="box border inverse">
			<div class="box-title">
				<h4>
					<i class="fa fa-list-alt"></i> <span class="hidden-inline-mobile"><?php echo $description?></span>
				</h4>
				<div class="tools">
					
						
					
				</div>
			</div>
			<div class="box-body" style="overflow-x:auto;">
			<div align="right"><button  onclick="tableToExcel('momTable', 'export excel')" class="btn-gold"><font color="#000"><b>EXCEL</b></font></button></div>
			<form id="finput" role="form" action="<?php echo $__CFG_http_apps?>index.php/report/reportdocument" method="post" class="form-horizontal">
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Created Date<span class="required">*</span></label>
						 <div class="col-md-2">
						<input type="text" name="fromdate"  id="fromdate" value="<?php echo $fromdate?>" class="form-control input-sm datepicker validate[required]" />

						 <span class="error-span"></span>
					</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">To Date<span class="required">*</span></label>
						 <div class="col-md-2">
						<input type="text" name="todate"  id="todate" value="<?php echo $todate?>"  class="form-control input-sm datepicker validate[required]" />

						 <span class="error-span"></span>
					</div>
				</div>
				<div class="form-group">
						<label class="col-sm-2 control-label">Tipe Dokumen<span class="required">*</span></label>
						 <div class="col-md-2">
						 <select  id="idtypedoc" name="idtypedoc" value="<?php  echo $idtypedoc?>" class="form-control input-sm validate[required]" />
							<option selected="selected" value=""></option>
							
							<option  value="1"<?php echo $idtypedoc == "1" ? " selected" : ""?>>Surat Kuasa</option>
							<option  value="4"<?php echo $idtypedoc == "4" ? " selected" : ""?>>Surat Tugas</option>
							<option  value="2"<?php echo $idtypedoc == "2" ? " selected" : ""?>>Korespondensi</option>	
							<option  value="3"<?php echo $idtypedoc == "3" ? " selected" : ""?>>Instrumen Perjanjian</option>								
									
							</select>
					</div>
				</div>
				<div class="form-group">
						<label class="col-sm-2 control-label">Status<span class="required">*</span></label>
						 <div class="col-md-2">
						 <select  id="status" name="status" value="<?php  echo $status?>" class="form-control input-sm validate[required]" />
							<option selected="selected" value=""></option>
							<option  value="All"<?php echo $status == "All" ? " selected" : ""?>>All</option>
							<option  value="1"<?php echo $status == "1" ? " selected" : ""?>>On Progress</option>
							<option  value="3"<?php echo $status == "3" ? " selected" : ""?>>Done</option>
							<option  value="2"<?php echo $status == "2" ? " selected" : ""?>>Rejected</option>
															
									
							</select>
					</div>
				</div>
				
				
				
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<button type="submit" id="submit" class="btn btn-primary">Filter</button>
							<button type="button" id="clear" class="btn btn-danger" onclick="window.location='<?php echo $__CFG_http_apps?>index.php/report/reportdocument'">Clear Filter</button>
						</div>
					</div>
				</form>
			<div id="tableexport">
				
				<table id="momTable" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
					<thead>
						<?php if ($idtypedoc==3){?>
					
						<tr>
						<th width="2%">No</th>
						<th width="15%">Lihat Detail</th>
						<th width="15%">Dokumen</th>
						
						
						<th width="25%">Rekanan</th>
						<th width="25%">Nama Perusahaan</th>
						<th width="25%">Status Dokumen</th>
						<th width="35%">Nama Perjanjian</th>
						<th width="35%">Tanggal Perjanjian</th>
						<th width="35%">Nomor Perjanjian</th>
						<th width="35%">Diperiksa oleh Department/Division/Management terkait </th>
						<th width="25%">Dokumen oleh Department/Division/Management terkait</th>
						<th width="15%">Mata Uang</th>
						<th width="15%">Harga Pekerjaan</th>
						<th width="15%">Tanggal Finalisasi</th>
						<th width="25%">Jangka Waktu</th>
						<th width="25%">Tanggal Mulai</th>
						<th width="25%">Tanggal Kedaluwarsa</th>
						<th width="15%">Status</th>
						<th width="25%">Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen </th>
						<th width="15%">Dokumen pendukung </th>
						<th width="25%">Dikonfirmasi oleh</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Pengecekan Doc.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Penunjukan Drafter</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
							<th width="10%">Dokumen oleh Drafter </th>
							<th width="25%">Diperiksa oleh Legal Counsel.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diperiksa oleh SM CLC</th>
						<th width="15%">Tanggal</th>
							<th width="25%">Diperiksa oleh Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen oleh Pemohon </th>
						<th width="25%">Diperiksa oleh Atasan Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Diperiksa oleh Drafter </th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen untuk Pemohon </th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Initial User </th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen Final</th>
						</tr>
					
					<?php } else if ($idtypedoc==2) {?>
						<tr>
						<th width="2%">No</th>
						<th width="15%">Lihat Detail</th>
						<th width="15%">Dokumen</th>
						
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penandatangan </th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
						
						<th width="35%">Perihal</th>
						<th width="35%">Diperiksa oleh Department/Division/Management terkait </th>
						<th width="25%">Dokumen oleh Department/Division/Management terkait</th>
						<th width="15%">Status</th>
						<th width="25%">Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen </th>
						<th width="15%">Dokumen pendukung </th>
						<th width="25%">Dikonfirmasi oleh</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Pengecekan Doc.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Penunjukan Drafter</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen oleh Drafter </th>
						<th width="25%">Diperiksa oleh Legal Counsel.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diperiksa oleh SM CLC</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diperiksa oleh Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen oleh Pemohon </th>
						<th width="25%">Diperiksa oleh Atasan Pemohon</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Diperiksa oleh Drafter</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen untuk Pemohon </th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen Final</th>
						</tr>
						<?php } else {?>
						<tr>
						<th width="2%">No</th>
						<th width="15%">Lihat Detail</th>
						<th width="15%">Dokumen</th>
					
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penerima Kuasa</th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
					
						<th width="35%">Perihal</th>
					<th width="15%">Status</th>
					<th width="25%">Pemohon</th>
						<th width="15%">Tanggal</th>
					<th width="15%">Dokumen </th>
						<th width="15%">Dokumen pendukung </th>
						
						<th width="25%">Pengecekan Doc.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Penunjukan Drafter</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen oleh Drafter </th>
						<th width="25%">Diperiksa oleh Legal Counsel.</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diperiksa oleh SM CLC</th>
						<th width="15%">Tanggal</th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="15%">Dokumen untuk Pemohon </th>
						<th width="25%">Diinput oleh</th>
						<th width="15%">Tanggal</th>
						<th width="10%">Dokumen Final</th>
						</tr>
						<?php }?>
						
					</thead>
						
					<tbody>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="wForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<form id="finput" role="form" action="<?=$__CFG_http_apps?>index.php/data/reportheader/" method="post">
				<input type="hidden" id="kode" name="kode" value="" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Master Data <?php echo $description?></h4>
				</div>
				<div class="modal-body">
				<div class="well-sm form-horizontal">
					<div class="form-group">
						<span class="text-info"> </span>
					</div>
					
					
					<?php 
					date_default_timezone_set("Asia/Jakarta");
					$tanggal= date("Y-m-d");
					?>
					
					<div class="form-group">
					  <label class="col-sm-4 control-label">Tanggal Requestor<span class="required">*</span></label>
						<div class="col-sm-8">
							 <input type="text" name="createddate" id="createddate"  class="form-control input-sm validate[required] "  />
					 <span class="error-span"></span>
						</div>
				</div>	
				<div class="form-group">
					  <label class="col-sm-4 control-label">Pemohon<span class="required">*</span></label>
						<div class="col-sm-8">
							<?php
							$sql = "select * from employee order by EmpName asc";
							$addOpt = "<option value=\"\"></option>";
							echo create_select($sql, "EmpId", "EmpName", "requestor", "", $addOpt, " class=\"form-control  validate[required]\"");
							?>
					 <span class="error-span"></span>
						</div>
				</div>	
				
				<?php  if ($idtypedoc =="3"){	?>
				<div class="form-group">
					  <label class="col-sm-4 control-label">Counterpart<span class="required">*</span></label>
						<div class="col-sm-8">
							<select name="counterpart" id="counterpart" class="form-control input-sm validate[required]"/>
								<option ></option>
								<option value="SubCon Vendor" > SubCon Vendor</option>
								<option value="Kontraktor" > Kontraktor</option>
								<option value="Klien" > Klien</option>
								<option value="MSIS" > MSIS</option>
								
								<option value="Other" > Other</option>				
								
								
								</select>
					 <span class="error-span"></span>
						</div>
				</div>
				<?php } else {?>
					
						<div class="form-group">
					  <label class="col-sm-4 control-label">Surat Penandatangan<span class="required">*</span></label>
						<div class="col-sm-8">
							 <input type="text" name="judulperjanjian" id="judulperjanjian" class="form-control input-sm validate[required]" />
					 <span class="error-span"></span>
						</div>
				</div>	
				
				<?php }?>

					<div class="form-group">
					  <label class="col-sm-4 control-label">Status Document<span class="required">*</span></label>
						<div class="col-sm-8">
							<select name="jenisdoc" id="jenisdoc" class="form-control input-sm validate[required]"/>
								<option ></option>
								<option value="Draf Baru" > Draf Baru</option>
								<option value="Review Draf" > Review Draf</option>
								</select>
					 <span class="error-span"></span>
						</div>
				</div>	
				<?php  if ($idtypedoc =="3"){	?>
				<div class="form-group">
					  <label class="col-sm-4 control-label">Judul Perjanjian<span class="required">*</span></label>
						<div class="col-sm-8">
							 <input type="text" name="judulperjanjian" id="judulperjanjian" class="form-control input-sm validate[required]" />
					 <span class="error-span"></span>
						</div>
				</div>	
				<?php }?>
				<div class="form-group">
					<?php  if ($idtypedoc =="3"){	?>
					  <label class="col-sm-4 control-label">Tanggal Perjanjian<span class="required">*</span></label>
					  <?php } else {?>
					   <label class="col-sm-4 control-label">Tanggal Surat<span class="required">*</span></label>
					  <?php } ?>
						<div class="col-sm-8">
							<input type="text" name="tglsurat" id="tglsurat" class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>
				
				<div class="form-group">
					  
					  <?php  if ($idtypedoc =="3"){	?>
					  <label class="col-sm-4 control-label">Nomor Perjanjian<span class="required">*</span></label>
					  <?php } else {?>
					   <label class="col-sm-4 control-label">Nomor Surat<span class="required">*</span></label>
					  <?php } ?>
						<div class="col-sm-8">
							<input type="text" name="nodocument" id="nodocument" class="form-control input-sm" />
					 <span class="error-span"></span>
						</div>
				</div>	

	<div class="form-group">
					  <label class="col-sm-4 control-label">Harga Pekerjaan<span class="required">*</span></label>
						<div class="col-sm-8">
							 <input type="text" name="hargapekerjaan" id="hargapekerjaan" class="form-control input-sm validate[required]" />
					 <span class="error-span"></span>
						</div>
				</div>	
				
				<div class="form-group">
					  <label class="col-sm-4 control-label">Tanggal Finalisasi<span class="required">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="tanggaldoc" id="tanggaldoc" class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>	

			<div class="form-group">
					  <label class="col-sm-4 control-label">Period<span class="required">*</span></label>
						<div class="col-sm-8">
							 <input type="text" name="period" id="period" class="form-control input-sm validate[required]" />
					 <span class="error-span"></span>
						</div>
				</div>

			<div class="form-group">
					  <label class="col-sm-4 control-label">Start Date<span class="required">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="startdate" id="startdate" class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>	
				
					<div class="form-group">
					  <label class="col-sm-4 control-label">Expire Date<span class="required">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="expiredate" id="expiredate" class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>	
					
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" onclick="$('#finput').validationEngine('hide');">Hide Prompt</button>
					<button type="submit" id="submit" class="btn btn-primary">Save changes</button>
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
				</div>
			</form>
		</div>
	</div>

</div>
<script type="text/javascript">
var urlData = '<?=$__CFG_http_apps?>index.php/data/reportdocument/?fromdate=<?php echo $fromdate?>&todate=<?php echo $todate?>&idtypedoc=<?php echo $idtypedoc?>&status=<?php echo $status?>';
var urlData2 = '<?=$__CFG_http_apps?>index.php/data/document2/';
var urlSave = '<?=$__CFG_http_apps?>index.php/data/document_save/?idtypedoc=<?php echo $idtypedoc?>&status=<?php echo $status?>';
var urlDelete = '<?=$__CFG_http_apps?>index.php/data/instansi_delete/';
var oTable;





function edit(kode){
	$.getJSON(urlData2 + '?kode='+kode, function(data) {
	//alert(data.kode);
		
		
		
		

		$('#kode').val(data.idprocess);
		$('#createddate').val(data.createddate);
		$('#requestor').val(data.requestor);
		$('#counterpart').val(data.counterpart);
		$('#jenisdoc').val(data.jenisdoc);
		$('#tglsurat').val(data.tglsurat);
		$('#nodocument').val(data.nodocument);
		$('#judulperjanjian').val(data.judulperjanjian);
		$('#tanggaldoc').val(data.tanggaldoc);
		$('#period').val(data.period);
		$('#startdate').val(data.startdate);
		$('#expiredate').val(data.expiredate);
		//alert(data.LevelId);
		
		
		//alert(data.LevelId);
		
		//$('#wForm').dialog('open');
		$('#wForm').modal('toggle');
		//$('#editTable').submit();
	}); 
}
function del(kode){
	
	if (kode!=''){
		bootbox.confirm("Are you sure to delete this item?", function(result){
			if (result)window.location = urlDelete + '?kode=' + kode ;
		});
	} else {
		bootbox.alert("This item can't be remove, because there are data related to this item.");
	}
}
function resetForm(){
		$('#kode').val('');
		$('#quality').val('');
		
	    
}
$(document).ready(function(){
	oTable = $("#momTable").dataTable({bSort: true,                                     
        "sPaginationType": "bs_full",
        //"bProcessing": true,
		
        "aoColumnDefs": [{"bSortable": false, "aTargets": [ -1]}],
        "sAjaxSource": urlData,
      <?php if ($idtypedoc==3) {?>
        "aoColumns":[{"sClass": "center"},
					  {"sClass": "center"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"}, 
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					{"sClass": "TAL"},
					  {"sClass": "TAL"},						  
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
						{"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},					  
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},  
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},
					     {"sClass": "TAL"},
						 {"sClass": "TAL"},
						  {"sClass": "TAL"},
						{"sClass": "TAL"},
						 {"sClass": "TAL"},
						 {"sClass": "TAL"},
					  {"sClass": "TAL"}]
						 
		<?php } else if ($idtypedoc==2){?>	

		"aoColumns":[{"sClass": "center"},
					  {"sClass": "center"},
					  {"sClass": "TAL"}, 
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					      {"sClass": "TAL"},	
						{"sClass": "TAL"},
					   {"sClass": "TAL"},
					    {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
						{"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					  {"sClass": "TAL"},	
					   {"sClass": "TAL"},	
						{"sClass": "TAL"},
						 {"sClass": "TAL"},
						  {"sClass": "TAL"},
						   {"sClass": "TAL"},
					  {"sClass": "TAL"},
						      {"sClass": "TAL"},	
						{"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},
					    {"sClass": "TAL"},
						{"sClass": "TAL"},
						{"sClass": "TAL"},	
						 {"sClass": "TAL"},
						{"sClass": "TAL"},
					   {"sClass": "TAL"},
						{"sClass": "TAL"},
					  {"sClass": "TAL"}
					  ]
	<?php }  else {?>	

		"aoColumns":[{"sClass": "center"},
					 {"sClass": "center"},
					  {"sClass": "TAL"}, 
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					      {"sClass": "TAL"},	
						{"sClass": "TAL"},
						{"sClass": "TAL"},
						{"sClass": "TAL"},
						 {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},
						{"sClass": "TAL"},
					  {"sClass": "TAL"},					  
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
						{"sClass": "TAL"},
					  {"sClass": "TAL"},
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},	
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},
					   {"sClass": "TAL"},
					  
					  {"sClass": "TAL"}
					]

			<?php }?>
    });
	
	//reset form when close modal
	$('#wForm').on('hidden.bs.modal', function (e) {
		resetForm();
		$('#finput').validationEngine('hide');
	});
	$("#submit").click(function() {
		$("#finput").validationEngine({promptPosition: 'topLeft', prettySelect: true, usePrefix: 's2id_', autoPositionUpdate: true, scroll: false});
	//	$("#finput").attr('action', urlSave).submit();
		//alert('submit');
		$("#finput").submit();
    });
    
	
});





</script>