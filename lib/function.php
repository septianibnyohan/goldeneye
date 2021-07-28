<?php
$_date_string = Array(
	"id" => Array(
		"day" => Array(
			0 => "Minggu",
			1 => "Senin",
			2 => "Selasa",
			3 => "Rabu",
			4 => "Kamis",
			5 => "Jum'at",
			6 => "Sabtu"),
		"month" => Array(
			1 => "Januari",
			2 => "Februari",
			3 => "Maret",
			4 => "April",
			5 => "Mei",
			6 => "Juni",
			7 => "Juli",
			8 => "Agustus",
			9 => "September",
			10 => "Oktober",
			11 => "November",
			12 => "Desember"),
		"d" => Array(
			0 => "Aha",
			1 => "Sen",
			2 => "Sel",
			3 => "Rab",
			4 => "Kam",
			5 => "Jum",
			6 => "Sab"),
		"m" => Array(
			1 => "Jan",
			2 => "Feb",
			3 => "Mar",
			4 => "Apr",
			5 => "Mei",
			6 => "Jun",
			7 => "Jul",
			8 => "Agu",
			9 => "Sep",
			10 => "Okt",
			11 => "Nov",
			12 => "Des")
	),

	"en" => Array(
		"day" => Array(
			0 => "Sunday",
			1 => "Monday",
			2 => "Tuesday",
			3 => "Wednesday",
			4 => "Thursday",
			5 => "Friday",
			6 => "Saturday"),
		"month" => Array(
			1 => "January",
			2 => "February",
			3 => "March",
			4 => "April",
			5 => "May",
			6 => "June",
			7 => "July",
			8 => "August",
			9 => "September",
			10 => "October",
			11 => "November",
			12 => "December"),
		"d" => Array(
			0 => "Sun",
			1 => "Mon",
			2 => "Tue",
			3 => "Wed",
			4 => "Thu",
			5 => "Fri",
			6 => "Sat"),
		"m" => Array(
			1 => "Jan",
			2 => "Feb",
			3 => "Mar",
			4 => "Apr",
			5 => "May",
			6 => "Jun",
			7 => "Jul",
			8 => "Aug",
			9 => "Sep",
			10 => "Oct",
			11 => "Nov",
			12 => "Dec"),
	)
);

function timeAgo($timestamp){
	$datetime1=new DateTime("now");
	$datetime2=new DateTime($timestamp);
	//$diff=date_diff($datetime1, $datetime2);
	$timemsg='1 second';
	if($diff->y > 0){
		$timemsg = $diff->y .' year'. ($diff->y > 1?"s":'');

	}
	else if($diff->m > 0){
		$timemsg = $diff->m . ' month'. ($diff->m > 1?"s":'');
	}
	else if($diff->d > 0){
		$timemsg = $diff->d .' day'. ($diff->d > 1?"s":'');
	}
	else if($diff->h > 0){
		$timemsg = $diff->h .' hour'.($diff->h > 1 ? "s":'');
	}
	else if($diff->i > 0){
		$timemsg = $diff->i .' minute'. ($diff->i > 1?"s":'');
	}
	else if($diff->s > 0){
		$timemsg = $diff->s .' second'. ($diff->s > 1?"s":'');
	}

	$timemsg = $timemsg.' ago';
	return $timemsg;
}

function create_month_select($selVal, $isEmptyOption = true, $selName = "bulan", $selId = "bulan", $selAction = "") {
	global $_date_string;

	$ret = "<select name=\"". $selName ."\" id=\"". $selId ."\"". ($selAction==""?"":$selAction) .">";
	if($isEmptyOption) $ret .= "\n<option value=\"\">--please select--</option>";
	foreach($_date_string["id"]["month"] as $key => $val) {
		$ret .= "\n<option value=\"". $key ."\"". GiveAttribute($selVal, $key, " selected=\"selected\"") .">". $val ."</option>";
	}
	$ret .= "</select>";
	
	return $ret;
}

function create_select_int($selVal, $selName, $selId, $selAction, $min, $max, $isEmptyOption = true) {
	$ret = "<select name=\"". $selName ."\" id=\"". $selId ."\"". ($selAction==""?"":$selAction) .">";
	if($isEmptyOption) $ret .= "\n<option value=\"\">--please select--</option>";
	for($i=$min;$i<=$max;$i++) {
		$ret .= "\n<option value=\"". $i ."\"". GiveAttribute($selVal, $i, " selected=\"selected\"") .">". $i ."</option>";
	}
	$ret .= "</select>";
	
	return $ret;
}

