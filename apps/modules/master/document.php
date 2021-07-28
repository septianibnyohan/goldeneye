<?php
$__page_title = "Dokumen MHU";
$__html_title = $__page_title;
$pageActive = "master";

$__navigation = '<li><a href="#">master</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';

$idtypedoc= $_REQUEST['idtypedoc'];	
$status= $_REQUEST['status'];	
//echo $prid;
$q = "select description from legal_typedocument where idtypedoc='".$idtypedoc."' ";
				$hasil = mysql_query($q);
				$hasilx = mysql_fetch_array($hasil);
				$description= $hasilx['description'];

# include header file
require_once($__CFG_dir_layout . $__CFG_app_layout."/header.php");
?>

<script type="text/javascript">
$(document).ready(function() {

	$("#createduser").val('<?php echo $_SESSION['userid']?>');	
	$("#namalengkap").val('<?php echo $_SESSION['name']?>');
	$("#createduser").attr('readonly', true);
	$("#namalengkap").attr('readonly', true);
	$("#typedoc").attr('readonly', true);


})


</script>	
<div class="row">
	<div class="col-md-12">
		<div class="box border inverse">
			<div class="box-title">
				<h4>
					<i class="fa fa-list-alt"></i> <span class="hidden-inline-mobile"><?php echo $description?></span>
				</h4>
				<div class="tools">
					<!--<a href="#wForm" data-toggle="modal" class="tip-left" title="Add Record"> <i class="fa fa-plus"></i></a>-->
				</div>
			</div>
			<div class="box-body" style="overflow-x:auto;">
				
				<table id="momTable" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
					<thead>
						<?php if ($_REQUEST['idtypedoc']==3){?>
					
						<tr>
						<th width="2%">No</th>
						<th width="15%">Lihat detail</th>
						<th width="15%">Tanggal Permohonan</th>
						<th width="25%">Pemohon</th>
						<th width="25%">Rekanan</th>
						<th width="25%">Nama Perusahaan</th>
						<th width="25%">Status Dokumen</th>
						<th width="35%">Nama Perjanjian</th>
						<th width="35%">Tanggal Perjanjian</th>
						<th width="35%">Nomor Perjanjian</th>
						<th width="15%">Mata Uang</th>
						<th width="35%">Harga Pekerjaan</th>
						<th width="35%">Tanggal Finalisasi</th>
						<th width="25%">Jangka Waktu</th>
						<th width="25%">Tanggal Mulai</th>
						<th width="25%">Tanggal Kedaluwarsa</th>
						<th width="25%">Lokasi/Wilayah</th>
					
						
						
						</tr>
					
					<?php } else if ($_REQUEST['idtypedoc']==2) {?>
						<tr>
						<th width="2%">No</th>
						<th width="35%">Lihat detail</th>
							<th width="35%">Tanggal Permohonan</th>
						<th width="35%">Pemohon</th>
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penandatangan </th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
						
						<th width="35%">Perihal</th>
						<th width="25%">Lokasi/Wilayah</th>
						</tr>
						<?php } else {?>
						<tr>
						<th width="2%">No</th>
						<th width="35%">Lihat detail</th>
						<th width="35%">Tanggal Permohonan</th>
						<th width="35%">Pemohon</th>
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penerima Kuasa</th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
					
						<th width="35%">Perihal</th>
						<th width="25%">Lokasi/Wilayah</th>
					
						</tr>
						<?php }?>
					</thead>
					<tfoot>
					 		<?php if ($_REQUEST['idtypedoc']==3){?>
					
						<tr>
						<th width="2%">No</th>
						<th width="15%">Lihat detail</th>
						<th width="15%">Tanggal Permohonan</th>
						<th width="25%">Pemohon</th>
						<th width="25%">Rekanan</th>
						<th width="25%">Nama Perusahaan</th>
						<th width="25%">Status Dokumen</th>
						<th width="35%">Nama Perjanjian</th>
						<th width="35%">Tanggal Perjanjian</th>
						<th width="35%">Nomor Perjanjian</th>
						<th width="15%">Mata Uang</th>
						<th width="35%">Harga Pekerjaan</th>
						<th width="35%">Tanggal Finalisasi</th>
						<th width="25%">Jangka Waktu</th>
						<th width="25%">Tanggal Mulai</th>
						<th width="25%">Tanggal Kedaluwarsa</th>
						<th width="25%">Lokasi/Wilayah</th>
					
						
						
						</tr>
					
					<?php } else if ($_REQUEST['idtypedoc']==2) {?>
						<tr>
						<th width="2%">No</th>
						<th width="35%">Lihat detail</th>
							<th width="35%">Tanggal Permohonan</th>
						<th width="35%">Pemohon</th>
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penandatangan </th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
						
						<th width="35%">Perihal</th>
						<th width="25%">Lokasi/Wilayah</th>
						</tr>
						<?php } else {?>
						<tr>
						<th width="2%">No</th>
						<th width="35%">Lihat detail</th>
						<th width="35%">Tanggal Permohonan</th>
						<th width="35%">Pemohon</th>
						<th width="35%">Nomor Surat</th>						
						<th width="35%">Nama Penerima Kuasa</th>
						<th width="35%">Status Dokumen</th>
						<th width="35%">Tanggal Surat</th>
					
						<th width="35%">Perihal</th>
						<th width="25%">Lokasi/Wilayah</th>
						</tr>
						<?php }?>
					</tfoot>		
					<tbody>
					</tbody>
				</table>
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
					  <label class="col-sm-4 control-label">Requestor<span class="required">*</span></label>
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
								<option value="New Draft" > New Draft</option>
								<option value="Review Draft" > Review Draft</option>
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
					<?php  if ($idtypedoc =="3") {	?>
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
var urlData = '<?=$__CFG_http_apps?>index.php/data/document/?idtypedoc=<?php echo $idtypedoc?>&status=<?php echo $status?>';
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
$('#momTable tfoot th').each( function () {
        var title = $('#momTable thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="hidden" placeholder="Search '+title+'" />' );
    } );
	
	var oTable = $("#momTable").DataTable(
	
	{
		bSort: true,     
		"scrollX": true, // untuk scroll
		
        "sPaginationType": "bs_full",
		"bLengthChange": false, "bPaginate": false,bExpandableGrouping: true, // untuk grouping dan mematikan pagenation
        //"bProcessing": true,
        "aoColumnDefs": [{"bSortable": true, "aTargets": [ -1]}],
		
       // "order": [[ 2, 'asc' ]],
		
        //"displayLength": 25,
		//rowGrouping(),
		
		
        "sAjaxSource": urlData,
		
		<?php if ($_REQUEST['idtypedoc']==3) {?>
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
					  {"sClass": "TAL"}]
						 
		<?php } else {?>	

		"aoColumns":[{"sClass": "center"},
					  {"sClass": "center"},
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
		$("#finput").attr('action', urlSave).submit();
		//alert('submit');
		$("#finput").submit();
    });
    
	
});	
	

</script>