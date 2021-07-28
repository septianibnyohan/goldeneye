<?php
require_once($__CFG_dir_class . "globalclassdata.php");


//get id for single query data
$kode = mysqli_real_escape_string($db->dbh,$_REQUEST['kode']);


$fromdate = mysqli_real_escape_string($db->dbh,$_REQUEST['fromdate']);
$todate = mysqli_real_escape_string($db->dbh,$_REQUEST['todate']);
$status = mysqli_real_escape_string($db->dbh,$_REQUEST['status']);
$idtypedoc = mysqli_real_escape_string($db->dbh,$_REQUEST['idtypedoc']);



if( $status == "1")
{
 $where = 'and status IN ("1","0")';
}
else
{
$where = 'and status ='.$status.'';
}

//query to get data
//$SQL = "select a.*,b.jobtitle as jobtitleName, d.divisiName, c.divid,c.DepartmentName from employee a left join jobtitle b on b.id=a.jobtitle left join department c on a.department=c.id left join divisi d on a.division=d.divisiid";
if ($status =="All")

{
$SQL = "SELECT a.*,b.EmpName,c.dept AS deptName,d.description as typdoc from legal_documentprocess a left join employee b on a.requestor=b.EmpId left join legal_viewdept c on a.idprocess=c.idprocess left join legal_typedocument d on a.idtypedoc=d.idtypedoc  where  (a.createddate BETWEEN '".$fromdate."' AND '".$todate."')  and a.idtypedoc='".$idtypedoc."'  ";

}
else
{

$SQL = "SELECT a.*,b.EmpName,c.dept AS deptName,d.description as typdoc 
	from legal_documentprocess a 
	left join employee b on a.requestor=b.EmpId 
	left join legal_viewdept c on a.idprocess=c.idprocess 
	left join legal_typedocument d on a.idtypedoc=d.idtypedoc ";
	//where  (a.createddate BETWEEN '".$fromdate."' AND '".$todate."')  and a.idtypedoc='".$idtypedoc."' $where  ";

}
$cont = new GCD($SQL);

