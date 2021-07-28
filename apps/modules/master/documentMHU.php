<?php
$__page_title = "Dokumen MHU";
$__html_title = $__page_title;
$pageActive = "master";
$pageCurrent = "master";
$__navigation = '<li><a href="#">master</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';

# include header file
require_once($__CFG_dir_layout . $__CFG_app_layout."/header.php");
?>

<div class="row">
	<div class="col-md-12">
		<div class="box border inverse">
			<div class="box-title">
				<h4>
					<i class="fa fa-list-alt"></i> <span class="hidden-inline-mobile"><?php echo $__page_title?></span>
				</h4>
				<div class="tools">
					<!--<a href="<?=$__CFG_http_apps?>index.php/master/peraturanwizard/" data-toggle="modal" class="tip-left" title="Add Record"> <i class="fa fa-plus"></i></a>-->
				</div>
			</div>
				
			<div class="box-body">
				<table id="momTable" cellpadding="0" cellspacing="0" border="0" class="datatable  ">
					<thead>
						<tr>
					
						<th width="35%" class="center">Nama Dokumen</th>
						
						
					
						<th width="20%"><br>&nbsp;
						<br><button class="btn btn-xs btn-  tip"><font color="#D0AA11"><b>On Progress&nbsp;</button>&nbsp;
						<button class="btn btn-xs btn-tip" ><font color="#3D3D5C"><b>Done</button>&nbsp;
						<button class="btn btn-xs btn btn- tip" ><font color="#D9534F"><b>Rejected</button></th>
						<th width="20%"  class="center">Total</th>
						
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="wForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<!-- <div class="well example-modal"> -->
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="finput" role="form" action="<?=$__CFG_http_apps?>index.php/data/plant_material_save/" method="post">
				<input type="hidden" id="kode" name="kode" value="" />
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Master Data Quality</h4>
				</div>
				<div class="modal-body">
				<div class="well-sm form-horizontal">
					<div class="form-group">
						<span class="text-info"> </span>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">No :</label>
						<div class="col-sm-8">
							<input type="text" id="kode" name="" value="" class="form-control col-xs-3 input-sm " disabled="disabled" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Quality :</label>
						<div class="col-sm-8">
							<input type="text" name="quality" id="quality" class="form-control input-sm validate[required] " />
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
var urlData = '<?=$__CFG_http_apps?>index.php/data/documentMHU/';
var urlSave = '<?=$__CFG_http_apps?>index.php/data/regulatory_save/';
var urlDelete = '<?=$__CFG_http_apps?>index.php/data/regulatory_delete/';
var oTable;



function copyrow(kode){
	$.getJSON(urlData + '?kode='+kode, function(data) {
		//alert(data.mat_doc);
		
		
		
		
		//$('#kode').val(data.idplaning);
		$('#quality').val(data.seamname);
		
		
		//alert(data.LevelId);
		
		//$('#wForm').dialog('open');
		$('#wForm').modal('toggle');
	}); 
}


function edit(kode){
	$.getJSON(urlData + '?kode='+kode, function(data) {
		//alert(data.mat_doc);
		
		
		
		
		$('#kode').val(data.idquality);
		$('#quality').val(data.quality);
		
		
		//alert(data.LevelId);
		
		//$('#wForm').dialog('open');
		$('#wForm').modal('toggle');
	}); 
}
function del(kode){
	bootbox.confirm("Are you sure to delete this item?", function(result){
		window.location = urlDelete + '?kode=' + kode;
	});
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
        "aoColumns":[
					  {"sClass": "left"},					 		  
					  {"sClass": "center"},
				
				
					  {"sClass": "center"}]
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