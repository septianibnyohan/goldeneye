<?php
$pageActive = "beranda";
# include header file
//require_once($__CFG_dir_layout . $__CFG_app_layout."/header.php");
require_once(BASE_DIR."inc/header.php");
//require_once($__CFG_dir_class . "globalclassdata.php");



$status = mysqli_real_escape_string($db->dbh, $_REQUEST['status']);

/*$q = "select akseslegal from employee where EmpId='".$_SESSION['userid']."' ";
				$hasil = mysql_query($q);
				$hasilx = mysql_fetch_array($hasil);
				$akseslegal= $hasilx['akseslegal'];*/

?>


<script src="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $__CFG_http_themes . $__CFG_app_themes; ?>/js/datetimepicker/jquery.datetimepicker.css" />

<span class="date-range pull-right">
										<p class="btn-toolbar">
										 <a href="<?=$__CFG_http_apps?>index.php/master/documentwizard/?idtype=4"  class="btn btn-xs btn-info">SURAT TUGAS</button> </a>
											 <a href="<?=$__CFG_http_apps?>index.php/master/documentwizard/?idtype=1"  class="btn btn-xs btn-lumut">SURAT KUASA</button> </a>	  
											
											<button class="btn btn-xs btn-birutua" onclick="window.location='<?php echo $__CFG_http_apps?>index.php/master/documentwizard/?idtype=2'">KORESPONDENSI</button>
											<button class="btn btn-xs btn-pink" onclick="window.location='<?php echo $__CFG_http_apps?>index.php/master/documentwizard/?idtype=3'">INSTRUMEN PERJANJIAN</button>
											
										</p>
											
		
										
										</span>
