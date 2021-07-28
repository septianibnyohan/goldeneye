<?php
class GCD {
	var $__sql;
	
	/**
	* GCD()
	* initiate class with/without sql statement
	* @param string $sql
	*/
	function __construct($sql = "") {
		$this->__sql = $sql;
	}

	/**
	* listAllData()
	* get all data with condition
	* @param mixed $whr
	* @return
	*/
	function listAllData($whr = "") {
		global $db;
		
		$sql = $this->__sql . ($whr!=""?" where " . $whr:"");

		$row = $db->get_results($sql);

		return $row;
	}

	/**
	* listData()
	* get list data with condition, offset and limit data, sort command and sort order
	* @param mixed $whr, string $sortorder, int $offset, int $limit, string $sortcommand
	* @return
	*/
	function listData($whr = "", $sortorder = "", $offset = 0, $limit = 100, $sortcommand = "asc") {
		global $db;

		if($sortorder!="")
			$sortorder = "". $sortorder ." ". $sortcommand;

		$sql = $this->__sql . ($whr==""?"":" where ". $whr) .
				($sortorder==""?"":" order by ". $sortorder) .
				" limit ". $offset .", ". $limit;

		$row = $db->get_results($sql);
		
		return $row;
	}

	/**
	* countListData()
	* get size of row data
	* @param string $whr
	* @return sizeof row data
	*/
	function countListData($whr = "") {
		global $db;
		
		return count($this->listAllData($whr));
	}
	
	/**
	* getNewCode()
	* get new code of data
	* @param string $tablename, string $fieldif, string $prefix, int $codelength
	* @return
	*/
	function getNewCode($tablename, $fieldid, $prefix, $codelength) {
		global $db;
		
		$sql = "select max(".$fieldid.") as maxcode from ". $tablename ." where ".$fieldid." like '".$prefix."%'";
		$row = $db->get_row($sql);
		
		if($row->maxcode=="") {
			$countcode = 1;
		}
		else {
			$code = substr($row->maxcode, strlen($prefix));
			$countcode = ($code) + 1;
		}
		
		$newcode = $prefix . str_pad($countcode, $codelength-strlen($prefix), "0", STR_PAD_LEFT);
		
		return $newcode;
	}

	function checkDuplicateKey($keyField, $valueField) {
		global $db;

		$sql = $this->__sql ." where ". $keyField ." = '" . $valueField . "'";
		if (count($db->get_row($sql)) > 1){
			return false;
		}else{
			return true;
		}
	}

	function getSingleData($where) {
		global $db;


		$sql = $this->__sql . ($where!=""?" where " . $where:"");
		$row = $db->get_row($sql);

		//echo $sql."<br>";
		//var_dump($db); die();

		return $row;
	}

	function insertData($tablename, $arrFields, $arrVals, $newcode = "") {
		global $db;

		$contentnewcode = "";
		if(sizeof($arrFields)>0 && sizeof($arrVals)>0) {
			$db->create_insert($tablename);
			for($x=0;$x<sizeof($arrFields);$x++) {
				if($arrVals[$x]!="")
					$db->add_insert($arrFields[$x], $arrVals[$x]);
			}
			$que = $db->execute();
			$row = $db->get_row("select @@IDENTITY as newcode"); //if code is auto number
			if($row->newcode!="")
				$contentnewcode = $row->newcode; // if code is not auto number else use $row-><code_field>
			else
				$contentnewcode = $newcode;
		}

		return $contentnewcode;
	}

	function updateData($tablename, $arrFields, $arrVals, $conds) {
		global $db;

		if(sizeof($arrFields)>0 && sizeof($arrVals)>0) {
			$db->create_update($tablename);
			for($x=0;$x<sizeof($arrFields);$x++) {
				$db->add_update($arrFields[$x], $arrVals[$x]);
			}

			$db->set_condition($conds);
			$db->execute();
		}
	}

	function deleteData($tablename, $fieldKey, $kode) {
		global $db;
		
		$sql = "delete from ". $tablename ." where " . $fieldKey . " = '". $kode ."'";
		$db->query($sql);
	}

	function deleteAllData($tablename, $where) {
		global $db;

		$sql = "delete from ". $tablename ." where " . $where;
		$db->query($sql);
	}
	
	function insertTogether($tablename, $fieldKey, $select) {
		global $db;
		
		$sql = "Insert Into ". $tablename ." (" . $fieldKey . ")(".$select.")";
		$db->query($sql);
	}
	
}
?>
