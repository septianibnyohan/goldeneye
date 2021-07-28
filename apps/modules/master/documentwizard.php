<?php
if ($_REQUEST['idtype']== '1' )
{
$__page_title = "Surat Kuasa";
}else if ($_REQUEST['idtype']== '2' )
{
$__page_title = "Korespondensi";
}else if ($_REQUEST['idtype']== '3' )
{
$__page_title = "Instrumen Perjanjian";
}
$__html_title = $__page_title;
$pageActive = "dokumen permohonan";
$pageCurrent = "mom";
$__navigation = '<li><a href="#">dokumen permohonan</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';

$isPdca = $_SESSION['department'] == 1 ? true : false;

# include header file
require_once($__CFG_dir_layout . $__CFG_app_layout."/header.php");

 $query = "select a.*,b.description from legal_documentprocess a left join legal_typedocument b on a.idtypedoc=b.idtypedoc where idprocess = '".$_REQUEST['idprocess']."'";
 $hasil = mysqli_query($db->dbh, $query);
 
 
 while ($data = mysqli_fetch_array($hasil))
 {
	
	$nodocument = $data['nodocument'];
	$idtypedoc = $data['idtypedoc'];
	$jenisdoc = $data['jenisdoc'];
	$jenisperjanjian = $data['jenisperjanjian'];
	$counterpart = $data['counterpart'];
	$judulperjanjian = $data['judulperjanjian'];
	$perusahaan = $data['perusahaan'];
	$tglsurat = $data['tglsurat'];
	$currency = $data['currency'];
	$hargapekerjaan = number_format($data['hargapekerjaan']);
	$period = $data['period'];
	$keterangan = $data['keterangan'];
	$startdate = $data['startdate'];
	$expiredate = $data['expiredate'];
	$docpendukung = $data['docpendukung'];
	$attachpendukung = $docpendukung == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$docpendukung.'">'.$docpendukung.'</a>';
	$attachment = $data['attachment'];
	$attachmentdoc = $attachment == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=document&fname='.$attachment.'">'.$attachment.'</a>';
}	



	
	
	$q = "select * from legal_formdokumen";
				$hasilx = mysqli_query($db->dbh,$q);
				$hasilxx = mysqli_fetch_array($hasilx);
				
			
				$docattachment1 = $hasilxx['attachment'];
				$docattachment = $docattachment1 == "" ? "" : '<a href="'.$__CFG_http_apps.'index.php/download/file?type=docpendukung&fname='.$docattachment1.'"  class="btn btn-xs btn-primary" title="unduh dokumen pendukung">'.$docattachment1.'</a>';
?>
									  

