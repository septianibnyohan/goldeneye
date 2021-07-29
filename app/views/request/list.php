<?php
global $__page_title;

$__page_title = "List Of Request";
$__html_title = $__page_title;
$pageActive = "master";

$__navigation = '<li><a href="#">Request for Review</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';
$description = 'Instrument Request';
require_once(BASE_DIR."inc/header.php");


?>

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
						<tr>
                            <th>ID</th>
                            <th>Document Type</th>
                            <th>Document Name</th>
                            <th>Document Status</th>
                            <th>Document Number</th>
                            <th>Document Date</th>
                            <th>Subject</th>
                            <th>Location</th>
                            <th>Created Date</th>
                        </tr>
					</thead>
					<tfoot>
                        <th>ID</th>
                        <th>Document Type</th>
                        <th>Document Name</th>
                        <th>Document Status</th>
                        <th>Document Number</th>
                        <th>Document Date</th>
                        <th>Subject</th>
                        <th>Location</th>
                        <th>Created Date</th>
					</tfoot>		
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var urlData = '<?=$__CFG_http_apps?>request/listData';
var oTable;

$(document).ready(function(){
	
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
		


		"aoColumns":[{"sClass": "center"},
					  {"sClass": "center"},
					  {"sClass": "TAL"}, 
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					    {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},	
					   {"sClass": "TAL"}
					]
    
	
    });	
	
})
</script>

<?php
require_once(BASE_DIR."/inc/footer.php");
?>