<div class="row">
			<!-- BOX -->
	<div class="col-md-12">
			<div class="box border gold">
				<div class="box-title">
					<h4>
						<i class="fa fa-calendar"></i> <span class="hidden-inline-mobile">Document Calendar</span>
					</h4>
				</div>
				
				
				<?php
				


				
		if ($akseslegal == "1")
			{				
				if ($status =="")
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc";
				}
				
				else if ($status =="1")
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc where a.status IN ('1','0')";
				}
				else 
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc where a.status='".$status."'";
				}
			} 
			else
			{
				if ($status =="")
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc";
				}
				
				else if ($status =="1")
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc where a.status IN ('1','0')";
				}
				else 
				{
				$SQL = "SELECT * from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc where a.status='".$status."'";
				}	
			}
				
				$dataEvents = array();
				$cont = new GCD($SQL);
				$getData = $cont->listAllData("");
				for ($i=0;$i<count($getData);$i++){
					
					
				$q = "select userid from legal_userreview  where idprocess='".$getData[$i]->idprocess."' and lastaction= '0' order by idreview asc limit 0,1";
				$hasil = mysqli_query($db->dbh,$q);
				$hasil6x = mysqli_fetch_array($hasil);
				$userrev = $hasil6x['userid'];
					
					$start = date_format(new DateTime($getData[$i]->createddate), "Y-m-d H:i:s");
					
					
					//SURAT TUGAS -------------------------------------------------------------------------------------------------------------------------
					if (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "0"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Pengecekan Dokumen";
					} elseif (strtolower($getData[$i]->statusdoc) == "1" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Pengecekan Dokumen" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Penunjukan Drafter";
					} elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Penyusunan Draf oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "5" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						
						if ($userrev =="10")
						{
						$color = "#70AFC4";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#70AFC4";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "5" && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Mencetak Dokumen";
					}elseif (strtolower($getData[$i]->statusdoc) == "7" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Menunggu Dokumen Final";
					}elseif (strtolower($getData[$i]->statusdoc) == "8" && ($getData[$i]->status) == "3" && ($getData[$i]->idtypedoc) == "4"){
						$color = "#70AFC4";
						$title = "Dokumen Final";
					}
					
					//SURAT KUASA -------------------------------------------------------------------------------------------------------------------------
					if (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "0"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Pengecekan Dokumen";
					} elseif (strtolower($getData[$i]->statusdoc) == "1" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Pengecekan Dokumen" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Penunjukan Drafter";
					} elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Penyusunan Draf oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "5" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						if ($userrev =="10")
						{
						$color = "#6B6B47";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#6B6B47";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "5" && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Mencetak Dokumen";
					}elseif (strtolower($getData[$i]->statusdoc) == "7" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Menunggu Dokumen Final";
					}elseif (strtolower($getData[$i]->statusdoc) == "8" && ($getData[$i]->status) == "3" && ($getData[$i]->idtypedoc) == "1"){
						$color = "#6B6B47";
						$title = "Dokumen Final";
					}
					//KORESPONDENSI -------------------------------------------------------------------------------------------------------------------------
					
					
					else if (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "0" && ($getData[$i]->idtypedoc) == "2"){
						$color = "#3D3D5C";
						$title = "Menunggu Persetujuan";
					} elseif (strtolower($getData[$i]->statusdoc) == "1" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "2"){
						$color = "#3D3D5C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "2"){
						$color = "#3D3D5C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "2"){
						$color = "#3D3D5C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pengecekan Dokumen" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Penunjukan Drafter" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2" && ($getData[$i]->jenisdoc) == "Draf Baru")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Penyusunan Draf oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2" && ($getData[$i]->jenisdoc) == "Review Draf")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "5" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "2")
					{
						if ($userrev =="10")
						{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "5"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Dokumen yang diperiksa/ditinjau oleh Departemen/Divisi/Manajemen";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "4" && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Revisi Dokumen yang diperiksa/ditinjau oleh Departemen/Divisi/Manajemen";
					}elseif (strtolower($getData[$i]->statusdoc) == "7" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "8" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Atasan Pemohon";
						
					}elseif (strtolower($getData[$i]->statusdoc) == "9" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Drafter";
						
					}elseif (strtolower($getData[$i]->statusdoc) == "10" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2" && ($getData[$i]->remarksecondprocess) == "")
					{
						
						if ($userrev =="10")
						{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-2 oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-2 oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "10" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2" && ($getData[$i]->remarksecondprocess) !== "")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-3 oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "11" && ($getData[$i]->status) == "5"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "11" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Konfirmasi Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "12" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Menunggu Mencetak Dokumen";
					}elseif (strtolower($getData[$i]->statusdoc) == "13" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "2" )
					{
						$color = "#3D3D5C";
						$title = "Menunggu Dokumen Final";
					}elseif (strtolower($getData[$i]->statusdoc) == "14" && ($getData[$i]->status) == "3"  && ($getData[$i]->idtypedoc) == "2")
					{
						$color = "#3D3D5C";
						$title = "Dokumen Final";
					}
					
					//INSTRUMEN PERJANJIAN -------------------------------------------------------------------------------------------------------------------------
					
					else if (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "0"  && ($getData[$i]->idtypedoc) == "3"){
						$color = "#DB5E8C";
						$title = "Menunggu Persetujuan";
					} elseif (strtolower($getData[$i]->statusdoc) == "1" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "3"){
						$color = "#DB5E8C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "3"){
						$color = "#DB5E8C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "2"  && ($getData[$i]->idtypedoc) == "3"){
						$color = "#DB5E8C";
						$title = "Telah Ditolak";
					} elseif (strtolower($getData[$i]->statusdoc) == "2" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pengecekan Dokumen" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "3" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Penunjukan Drafter" ;
					} elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3" && ($getData[$i]->jenisdoc) == "Draf Baru")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Penyusunan Draf oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "4" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3" && ($getData[$i]->jenisdoc) == "Review Draf")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "5" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						if ($userrev =="10")
						{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "5"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Dokumen yang diperiksa/ditinjau oleh Departemen/Divisi/Manajemen";
					}elseif (strtolower($getData[$i]->statusdoc) == "6" && ($getData[$i]->status) == "4"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Revisi Dokumen yang diperiksa/ditinjau oleh Departemen/Divisi/Manajemen";
					}elseif (strtolower($getData[$i]->statusdoc) == "7" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "8" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Atasan Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "9" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan oleh Drafter";
					}elseif (strtolower($getData[$i]->statusdoc) == "10" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "3" && ($getData[$i]->remarksecondprocess) == "")
					{
						if ($userrev =="10")
						{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-2 oleh SM CLC";
						}
						else if ($userrev =="28")
						{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-2 oleh Legal Counsel";
						}
					}elseif (strtolower($getData[$i]->statusdoc) == "10" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "3" && ($getData[$i]->remarksecondprocess) !== "")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Pemeriksaan/Peninjauan Tahap ke-3 oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "11" && ($getData[$i]->status) == "5"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Direvisi oleh SM CLC";
					}elseif (strtolower($getData[$i]->statusdoc) == "11" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Konfirmasi Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "12" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Mencetak Dokumen";
					}elseif (strtolower($getData[$i]->statusdoc) == "14" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Proses Paraf dan Tanda Tangan Pihak Terkait ";
					}elseif (strtolower($getData[$i]->statusdoc) == "13" && ($getData[$i]->status) == "1"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Menunggu Penyerahan Dokumen kepada Pemohon";
					}elseif (strtolower($getData[$i]->statusdoc) == "15" && ($getData[$i]->status) == "1" && ($getData[$i]->idtypedoc) == "3" )
					{
						$color = "#DB5E8C";
						$title = "Menunggu Dokumen Final";
					}elseif (strtolower($getData[$i]->statusdoc) == "16" && ($getData[$i]->status) == "3"  && ($getData[$i]->idtypedoc) == "3")
					{
						$color = "#DB5E8C";
						$title = "Dokumen Final";
					}
										
					
					//---------------------------------------------------------------------------------------------------------------------------------------------		
					//echo $color;
					$dataEvents[] = array(
							'type' => $getData[$i]->description,
							'nodoc' => $getData[$i]->nodocument,
							'judul' => $getData[$i]->judulperjanjian,
							'title' => $title,
							'start' => $start,							
							'backgroundColor' => $color,
							'url' => $__CFG_http_apps.'index.php/master/documentprocess/?idprocess='.$getData[$i]->idprocess
					);
				}
			
			?>
				<div class="box-body">
				<form id="finput2" role="form" action="<?php echo $__CFG_http_apps?>index.php/home/index" method="post" class="form-horizontal">
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Status<span class="required">*</span></label>
						 <div class="col-md-2">
						 <select  id="status" name="status" value="<?php echo $status?>" class="form-control input-sm validate[required]" />
							<option selected="selected" value=""></option>
							<option  value="All"<?php echo $status == "" ? " selected" : ""?>>All</option>
							<option  value="1"<?php echo $status == "1" ? " selected" : ""?>>On Progress</option>
							<option  value="3"<?php echo $status == "3" ? " selected" : ""?>>Done</option>
								<option  value="2"<?php echo $status == "2" ? " selected" : ""?>>Telah Ditolak</option>								
									
							</select>
					</div>
				</div>
				
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<button type="submit" id="submit" class="btn btn-primary">Filter</button>
							<button type="button" id="clear" class="btn btn-danger" onclick="window.location='<?php echo $__CFG_http_apps?>index.php'">Clear Filter</button>
						</div>
					</div>
				</form>
					<div id='calendar'></div>
				</div>
			</div>
		</div>
</div>



<script>

jQuery(document).ready(function() {
	App.setPage("index");  //Set current page
	//App.setPage("other");
	//App.init(); //Initialise plugins and elements
	
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			
			  allDayDefault: false,
		events: <?php echo json_encode($dataEvents)?>,
		defaultView: 'month',
        timeFormat: {
					agenda: 'h:mm{ - h:mm}', //h:mm{ - h:mm}'
					month: '' //h:mm{ - h:mm}'
					},
					
					
	eventMouseover: function(calEvent, jsEvent) {
    var tooltip = '<div class="tooltipevent" style="width:272px; height:88px; background:#D0AA11; color:white; position:absolute; z-index:10001;">' + 'Nama Document    ' + ': ' + calEvent.type + '<br />' + 'No Document  ' + ': ' + calEvent.nodoc + '<br />' + 'Judul Perjanjian   ' + ': ' + calEvent.judul + '</div>';
   // var tooltip = '<div class="tooltipevent" style="width:auto;height:auto;background:#feb811;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'title: ' + ': ' + calEvent.title + '</br>' + 'start: ' + ': ' + calEvent.start + '</div>';
    var $tooltip = $(tooltip).appendTo('body');

    $(this).mouseover(function(e) {
        $(this).css('z-index', 10000);
        $tooltip.fadeIn('500');
        $tooltip.fadeTo('10', 1.9);
    }).mousemove(function(e) {
        $tooltip.css('top', e.pageY + 10);
        $tooltip.css('left', e.pageX + 20);
    });
},

eventMouseout: function(calEvent, jsEvent) {
    $(this).css('z-index', 8);
    $('.tooltipevent').remove();
},		
			editable: false,
			//events: <?php echo json_encode($dataEvents)?>,
		});
		
			
			
});
</script>

<?php
require_once(BASE_DIR."/inc/footer.php");
?>