<script type="text/javascript">
$(document).ready(function() {

	
	$("#idtypedoc").attr('readonly', true);


})
</script>	


	
<div class="row">
							<div class="col-md-12">
								<!-- BOX -->
								<div class="box border inverse" id="formWizard">
									<div class="box-title">
									<?php if ($_REQUEST['idtype']== '1' ){?>
										<h4><i class="fa fa-bars"></i>Surat Kuasa   <span class="stepHeader"></h4>
									<?php } else if ($_REQUEST['idtype']== '2' ){?>	
									<h4><i class="fa fa-bars"></i>Korespondensi   <span class="stepHeader"></h4>
									<?php } else if ($_REQUEST['idtype']== '3' ){?>	
									<h4><i class="fa fa-bars"></i>Instrumen Perjanjian   <span class="stepHeader"></h4>
									<?php }?>	
									</div>
								
									<div class="box-body form">
									
								
											<form id="finput"  name="forminput" role="form" enctype="multipart/form-data" method="post" class="form-horizontal">
										<div class="wizard-form">
										   <div class="wizard-content" id="tabnya">
											  <ul class="nav nav-pills nav-justified steps">
												<li id="dailyheader">
													<a href="#account" data-toggle="tab" class="wiz-step">
													<!--<span class="step-number"></span>-->
											<?php if ($_REQUEST['idtype']== '1' ){?>
										<span class="step-name"><i class="fa fa-check"></i> <font color="white">Formulir Surat Kuasa</font></span> 
									<?php } else if ($_REQUEST['idtype']== '2' ){?>	
									<span class="step-name"><i class="fa fa-check"></i> <font color="white">Formulir Korespondensi</font></span> 
									<?php } else if ($_REQUEST['idtype']== '3' ){?>	
									<span class="step-name"><i class="fa fa-check"></i> <font color="white">Formulir Instrumen Perjanjian</font></span> 
									<?php }?>	
													
													
													
													</a>
												 </li>

												
											  </ul>
											  <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
												 <div class="progress-bar progress-bar-warning"></div>
											  </div>
											  <div class="tab-content">
												
											    
											
												
												 <div class="tab-pane active" id="account">
												<input type="hidden" id="kode" name="kode" value="" />
													
												
													<div class="form-group">
						<span class="control-label col-md-3"> Seluruh baris yang bertanda (*) wajib diisi</span>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Document to User</label>
						<div class="col-md-4">
						<select name="ownerdocument" id="ownerdocument" class="form-control input-sm validate[required]" required="required" >
								 <?php
							
								 $query = "SELECT  * from employee ";
								$hasil = mysqli_query($db->dbh,$query);
								echo "<option > </option>";
								while($data=mysqli_fetch_array($hasil)){
									echo "<option value=$data[EmpId]> $data[EmpName]</option>";
								}
								
								?>
								</select>
						</div>
					</div>
				
					
					<?php if ($_REQUEST['idtype'] == 3) {?>
					<div class="form-group">
						<label class="control-label col-md-3">Nama Dokumen *</label>
						<div class="col-md-4">
						<select name="idtypedoc" id="idtypedoc"  class="form-control input-sm validate[required]" >
								 <?php
							
								 $query = "SELECT  * from legal_typedocument where idtypedoc='".$_REQUEST['idtype']."'";
								$hasil = mysqli_query($db->dbh,$query);
								while($data=mysqli_fetch_array($hasil)){
									echo "<option value=$data[idtypedoc]> $data[description]</option>";
								}
								
								?>
								</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Status Dokumen *</label>
						<div class="col-md-4">
								<select name="jenisdoc" id="jenisdoc" value="<?php echo $jenisdoc?>" class="form-control input-sm validate[required]" required="required"/>
								<option ></option>
								
								<option  value="Draf Baru"<?php echo $jenisdoc == "Draf Baru" ? " selected" : ""?>>Draf Baru</option>
								<option  value="Review Draf"<?php echo $jenisdoc == "Review Draf" ? " selected" : ""?>>Review Draf</option>

								</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Jenis Instrumen Perjanjian *</label>
						<div class="col-md-4">
								<select name="jenisperjanjian" id="jenisperjanjian" value="<?php echo $jenisperjanjian?>" class="form-control input-sm validate[required]" required="required"/>
								<option ></option>
								
								<option value="Amandemen Perjanjian" <?php echo $jenisperjanjian == "Amandemen Perjanjian" ? " selected" : ""?>> Amandemen Perjanjian</option>
								<option value="Kesepakatan Bersama" <?php echo $jenisperjanjian == "Kesepakatan Bersama" ? " selected" : ""?>> Kesepakatan Bersama</option>
								<option value="Nota Kesepahaman" <?php echo $jenisperjanjian == "Nota Kesepahaman" ? " selected" : ""?>> Nota Kesepahaman</option>
								<option value="Perjanjian/Kontrak" <?php echo $jenisperjanjian == "Perjanjian/Kontrak" ? " selected" : ""?>> Perjanjian/Kontrak</option>
								<option value="Lain-lain" <?php echo $jenisperjanjian == "Lain-lain" ? " selected" : ""?>> Lain-lain</option>
								
								
								
								</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Rekanan *</label>
						<div class="col-md-4">
								<select name="counterpart" id="counterpart" value="<?php echo $counterpart?>" class="form-control input-sm validate[required]" required="required"/>
								<option ></option>
								<option value="SubCon Vendor" <?php echo $counterpart == "SubCon Vendor" ? " selected" : ""?>> SubCon Vendor</option>
								<option value="Kontraktor" <?php echo $counterpart == "Kontraktor" ? " selected" : ""?>> Kontraktor</option>
								<option value="Pembeli" <?php echo $counterpart == "Pembeli" ? " selected" : ""?>> Pembeli</option>						
								
								<option value="Lainnya" <?php echo $counterpart == "Lainnya" ? " selected" : ""?>> Lainnya</option>				
								
								
								</select>
						</div>
					</div>
					
					
					
					<div class="form-group">
					
						<label class="control-label col-md-3">Nama Perusahaan *</label>
						
						
						<div class="col-md-4">
								<input type="text" name="perusahaan" id="perusahaan" value="<?php echo $perusahaan?>"  class="form-control input-sm validate[required]" required="required" />
						</div>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label col-md-3">Nomor Perjanjian </label>
						<div class="col-md-4">
								<input type="text" name="nodocument" id="nodocument" value="<?php echo $nodocument?>" class="form-control input-sm" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Tanggal Perjanjian </label>
						<div class="col-md-4">
								<input type="text" name="tglsurat" id="tglsurat" value="<?php echo $tglsurat?>" class="form-control input-sm datepicker" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Judul Perjanjian *</label>
						<div class="col-md-4">
								<input type="text" name="judulperjanjian" id="judulperjanjian" value="<?php echo $judulperjanjian?>" class="form-control input-sm validate[required]" required="required" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Mata Uang *</label>
						<div class="col-md-4">
								<select name="currency" id="currency" value="<?php echo $currency?>" class="form-control input-sm validate[required]" required="required"/>
								<option ></option>
								<option value="IDR" <?php echo $currency == "IDR" ? " selected" : ""?>> IDR</option>
								<option value="USD" <?php echo $currency == "USD" ? " selected" : ""?>> USD</option>
										
								
								
								</select>
						</div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-md-3">Harga Pekerjaan<span class="required">*</span></label>
						<div class="col-md-4">
							 <input type="text" name="hargapekerjaan" id="hargapekerjaan" value="<?php echo $hargapekerjaan?>" onKeyPress="return(currencyFormat(this,',','.',event))" class="form-control input-sm validate[required]" required="required" />
					 <span class="error-span"></span>
						</div>
				</div>	
				
				

			<div class="form-group">
					  <label class="control-label col-md-3">Jangka Waktu<span class="required">*</span></label>
						<div class="col-md-4">
							 <input type="text" name="period" id="period" value="<?php echo $period?>" class="form-control input-sm validate[required]" required="required" />
					 <span class="error-span"></span>
						</div>
				</div>

			<div class="form-group">
					  <label class="control-label col-md-3">Tanggal Mulai<span class="required"></span></label>
						<div class="col-md-4">
							<input type="text" name="startdate" id="startdate" value="<?php echo $startdate?>" class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>	
				
					<div class="form-group">
					  <label class="control-label col-md-3">Tanggal Kedaluwarsa<span class="required"></span></label>
						<div class="col-md-4">
							<input type="text" name="expiredate" id="expiredate" value="<?php echo $expiredate?>"  class="form-control input-sm datepicker" />
					 <span class="error-span"></span>
						</div>
				</div>	
					
					
					<!-- <div class="form-group">
						<label class="control-label col-md-3">Perihal :</label>
						<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
								
							

									<div class="box-body">
										<textarea class="ckeditor" name="perihal" id="perihal" class="form-control"></textarea>
									</div>
								
								
							</div>
						</div> -->
								
					<div class="form-group">
										<label class="control-label col-md-3">Lokasi/Wilayah<span class="required">*</span></label>
											<div class="col-md-4">
														  <?php
															$sql = "SELECT  * from location";
															$addOpt = "<option value=\"\"></option>";
															echo create_select($sql, "locationprefix", "location", "lokasi", "", $addOpt, " class=\"form-control validate[required]\"");
															?>
														  <span class="error-span"></span>
										  </div>
											</div>	
						
						<div class="form-group">
						<label class="control-label col-md-3">Keterangan *</label>
						<div class="col-md-4">
								<textarea name="keterangan" id="keterangan"  class="form-control input-sm validate[required]"  /><?php echo $keterangan?></textarea>
						</div>
					</div>
								
						<div class="form-group">
							<label class="control-label col-md-3">Daftar Dokumen Pendukung </label>
							
							<div class="col-md-4">
								
								<?php echo $docattachment?>
							</div>
						</div>				
					
						<div class="form-group">
							<label class="control-label col-md-3" id="file">Dokumen <?php echo $description?> *</label>
							<div class="col-md-4">
								<p id="filedocument"></p>
								<input type="file" name="attachment" id="attachment" value="<?php echo $attachment?>"  class="validate[required]" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Dokumen Pendukung *</label>
							
							<div class="col-md-4">
								<p id="filename"></p>
								<input type="file" name="docpendukung" id="docpendukung" value="<?php echo $docpendukung?>" required="required" class="validate[required]" >
							</div>
						</div>							
													
												 </div>
												  </div>
												 </div> 
<!-- ------------------------------------------------------------------------------------------- -->		
									
									
									<?php } else {?>
									
								<?php if ($_REQUEST['idtype']== '1' ){?>		
					<div class="form-group">
						<label class="control-label col-md-3">Nama Dokumen *</label>
						<div class="col-md-4">
						<select name="idtypedoc" id="idtypedocks" class="form-control input-sm validate[required]" required="required" >
								 <?php
							
								 $query = "SELECT  * from legal_typedocument where idtypedoc in ('1','4')";
								$hasil = mysqli_query($db->dbh,$query);
								echo "<option > </option>";
								while($data=mysqli_fetch_array($hasil)){
									echo "<option value=$data[idtypedoc]> $data[description]</option>";
								}
								
								?>
								</select>
						</div>
					</div>
				
					
						<div class="form-group">
						<label class="control-label col-md-3">Status Dokumen *</label>
						<div class="col-md-4">
								<select name="jenisdoc" id="jenisdoc" class="form-control input-sm validate[required]" required="required"/>
								<option ></option>
								<option value="Draf Baru" > Draf Baru</option>
								<option value="Review Draf" > Review Draf</option>
								</select>
						</div>
					</div>
					
						<?php } else if ($_REQUEST['idtype']== '2' ){?>	
						
						<div class="form-group">
						<label class="control-label col-md-3">Nama Dokumen *</label>
						<div class="col-md-4">
						<select name="idtypedoc" id="idtypedoc" class="form-control input-sm validate[required]" required="required" >
								 <?php
							
								 $query = "SELECT  * from legal_typedocument where idtypedoc='".$_REQUEST['idtype']."'";
								$hasil = mysqli_query($db->dbh,$query);
								while($data=mysqli_fetch_array($hasil)){
									echo "<option value=$data[idtypedoc]> $data[description]</option>";
								}
								
								?>
								</select>
						</div>
					</div>
						
						<div class="form-group">
						<label class="control-label col-md-3">Status Dokumen *</label>
						<div class="col-md-4">
								<select name="jenisdoc" id="jenisdoc" class="form-control input-sm validate[required]" required="required" readonly />
								<option ></option>
								<!--<option value="Draf Baru" > Draf Baru</option>-->
								<option value="Review Draf" selected> Review Draf</option>
								</select>
						</div>
					</div>
					
					
						<?php } ?>	
					
					
					
					<div class="form-group">
						<?php if ($_REQUEST['idtype']== '1' ){?>
						<label class="control-label col-md-3">Nama Penerima Kuasa *</label>
						<?php } else if ($_REQUEST['idtype']== '2' ){?>	
						<label class="control-label col-md-3">Nama Penandatangan *</label>
						<?php } ?>	
						
						<div class="col-md-4">
								<input type="text" name="namapenerima" id="namapenerima" class="form-control input-sm validate[required]" required="required" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Nomor Surat </label>
						<div class="col-md-4">
								<input type="text" name="nodocument" id="nodocument" class="form-control input-sm "  />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Tanggal Surat </label>
						<div class="col-md-4">
								<input type="text" name="tglsurat" id="tglsurat" class="form-control input-sm datepicker " />
						</div>
					</div>
					
					
					<!-- <div class="form-group">
						<label class="control-label col-md-3">Perihal :</label>
						<div class="col-md-4">
						<div class="row">
							<div class="col-md-12">
								
							

									<div class="box-body">
										<textarea class="ckeditor" name="perihal" id="perihal" class="form-control"></textarea>
									</div>
								
								
							</div>
						</div> -->
						
						<div class="form-group">
						<label class="control-label col-md-3">Perihal *</label>
						<div class="col-md-4">
								<textarea name="perihal" id="perihal" class="form-control input-sm validate[required]" required="required"/></textarea>
						</div>
					</div>
				
				
					<div class="form-group">
										<label class="control-label col-md-3">Lokasi/Wilayah<span class="required">*</span></label>
											<div class="col-md-4">
														  <?php
															$sql = "SELECT  * from location";
															$addOpt = "<option value=\"\"></option>";
															echo create_select($sql, "locationprefix", "location", "lokasi", "", $addOpt, " class=\"form-control validate[required]\"");
															?>
														  <span class="error-span"></span>
										  </div>
											</div>	
											
											
										
						<div class="form-group">
							<label class="control-label col-md-3" id="file">Dokumen <?php echo $description?> *</label>
							<div class="col-md-4">
								<p id="filedocument"></p>
								<input type="file" name="attachment" id="attachment"  class="validate[required]" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Dokumen Pendukung *</label>
							<div class="col-md-4">
								<p id="filename"></p>
								<input type="file" name="docpendukung" id="docpendukung"  class="validate[required]" required="required" >
							</div>
						</div>							
													
												 </div>
												  </div>
												 </div> 
									
									<?php } ?>
								</div>
							<!-- ------------------------------------------------------------------------------------------- -->		
									
										 <div class="wizard-buttons">
											  <div class="row">
												 <div class="col-md-12">
													<div class="col-md-offset-3 col-md-9">
													 <!--  <a href="javascript:;" class="btn btn-default prevBtn">
														<i class="fa fa-arrow-circle-left"></i> Back </a>
													   <a href="javascript:;" class="btn btn-primary nextBtn">
														Continue <i class="fa fa-arrow-circle-right"></i>
													   </a>
													  --> 
													    <button type="submit" id="submit" class="btn btn-primary">Simpan</button>   
																							  
													</div>
												 </div>
											  </div>
										   </div>			
													
													
												 </div>
										
										  	 </form>
										</div>
								</div>
									</div>

					