function create_select($_sql, $field_value, $field_string, $select_name, $selected_value = "", $add_option = "", $add_event = "") {
	global $db;
	
	$_row = $db->get_results($_sql);
	$_ret = "<select name=\"". $select_name ."\" id=\"". $select_name ."\" ". $add_event . ">";
	if($add_option!="")
		$_ret .= $add_option;
	if(sizeof($_row)>0) {
		foreach($_row as $r) {
			$_ret .= "<option value=\"". $r->$field_value ."\"". ($r->$field_value==$selected_value?" selected":"") .">". $r->$field_string ."</option>";
		}
	}
	$_ret .= "</select>";

	return $_ret;
}



function create_listbox($_sql, $field_value, $field_string, $select_name, $selected_value = "", $add_option = "", $add_event = "") {
	global $db;
	
	$_row = $db->get_results($_sql);
	$_ret = "<select  multiple=\"multiple\" name=\"". $select_name ."[]\" id=\"". $select_name ."\" ". $add_event . ">";
	if($add_option!="")
		$_ret .= $add_option;
	if(sizeof($_row)>0) {
		foreach($_row as $r) {
			$_ret .= "<option value=\"". $r->$field_value ."\"". ($r->$field_value==$selected_value?" selected":"") .">". $r->$field_string ."</option>";
		}
	}
	$_ret .= "</select>";

	return $_ret;
}





function create_radio($_sql, $field_value, $field_string, $group_name, $selected_value = "", $add_option = "") {
	global $db;
	
	$_row = $db->get_results($_sql);
	$_ret = "";
	$count = 0;
	if(sizeof($_row)>0) {
		foreach($_row as $r) {
			$_ret .= "<input type=\"radio\" name=\"".$group_name."\" value=\"". $r->$field_value ."\" id=\"". $group_name ."_". $count ."\"". ($r->$field_value==$selected_value?" checked=\"checked\"":"") ." />&nbsp;<span for=\"". $group_name ."_". $count ."\">". $r->$field_string ."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$count++;
		}
	}

	return ($_ret==""?"&nbsp;-":$_ret);
}

function GiveAttributeNot($elm, $value, $attr) {
	$hasil = "";
	if($elm!=$value) {
		$hasil = $attr;
	}

	return $hasil;
}

function GiveAttribute($elm, $value, $attr) {
	$hasil = "";
	if($elm==$value) {
		$hasil = $attr;
	}

	return $hasil;
}

function QuotedString($str) {
	return "'". str_replace("'", "''", $str) . "'";
}

function QuotedStringTrim($str){
	return QuotedString(trim($str));
}

