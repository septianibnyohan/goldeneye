<?php
require_once($__CFG_dir_class . "globalclassdata.php");


//get id for single query data
$kode = mysqli_real_escape_string($db->dbh,$_REQUEST['kode']);


//query to get data
//$SQL = "select a.*,b.jobtitle as jobtitleName, d.divisiName, c.divid,c.DepartmentName from employee a left join jobtitle b on b.id=a.jobtitle left join department c on a.department=c.id left join divisi d on a.division=d.divisiid";
$SQL = "SELECT a.*, (select count(b.status) from legal_documentprocess b where a.idtypedoc=b.idtypedoc    )as total, (select count(b.status) from legal_documentprocess b where a.idtypedoc=b.idtypedoc and  b.status IN ('1','0')   )as onprogress,(select count(b.status) from legal_documentprocess b where a.idtypedoc=b.idtypedoc and b.status='2' )as rejected,(select count(b.status) from legal_documentprocess  b where a.idtypedoc=b.idtypedoc and b.status='3'  ) as done from legal_typedocument a LEFT JOIN legal_documentprocess b on a.idtypedoc=b.idtypedoc group by a.idtypedoc asc ";
$cont = new GCD($SQL);

if ($kode == ""){ //jika id tidak ada, maka query semua data
	//$SQL = "select a.id, concat(case when a.Parent_ID > 0 then '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' else '' end, a.Menu_Name) as Menu_Name, a.Parent_ID, a.Div_ID, a.Expanded, a.leaf, a.url, a.order_no, b.Menu_Name as Parent_Name from menu a left join menu b on b.id = a.Parent_Id $where $sort $limit";
	$getData = $cont->listAllData("");
	if(count($getData)>0) {
		$i = 1;
		$result = array();
		foreach($getData as $r) {
			$id = $r->idtypedoc;
			
			$description = '<b>'.$r->description.'</b>';
			$total = $r->total;
			$countop = $r->onprogress;
			$countdone = $r->done;
			$countrej = $r->rejected;
		
			//cek data for constraint
				
			$action = '<a href="'.$__CFG_http_apps.'index.php/master/document/?idtypedoc='.$id.'&status=1" class="btn btn-xs btn-warning tip" title="Lihat Detail">  &nbsp; &nbsp;&nbsp; '.(int) $countop.'   &nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="'.$__CFG_http_apps.'index.php/master/document/?idtypedoc='.$id.'&status=3" class="btn btn-xs btn-primary tip" title="Lihat Detail">  &nbsp; &nbsp;&nbsp; '.(int) $countdone.'   &nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="'.$__CFG_http_apps.'index.php/master/document/?idtypedoc='.$id.'&status=2" class="btn btn-xs btn-danger tip" title="Lihat Detail">  &nbsp; &nbsp;&nbsp; '.(int) $countrej.'   &nbsp;&nbsp;&nbsp;</a>&nbsp;';
					
						
		$action1 = '<button type="button" class="btn btn-xs btn-info tip" >  &nbsp; &nbsp;&nbsp; '.(int) $total.'   &nbsp;&nbsp;&nbsp;</a>&nbsp;</button>';
					

					
			//$dataCell = array($i++, $name, $pName, $icon, $url, $ordering, $action);
			$result['aaData'][] = array($description,$action,$action1); //$EmpNo,,$id, $JabatanId,  $SuperiorId,$AksesLevel,$LevelId,$department
		}
	}
} else {
	$result = $cont->getSingleData("idtypedoc = $kode");
}

$__not_show_all_footer = true;
$__not_show_timer = true;

echo json_encode($result);
?>