<script type="text/javascript">
var urlData = '<?php echo $__CFG_http_apps?>index.php/data/riskheader/';
var urlSave = '<?php echo $__CFG_http_apps?>index.php/data/documentwizard_save/?idtype=<?php echo $_REQUEST['idtype']?>';
var urlSaveheader = '<?php echo $__CFG_http_apps?>index.php/data/riskheader_save/';
var urlDelete = '<?php echo $__CFG_http_apps?>index.php/data/riskheader_delete/';

var oTable;
var kodenya;

	//tampilkan jika di pilih review
	
	$(document).ready(function() {
    // Kondisi saat Form di-load
    if ($("#jenisdoc").val() == "Review Draf") {
        $('#file,#attachment').show();
		
    } else {
        $('#file,#attachment').hide(); 
	}
    // Kondisi saat ComboBox (Select Option) dipilih nilainya
    $("#jenisdoc").change(function() {
        if (this.value == "Draf Baru") {
            $('#file,#attachment').hide(); 
            $('#file,#attachment').val('');
			
        } else {
            $('#file,#attachment').show();
            $('#file,#attachment').focus();
			
        } 
    });
}); 

	$("#iddepartment").select2({
	placeholder: "pilih departemen"
		});
$(document).ready(function(){


	/* $("ul.nav nav-pills nav-justified steps").on("click","li", function(){
     alert($(this).find("span.step-name").text());
  }); */

  
	
	oTable = $("#momTable").dataTable({bSort: true,                                     
        "sPaginationType": "bs_full",
        //"bProcessing": true,
        "aoColumnDefs": [{"bSortable": false, "aTargets": [ -1]}],
        "sAjaxSource": urlData,
        "aoColumns":[{"sClass": "center"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "TAL"},
					  {"sClass": "center"},
					  {"sClass": "TAL"}]
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
	
		
	
		
	/* $('#pic').select2({
		placeholder: "Select Employee",
		blurOnChange: true,
		ajax: { 
            url: '<?php echo $__CFG_http_apps?>index.php/data/get_data?d=pic&t=department&id=<?php echo $_SESSION['department']?>',
            dataType: 'json',
            data: function (term, page) {
                console.log("term: "+term+"; page: "+ page);
                return { 
                    q: term 
                };
            },
            results: function (data, page) { return {results: data }; }
        }
	}); */
	
	//alert ('<?php echo $__CFG_http_apps?>index.php/data/get_data?d=pic&t=department&id=<?php echo $_SESSION['department']?>');
	
	
});


//for currency input form
function currencyFormat(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;
if (whichCode == 13) return true;  // Enter
if (whichCode == 8) return true;  // Delete (Bug fixed)
key = String.fromCharCode(whichCode);  // Get key value from key code
if (strCheck.indexOf(key) == -1)  return false;   // Not a valid key
len = fld.value.length;
for(i = 0; i < len; i++)
if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
aux = '';
for(; i < len; i++)
if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
aux += key;
len = aux.length;
if (len == 0) fld.value = '';
if (len == 1) fld.value = '0'+ decSep + '0' + aux;
if (len == 2) fld.value = '0'+ decSep + aux;
if (len > 2) {
aux2 = '';
for (j = 0, i = len - 3; i >= 0; i--) {
if (j == 3) {
aux2 += milSep;
j = 0;
}
aux2 += aux.charAt(i);
j++;
}
fld.value = '';
len2 = aux2.length;
for (i = len2 - 1; i >= 0; i--)
fld.value += aux2.charAt(i);
fld.value += decSep + aux.substr(len - 2, len);
}
return false;
}

//validasi angka
function checkInput(obj) 
{
    var pola = "^";
    pola += "[0-9]*";
    pola += "$";
    rx = new RegExp(pola);
 
    if (!obj.value.match(rx))
    {
        if (obj.lastMatched)
        {
		
            obj.value = obj.lastMatched;

        }
        else
        {
		
            obj.value = "";
			 alert("Just Fill Number ");
        }
    }
    else
    {
        obj.lastMatched = obj.value;
    }
}






	
	

// tampilkan data ke textbox jika combo dipilih // combobox > "Ditujukan Kepada"
 <?php echo $jsArray; ?> 
    function changeValue(EmpId){ 
    document.getElementById('idjabatan').value = dtEmp[EmpId].jab; 
    document.getElementById('iddepartment').value = dtEmp[EmpId].dept; 

    }; 
	
	//----//

</script>