if ($kode == ""){ //jika id tidak ada, maka query semua data
	//$SQL = "select a.id, concat(case when a.Parent_ID > 0 then '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' else '' end, a.Menu_Name) as Menu_Name, a.Parent_ID, a.Div_ID, a.Expanded, a.leaf, a.url, a.order_no, b.Menu_Name as Parent_Name from menu a left join menu b on b.id = a.Parent_Id $where $sort $limit";
	$getData = $cont->listAllData("");
	if(count($getData)>0) {
		$i = 1;
		$result = array();
		foreach($getData as $r) {
		
		$idtypedoc = $r->idtypedoc;
	
			$id = $r->idprocess;
			$nodocument = $r->nodocument;
			$viewdetail = '<a href="'.$__CFG_http_apps.'index.php/master/documentprocess/?idprocess='.$id.'"class="btn btn-xs btn-gold tip" title="View Detail"><font color="black">View Detail</font></a>';
			$deptName= $r->deptName;
			$namapenerima= $r->namapenerima;
			$jenisdoc= $r->jenisdoc;
			$tglsurat= $r->tglsurat;
			$perihal = $r->perihal;
			$counterpart = $r->counterpart;
			$perusahaan = $r->perusahaan;
			$judulperjanjian = $r->judulperjanjian;
			$jenisperjanjian = $r->jenisperjanjian;
			$createddate = $r->createddate;
			$currency = $r->currency;
			$hargapekerjaan = number_format($r->hargapekerjaan, 0 , ",", ".");
			$period = $r->period;
			$startdate = $r->startdate;
			$expiredate = $r->expiredate;
			$EmpName = $r->EmpName;
			$tanggaldoc = $r->tanggaldoc;
			$typdoc = $r->typdoc;
			$status = $r->status;
			
			if ($status == "1")
				{
				$stts = "On Progress";
				}
				
			else if ($status == "2")
				{
				$stts = "Rejected";
				}	
			else if ($status == "3")
				{
				$stts = "Done";
				}
				
				else if ($status == "4")
				{
				$stts = "Revised";
				}
			else if ($status == "0")
				{
				$stts = "Waiting Approval";
				}
				
				// atasan pemohon
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=2";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$atasanp = $hasilx['EmpName'];
				$tglatasanp = $hasilx['createddate'];
				
				// pengecekan doc.
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=3";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$cekdoc = $hasilx['EmpName'];
				$tglcekdoc = $hasilx['createddate'];
				
				// penunjukan drafter.
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=4";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$tunjukdrafter = $hasilx['EmpName'];
				$tgltunjukdrafter = $hasilx['createddate'];
				
				// drafter
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=5";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$drafter = $hasilx['EmpName'];
				$tgldrafter = $hasilx['createddate'];
				
				// pemeriksaan legal counsel.
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.nextuser=b.EmpId where idprocess = '".$id."' and lastactionuser='1' and docstatus=5 order by idflowprocess asc limit 0,1";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$pemlegalcounsel = $hasilx['EmpName'];
				$tglpemlegalcounsel = $hasilx['createddate'];
				
				// pemeriksaan SM CLC.
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.nextuser=b.EmpId where idprocess = '".$id."' and lastactionuser='1' and docstatus=5 order by idflowprocess desc limit 0,1";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$smclc = $hasilx['EmpName'];
				$tglsmclc = $hasilx['createddate'];
				
				// doc by requestor
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=8";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$requestor = $hasilx['EmpName'];
				$tgldocreq = $hasilx['createddate'];
				
				// diperiksa by atasan requestor
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.nextuser=b.EmpId where idprocess = '".$id."' and lastactionuser='1' and docstatus=8";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$atasanrequestor = $hasilx['EmpName'];
				$tglatasanrequestor = $hasilx['createddate'];
				
				// drafter to review
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=9";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$drafterreview = $hasilx['EmpName'];
				$tgldrafreview = $hasilx['createddate'];
				
				// send document to user
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=13";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$douser = $hasilx['EmpName'];
				$tgldouser = $hasilx['createddate'];
				
				// send document to user - surat kuasa
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=7";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$dousersk = $hasilx['EmpName'];
				$tgldousersk = $hasilx['createddate'];
				
				// doc final - surat kuasa
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=8";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$finalsk = $hasilx['EmpName'];
				$tglfinalsk = $hasilx['createddate'];
				
				// doc final
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=13";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$final = $hasilx['EmpName'];
				$tglfinal = $hasilx['createddate'];
				
				// initial user - instrumen perjanjian
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=14";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$initial = $hasilx['EmpName'];
				$tglinitial = $hasilx['createddate'];
				
				// doc final
				$q = "select a.createddate,b.EmpName from legal_flowprocess a left join employee b on a.userid=b.EmpId where idprocess = '".$id."' and docstatus=15";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$finalIP = $hasilx['EmpName'];
				$tglfinalIP = $hasilx['createddate'];
				
				
			$q = "select attachmentdept from legal_deptreview where idprocess=".$id." order by iddeptreview desc limit 0,1 ";
				$hasil = mysqli_query($db->dbh,$q);
				$hasilx = mysqli_fetch_array($hasil);
				$docdept= $hasilx['attachmentdept'];	
		$docdept1 = $docdept == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$docdept.'">'.$docdept.'</a>';

			
			$attachment = $r->attachment == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->attachment.'">'.$r->attachment.'</a>';
			
		
			$docpendukung = $r->docpendukung == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docpendukung.'">'.$r->docpendukung.'</a>';
			
			$docdraft = $r->docdraft == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docdraft.'">'.$r->docdraft.'</a>';
		
			$docseconddraft = $r->docseconddraft == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docseconddraft.'">'.$r->docseconddraft.'</a>';
		
			$docsigning = $r->docsigning == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docsigning.'">'.$r->docsigning.'</a>';
		
			$docfinal = $r->docfinal == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docfinal.'">'.$r->docfinal.'</a>';
			
			$userattachment = $r->userattachment == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->userattachment.'">'.$r->userattachment.'</a>';
		
			$docrevised = $r->docrevised == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docrevised.'">'.$r->docrevised.'</a>';
			
			
			$documentUser = $r->documentUser == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->documentUser.'">'.$r->documentUser.'</a>';
			
			
			$docsecondrevised = $r->docsecondrevised == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$r->docsecondrevised.'">'.$r->docsecondrevised.'</a>';
			//cek data for constraint
				
				$action = '<a href="javascript:void(0)" onclick="edit('.$id.')" class="btn btn-xs btn-primary tip" title="Edit"><i class="fa fa-pencil"></i></a>';
					//	<a href="javascript:void(0)" onclick="del('.$id.')" class="btn btn-xs btn-danger tip" title="Delete"><i class="fa fa-trash-o"></i></a>
			
						
			//$dataCell = array($i++, $name, $pName, $icon, $url, $ordering, $action);
			if ($idtypedoc==3){
				
				$result['aaData'][] = array($i++,$viewdetail,$typdoc,$counterpart,$perusahaan,$jenisdoc,$judulperjanjian,$tglsurat, $nodocument,$deptName,$docdept1,$currency,$hargapekerjaan,$tanggaldoc,$period,$startdate,$expiredate,$stts,$EmpName, $createddate,$attachment,$docpendukung,$atasanp,$tglatasanp,$cekdoc,$tglcekdoc,$tunjukdrafter,$tgltunjukdrafter,$drafter,$tgldrafter,$docdraft,$pemlegalcounsel,$tglpemlegalcounsel,$smclc,$tglsmclc,$requestor, $tgldocreq,$userattachment,$atasanrequestor, $tglatasanrequestor,$drafterreview,$tgldrafreview,$docseconddraft,$douser,$tgldouser,$documentUser,$initial,$tglinitial,$docsigning,$finalIP,$tglfinalIP,$docfinal); //$EmpNo,,$id, $JabatanId,  $SuperiorId,$AksesLevel,$LevelId,$department

			} else if ($idtypedoc==2)
			{
			
			$result['aaData'][] = array($i++,$viewdetail,$typdoc, $nodocument,$namapenerima,$jenisdoc,$tglsurat,$perihal,$deptName,$docdept1,$stts,$EmpName, $createddate,$attachment,$docpendukung,$atasanp,$tglatasanp,$cekdoc,$tglcekdoc,$tunjukdrafter,$tgltunjukdrafter,$drafter,$tgldrafter,$docdraft,$pemlegalcounsel,$tglpemlegalcounsel,$smclc,$tglsmclc,$requestor, $tgldocreq,$userattachment,$atasanrequestor, $tglatasanrequestor,$drafterreview,$tgldrafreview,$docseconddraft,$douser,$tgldouser,$documentUser,$final,$tglfinal,$docfinal); //$EmpNo,,$id, $JabatanId,  $SuperiorId,$AksesLevel,$LevelId,$department
		
			}else
			{
			
			$result['aaData'][] = array($i++,$viewdetail,$typdoc, $nodocument,$namapenerima,$jenisdoc,$tglsurat,$perihal,$stts,$EmpName, $createddate,$attachment,$docpendukung,$cekdoc,$tglcekdoc,$tunjukdrafter,$tgltunjukdrafter,$drafter,$tgldrafter,$docdraft,$pemlegalcounsel,$tglpemlegalcounsel,$smclc,$tglsmclc,$dousersk,$tgldousersk,$documentUser,$finalsk,$tglfinalsk,$docfinal); //$EmpNo,,$id, $JabatanId,  $SuperiorId,$AksesLevel,$LevelId,$department
		
			}
		
		
		}
	}
} else {
	$result = $cont->getSingleData("idprocess = $kode");
}

$__not_show_all_footer = true;
$__not_show_timer = true;

echo json_encode($result);
?>