function print_array($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function get_field_value($value_id, $t_name, $t_field, $whereField="", $opr="") {
	global $db;
	$whereField = $whereField == "" ? "kode" : $whereField;
	if ($opr != "") {
		$sql = "select ". $t_field ." as nama from ". $t_name ." where " . $whereField . " like('%". $value_id ."%')";
	} else {
		$sql = "select ". $t_field ." as nama from ". $t_name ." where " . $whereField . " = '". $value_id ."'";
	}
	
	$row = $db->get_row($sql);

	return $row->nama;
}

function check_extension($curdir_upload){
	$str_izin=".jpg,.gif,.txt,.xls,.JPG,.JPEG,.jpeg,.GIF,.htm,.gz,.GZ,.sql";	
	$arr_izin=split(",",$str_izin);
	while(list($key,$nilai)=each($arr_izin)){
		if(strpos($curdir_upload,$nilai)>0){
			return true;
		}	
	}
}

function UploadFile($target_path, $files) { 
	if(!file_exists($target_path) || !is_dir($target_path)) {
		mkdir($target_path);
	}
	
	if(move_uploaded_file($files['tmp_name'], $target_path . basename($files['name']))) {
		return true;
	}
	
	return false;
}

function RedirectJS($url) {
	if($url!="")
		return "<script>window.location.href = '". $url ."';</script>";
}

function Redirect($url) {
	if($url!="")
		header("location:". $url);
}

//format tanggal inputan dd-mm-yyyy
function formatDate2DB($tgl, $iswaktu = false) {
	$arrTgl = explode(" ", $tgl);
	$tgle = $arrTgl[0];
	$wkte = $arrTgl[1];

	list($tanggal, $bulan, $tahun) = explode("-", $tgle);

    if($tgl!="")
    	return $tahun ."-". $bulan ."-". $tanggal .($iswaktu?$wkte:"");
    else
        return "";
}

//format tanggal inputan yyyy-mm-dd
function formatDB2Date($tgl, $iswaktu = false, $isbahasa = false) {
    global $ArrBulan;
	$arrTgl = explode(" ", $tgl);
	$tgle = $arrTgl[0];
	$wkte = $arrTgl[1];

	list($tahun, $bulan, $tanggal) = explode("-", $tgle);

    if($tgl!="") {
        if(!$isbahasa)
        	return $tanggal ."-". $bulan ."-". $tahun .($iswaktu?" ".$wkte:"");
        else
            return $tanggal . " " . $_date_string["id"]["month"][intval($bulan)] . " " . $tahun;
    }
    else
        return "";
}

//temporary function
function getNavMenu() {
	global $__CFG_http_apps, $__var_mode, $__var_page;

	$siteid = $_SESSION["SITE_ID"];
	switch($siteid) {
		case "crm":
			?>
				<li<?=GiveAttribute($__var_mode, "crm-index", " class=\"current\"")?><?=GiveAttribute($__var_mode, "", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/crm-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute($__var_mode, "customer", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/customer/" class="typo">Daftar Pelanggan</a></li>
				<li<?=GiveAttribute($__var_mode, "schedule", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/schedule/" class="tables">Jadwal Aktivitas</a></li>
				<li<?=GiveAttribute($__var_mode, "lead", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/lead/" class="tables">Leads</a></li>
				<li<?=GiveAttribute($__var_mode, "prospek", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/prospek/" class="tables">Prospek</a></li>
				<li<?=GiveAttribute($__var_mode, "contract", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/contract/" class="tables">Kontrak</a></li>
				<li<?=GiveAttribute($__var_mode, "complain", " class=\"current\"")?><?=GiveAttribute($__var_mode, "complain_handling", " class=\"current\"")?>><a href="#support" class="support">Pelayanan Pelanggan</a>
					<span class="arrow"></span>
					<ul id="support">
						<li<?=GiveAttribute($__var_mode, "complain", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/complain/">Komplain</a></li>
						<li<?=GiveAttribute($__var_mode, "complain_handling", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/complain_handling/">Penanganan Komplain</a></li>
					</ul>
				</li>
 				<li<?=GiveAttribute($__var_mode, "penawaran", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/penawaran/" class="tables">Penawaran</a></li>
				<li<?=GiveAttribute($__var_mode, "order", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/order/" class="tables">Penjualan</a></li>
				<li<?=GiveAttribute($__var_mode, "document", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/crm/document/" class="editor">Dokumen</a></li>
				<li<?=GiveAttribute($__var_page, "master", " class=\"current\"")?>><a href="#reff" class="elements">Data Master</a>
					<span class="arrow"></span>
					<ul id="reff">
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_customer/">Tipe Customer</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_kontrak/">Tipe Kontrak</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/document_category/">Kategori Dokumen</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_alamat/">Kategori Alamat</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/campaign/">Promosi</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/complain_prioritas/">Prioritas Komplain</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/complain_status/">Status Komplain</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/jenis_industri/">Jenis Industri</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_cp/">Kategori Kontak</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_customer/">Kategori Pelanggan</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_act/">Tipe Aktivitas</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/bahasa/">Bahasa</a></li>
					</ul>
				</li>
				<li><a href="#report" class="elements">Laporan</a>
					<span class="arrow"></span>
					<ul id="report">
						<li><a href="#">Ringkasan Kontrak</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/laporan/pelanggan_order/">Ringkasan Pelanggan By Order</a></li>
                        <li><a href="<?=$__CFG_http_apps?>index.php/laporan/pelanggan_kategori/">Ringkasan Pelanggan By Kategori</a></li>
                        <li><a href="<?=$__CFG_http_apps?>index.php/laporan/pelanggan_complaint/">Ringkasan Pelanggan By Complaint / cases</a></li>
					</ul>
				</li>
			<?php
			break;
		case "reff":
			?>
				<li<?=GiveAttribute($__var_mode, "", " class=\"current\"")?><?=GiveAttribute($__var_mode, "reff-index", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/reff-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute(substr($__var_mode, 0, 4), "app_", " class=\"current\"")?>><a href="#usm" class="elements">Manajemen User</a>
					<span class="arrow"></span>
					<ul id="usm">
						<li<?=GiveAttribute(substr($__var_mode, 0, 9), "app_users", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/reff/app_users/">User</a></li>
						<li<?=GiveAttribute(substr($__var_mode, 0, 10), "app_groups", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/reff/app_groups/">User Groups</a></li>
						<li<?=GiveAttribute(substr($__var_mode, 0, 9), "app_sites", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/reff/app_sites/">Sites</a></li>
						<li<?=GiveAttribute(substr($__var_mode, 0, 9), "app_menus", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/reff/app_menus/">Application Menu</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute(substr($__var_mode, 0, 5), "param", " class=\"current\"")?>><a href="#config" class="support">Configuration</a>
					<span class="arrow"></span>
					<ul id="config">
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/system/configuration/">System</a></li> -->
 						<li<?=GiveAttribute(substr($__var_mode, 0, 5), "param", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/reff/param/">Parameters</a></li>
					</ul>
				</li>
			<?php
			break;
		case "mkt":
			?>
				<li<?=GiveAttribute($__var_mode, "mkt-index", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/mkt-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute($__var_mode, "sales", " class=\"current\"")?><?=GiveAttribute($__var_mode, "sales_schedule", " class=\"current\"")?><?=GiveAttribute($__var_mode, "penawaran", " class=\"current\"")?><?=GiveAttribute($__var_mode, "call_report", " class=\"current\"")?>><a href="#salesmenu" class="elements">Sales</a>
					<span class="arrow"></span>
					<ul id="salesmenu">
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/mkt/tim_sales/">Tim Sales</a></li> -->
						<li<?=GiveAttribute($__var_mode, "sales", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/sales/">Data Sales</a></li>
						<li<?=GiveAttribute($__var_mode, "call_report", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/call_report/">Call Report</a></li>
						<li<?=GiveAttribute($__var_mode, "sales_schedule", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/sales_schedule/">Aktivitas Sales</a></li>
						<li<?=GiveAttribute($__var_mode, "penawaran", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/penawaran/">Daftar Penawaran</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "perencanaan", " class=\"current\"")?><?=GiveAttribute($__var_mode, "target", " class=\"current\"")?><?=GiveAttribute($__var_mode, "promosi", " class=\"current\"")?><?=GiveAttribute($__var_mode, "harga", " class=\"current\"")?><?=GiveAttribute($__var_mode, "jadwal", " class=\"current\"")?><?=GiveAttribute($__var_mode, "stok", " class=\"current\"")?><?=GiveAttribute($__var_mode, "call_report_h", " class=\"current\"")?><?=GiveAttribute($__var_mode, "harga_jual", " class=\"current\"")?>><a href="#mkt" class="elements">Marketing</a>
					<span class="arrow"></span>
					<ul id="mkt">
						<li<?=GiveAttribute($__var_mode, "call_report_h", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/call_report_h/">Call Report</a></li>
						<li<?=GiveAttribute($__var_mode, "perencanaan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/perencanaan/">Perencanaan</a></li>
						<li<?=GiveAttribute($__var_mode, "target", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/target/">Target</a></li>
						<li<?=GiveAttribute($__var_mode, "promosi", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/promosi/">Promosi</a></li>
						<li<?=GiveAttribute($__var_mode, "stok", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/stok/">Stok Sales</a></li>
						<li<?=GiveAttribute($__var_mode, "harga_jual", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/harga_jual/">Harga Jual (Sales)</a></li>
						<li<?=GiveAttribute($__var_mode, "jadwal", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/jadwal/">Jadwal</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "produk", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/produk/" class="typo">Daftar Produk</a></li>
				<li<?=GiveAttribute($__var_mode, "harga_jual_sales", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/harga_jual_sales/" class="typo">Harga Jual</a></li>
				<li<?=GiveAttribute($__var_mode, "usulan_pengadaan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/usulan_pengadaan/" class="typo">Usulan Pengadaan</a></li>
				<li<?=GiveAttribute($__var_mode, "order", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/order/" class="support">Sales Order</a></li>
				<li<?=GiveAttribute($__var_mode, "document", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/mkt/document/" class="editor">Dokumen</a></li>
				<li<?=GiveAttribute($__var_page, "master", " class=\"current\"")?>><a href="#reff" class="elements">Data Master</a>
					<span class="arrow"></span>
					<ul id="reff">
						<li><a href="<?=$__CFG_http_apps?>index.php/master/campaign/">Data Campaign</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/supplier/">Supplier</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/merk/">Merk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/warehouse/">Warehouse</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_produk/">Kategori Produk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/document_category/">Kategori Dokumen</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_act/">Tipe Aktivitas</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/cabang/">Cabang</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/jabatan/">Jabatan</a></li>
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/master/produk/">Produk</a></li> -->
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_target/">Kategori Target</a></li>
					</ul>
				</li>
				<li><a href="#config" class="elements">Laporan</a>
					<span class="arrow"></span>
					<ul id="config">
						<li><a href="<?=$__CFG_http_apps?>index.php/laporan/sales_product/">Laporan Sales By Product</a></li>
                        <li><a href="<?=$__CFG_http_apps?>index.php/laporan/sales_customer/">Laporan Sales By Customer</a></li>
                        <li><a href="<?=$__CFG_http_apps?>index.php/laporan/sales_time/">Laporan Sales By Time</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/laporan/sales_value/">Laporan Sales By Value</a></li>
                        <li><a href="<?=$__CFG_http_apps?>index.php/laporan/sales_paymen_status/">Laporan Sales By Payment Status</a></li>
					</ul>
				</li>
			<?php
			break;
		case "sell":
			?>
				<li<?=GiveAttribute($__var_mode, "sell-index", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/sell-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute($__var_mode, "produk", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/produk/" class="typo">Daftar Produk</a></li>
				<li<?=GiveAttribute($__var_mode, "harga_costing", " class=\"current\"")?>><a href="#hargamenu" class="elements">Harga Produk</a>
					<span class="arrow"></span>
					<ul id="hargamenu">
						<li<?=GiveAttribute($__var_mode, "harga_costing", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/harga_costing/">Costing</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "vendor", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/vendor/" class="typo">Daftar Supplier</a></li>
				<li<?=GiveAttribute($__var_mode, "pr", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/pr/" class="typo">Daftar PR</a></li>
				<li<?=GiveAttribute($__var_mode, "permintaan_penawaran", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/permintaan_penawaran/" class="typo">Permintaan Penawaran</a></li>
				<li<?=GiveAttribute($__var_mode, "vendor_offer", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/vendor_offer/" class="typo">Penawaran Supplier</a></li>
				<li<?=GiveAttribute($__var_mode, "pengadaan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/pengadaan/" class="elements">Daftar Pengadaan</a></li>
				<!-- <li<?=GiveAttribute($__var_mode, "pengadaan", " class=\"current\"")?><?=GiveAttribute($__var_mode, "pengadaan_usulan", " class=\"current\"")?><?=GiveAttribute($__var_mode, "pengadaan_rutin", " class=\"current\"")?>><a href="#pengadaanmenu" class="elements">Pengadaan</a>
					<span class="arrow"></span>
					<ul id="pengadaanmenu">
						<li<?=GiveAttribute($__var_mode, "pengadaan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/pengadaan/">Daftar Pengadaan</a></li>
						<li<?=GiveAttribute($__var_mode, "pengadaan_usulan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/pengadaan_usulan/">Usulan</a></li>
						<li<?=GiveAttribute($__var_mode, "pengadaan_rutin", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/pengadaan_rutin/">Kebutuhan/Rutin</a></li>
					</ul>
				</li> -->
				<li<?=GiveAttribute($__var_mode, "jadwal_pembelian", " class=\"current\"")?><?=GiveAttribute($__var_mode, "jadwal_penerimaan", " class=\"current\"")?>><a href="#jadwalmenu" class="elements">Jadwal Purchasing</a>
					<span class="arrow"></span>
					<ul id="jadwalmenu">
						<li<?=GiveAttribute($__var_mode, "jadwal_pembelian", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/jadwal_pembelian/">Jadwal Pembelian</a></li>
						<li<?=GiveAttribute($__var_mode, "jadwal_penerimaan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/jadwal_penerimaan/">Jadwal Penerimaan Barang</a></li>
					</ul>
				</li>
				<!-- <li<?=GiveAttribute($__var_mode, "invoice_control", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/invoice_control/" class="editor">Invoice Control</a></li> -->
				<li<?=GiveAttribute($__var_mode, "document", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/sell/document/" class="editor">Dokumen</a></li>
				<li<?=GiveAttribute($__var_page, "master", " class=\"current\"")?>><a href="#reff" class="elements">Data Master</a>
					<span class="arrow"></span>
					<ul id="reff">
						<li><a href="<?=$__CFG_http_apps?>index.php/master/campaign/">Data Campaign</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/supplier/">Supplier</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/merk/">Asal Produk (Negara)</a></li>
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/master/merk/">Merk</a></li> -->
						<li><a href="<?=$__CFG_http_apps?>index.php/master/warehouse/">Warehouse</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_produk/">Kategori Produk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/document_category/">Kategori Dokumen</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_act/">Tipe Aktivitas</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/cabang/">Cabang</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/jabatan/">Jabatan</a></li>
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/master/produk/">Produk</a></li> -->
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_target/">Kategori Target</a></li>
					</ul>
				</li>
				<li><a href="#config" class="elements">Laporan</a>
					<span class="arrow"></span>
					<ul id="config">						
						<li><a href="<?=$__CFG_http_apps?>index.php/laporan/pembelian_produk/">Laporan Pembelian By Produk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/laporan/pembelian_do/">Laporan Pembelian By DO</a></li>
					</ul>
				</li>
			<?php
			break;
		case "wh":
			?>
				<li<?=GiveAttribute($__var_mode, "wh-index", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/wh-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute($__var_mode, "produk", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/produk/" class="typo">Daftar Produk</a></li>
				<li<?=GiveAttribute($__var_mode, "sales_order", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/sales_order/" class="typo">Sales Order</a></li>
				<!-- <li<?=GiveAttribute($__var_mode, "usulan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/usulan/" class="typo">Permintaan Pengadaan</a></li> -->
				<li<?=GiveAttribute($__var_mode, "pr", " class=\"current\"")?><?=GiveAttribute($__var_mode, "usulan", " class=\"current\"")?>><a href="#permintaan_pengadaan" class="typo">Permintaan Pengadaan</a>
					<span class="arrow"></span>
					<ul id="permintaan_pengadaan">
						<li<?=GiveAttribute($__var_mode, "pr", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pr/">Purchase Request</a></li>
						<li<?=GiveAttribute($__var_mode, "usulan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/usulan/">Usulan Pengadaan</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "penerimaan_barang", " class=\"current\"")?><?=GiveAttribute($__var_mode, "mutasi_terima", " class=\"current\"")?>><a href="#penerimaan_barang" class="typo">Penerimaan Barang</a>
					<span class="arrow"></span>
					<ul id="penerimaan_barang">
						<li<?=GiveAttribute($__var_mode, "penerimaan_barang", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/penerimaan_barang/">Supplier</a></li>
						<li<?=GiveAttribute($__var_mode, "mutasi_terima", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/mutasi_terima/">Mutasi</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "pengembalian_barang", " class=\"current\"")?><?=GiveAttribute($__var_mode, "pengembalian_barang_ret", " class=\"current\"")?>><a href="#pengembalian_barang" class="elements">Pengembalian Barang</a>
					<span class="arrow"></span>
					<ul id="pengembalian_barang">
						<li<?=GiveAttribute($__var_mode, "pengembalian_barang_ret", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pengembalian_barang_ret/">Return</a></li>
						<li<?=GiveAttribute($__var_mode, "pengembalian_barang", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pengembalian_barang/">Reject</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_mode, "pengiriman_barang", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pengiriman_barang/" class="elements">Pengiriman Barang</a></li>
				<!-- <li<?=GiveAttribute($__var_mode, "pengiriman_so", " class=\"current\"")?><?=GiveAttribute($__var_mode, "pengiriman_barang", " class=\"current\"")?>><a href="#pengiriman_barang" class="elements">Pengiriman Barang</a>
					<span class="arrow"></span>
					<ul id="pengiriman_barang">
						<li<?=GiveAttribute($__var_mode, "pengiriman_so", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pengiriman_so/">Sales Order</a></li>
						<li<?=GiveAttribute($__var_mode, "pengiriman_barang", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/pengiriman_barang/">Pengiriman Barang</a></li>
					</ul>
				</li> -->
				<li<?=GiveAttribute($__var_mode, "mutasi", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/mutasi/" class="typo">Mutasi Produk</a></li>
				<li<?=GiveAttribute($__var_mode, "produk_proses", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/produk_proses/" class="typo">Proses Produksi</a></li>
				<li<?=GiveAttribute($__var_mode, "produk_stok", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/produk_stok/" class="editor">Stock Opname</a></li>
				<li<?=GiveAttribute($__var_mode, "document", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/document/" class="editor">Dokumen</a></li>
				<li<?=GiveAttribute($__var_mode, "data_sopir", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/data_sopir/" class="typo">Data Pengemudi</a></li>
				<li<?=GiveAttribute($__var_mode, "data_angkutan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/wh/data_angkutan/" class="typo">Data Angkutan/Kendaraan</a></li>
				<li<?=GiveAttribute($__var_page, "master", " class=\"current\"")?>><a href="#reff" class="elements">Data Master</a>
					<span class="arrow"></span>
					<ul id="reff">
						<li><a href="<?=$__CFG_http_apps?>index.php/master/campaign/">Data Campaign</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/supplier/">Supplier</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/merk/">Merk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/warehouse/">Warehouse</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_produk/">Kategori Produk</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/document_category/">Kategori Dokumen</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/tipe_act/">Tipe Aktivitas</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/cabang/">Cabang</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/master/jabatan/">Jabatan</a></li>
						<!-- <li><a href="<?=$__CFG_http_apps?>index.php/master/produk/">Produk</a></li> -->
						<li><a href="<?=$__CFG_http_apps?>index.php/master/kategori_target/">Kategori Target</a></li>
					</ul>
				</li>
				<li><a href="#config" class="elements">Laporan</a>
					<span class="arrow"></span>
					<ul id="config">
						<li><a href="<?=$__CFG_http_apps?>index.php/report/order/">Laporan Pesanan</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/report/perencanaan/">Laporan Perencanaan</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/report/promosi/">Ringkasan Promosi</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/report/penawaran/">Ringkasan Penawaran</a></li>
						<li><a href="<?=$__CFG_http_apps?>index.php/report/harga/">Ringkasan Daftar Harga</a></li>
					</ul>
				</li>
			<?php
			break;
			case "fin":
			?>
				<li<?=GiveAttribute($__var_mode, "wh-index", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/home/fin-index/" class="widgets">Dashboard</a></li>
				<li<?=GiveAttribute($__var_mode, "sales_order", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/sales_order/" class="widgets">Sales Order</a></li>
				<li<?=GiveAttribute($__var_mode, "credit_monitor", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/credit_monitor/" class="widgets">Credit Monitoring</a></li>
				<li<?=GiveAttribute($__var_mode, "produk", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/produk/" class="widgets">Daftar Produk</a></li>
				<li<?=GiveAttribute($__var_mode, "inv_tukar_faktur", " class=\"current\"")?><?=GiveAttribute($__var_mode, "inv_customer", " class=\"current\"")?><?=GiveAttribute($__var_mode, "inv_supplier", " class=\"current\"")?>><a href="#invoice" class="elements">Invoice</a>
					<span class="arrow"></span>
					<ul id="invoice">
						<li<?=GiveAttribute($__var_mode, "inv_customer", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/inv_customer/">Customer</a></li>
						<li<?=GiveAttribute($__var_mode, "inv_tukar_faktur", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/inv_tukar_faktur/">Tukar Faktur</a></li>
						<li<?=GiveAttribute($__var_mode, "inv_supplier", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/fin/inv_supplier/">Supplier</a></li>
					</ul>
				</li>
				<li<?=GiveAttribute($__var_page, "laporan", " class=\"current\"")?>><a href="#config" class="elements">Laporan</a>
					<span class="arrow"></span>
					<ul id="config">
						<li<?=GiveAttribute($__var_mode, "Piutang Customer", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/laporan/fin_piutang_customer/">Piutang Customer</a></li>
						<li<?=GiveAttribute($__var_mode, "Pembayaran Invoice Per Bulan", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/laporan/fin_bayar_bulan/">Summary Pembayaran Invoice Per Bulan</a></li>
						<li<?=GiveAttribute($__var_mode, "Pengadaan Barang", " class=\"current\"")?>><a href="<?=$__CFG_http_apps?>index.php/laporan/fin_pengadaan/">Summary Pengadaan Barang</a></li>
					</ul>
				</li>
			<?php
			break;
	}
	
	return $menus;
}

function updateStok($id_produk, $id_warehouse, $stok_kg, $stok_package, $mode = "add") {
	global $db, $auth;
	
	$SQL = "select * from wh_stok";
	$data = new GCD($SQL);
	
	$row = $data->getSingleData("id_produk = ". QuotedStringTrim($id_produk) ." and id_warehouse = ". QuotedStringTrim($id_warehouse));
	if(count($row) > 0) {
		$currStokKg = (int)$row->stok_kg;
		$currStokPackage = (int)$row->stok_package;
	}
	if($mode=="add") {
		$newStokKg = $currStokKg + (int) $stok_kg;
		$newStokPackage = $currStokPackage + (int) $stok_package;
	}
	else {
		$newStokKg = $currStokKg - (int) $stok_kg;
		$newStokPackage = $currStokPackage - (int) $stok_package;
	}
	
	$fldUpdate = array("stok_kg","stok_package","modified_by","modified_on");
	$valUpdate = array($newStokKg,$newStokPackage,$auth->getUserID(),date("Y-m-d h:i:s"));
	$whrUpdate = "id_produk = ". QuotedStringTrim($id_produk) . " and id_warehouse = ". QuotedStringTrim($id_warehouse);	
	$data->updateData("wh_stok", $fldUpdate, $valUpdate, $whrUpdate);
	
	$kodeDetail = $data->getNewCode("wh_stok_history", "id_stok_history", date("Ym"), "12");
	$fldInsert = array("id_stok_history","id_produk","id_warehouse","stok_kg","stok_package","tipe","created_by","created_on");
	$valInsert = array($kodeDetail,$kode,$warehouse,$newStokKg,$newStokPackage,"UPDATE_STOCK",$auth->getUserID(),date("Y-m-d h:i:s"));
	$data->insertData("wh_stok_history", $fldInsert, $valInsert);
}

function ComboMenu($kode_induk, $selected, $cstrip = -1) {
	global $db;
	$cstrip++;
	$sql = "select * from app_menus where (kode_induk ". ($kode_induk==""?"IS NULL or kode_induk = ''":"= ". QuotedStringTrim($kode_induk)) . ") order by kode_induk, kode_app_menus";
	$row = $db->get_results($sql);
	$count = sizeof($row);
	if($count>0) {
		foreach($row as $r) {
			$menu = "<option value=\"".$r->kode_app_menus."\" ".($r->kode_app_menus==$selected?"selected=\"selected\"":"").">";
			for($i=0;$i<$cstrip;$i++) $menu .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			//$menu .= "|-- ";
			
			$menu .= $r->nama;
			$menu .= "</option>";
			echo $menu;
			ComboMenu($r->kode_app_menus, $selected, $cstrip);
		}
	}
}

function GetNodeStrip($kode_menus, $cstrip = -1) {
	global $db;
	$cstrip++;
	$sql = "select kode_induk from app_menus where kode_app_menus = ". QuotedStringTrim($kode_menus);
	$row = $db->get_results($sql);
	if(count($row) > 0) 
		foreach($row as $r) $kode_induk = $r->kode_induk;
		
	if($kode_induk!="") {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		GetNodeStrip($kode_induk, $cstrip);
	}
}

function getNewInvoiceNo() {
	global $db;
	$codelength = 9;
	$prefix = date("y-m");
	
	$sql = "select max(no_invoice) as maxno from fin_invoice where no_invoice like '".$prefix."%'";
	$row = $db->get_row($sql);
	
	if($row->maxno=="") {
		$countcode = 1;
	}
	else {
		$code = substr($row->maxno, strlen($prefix));
		$countcode = ($code) + 1;
	}
	
	$newcode = $prefix . str_pad($countcode, $codelength-strlen($prefix), "0", STR_PAD_LEFT);
	
	return $newcode;
}
?>