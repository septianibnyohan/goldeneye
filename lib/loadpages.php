<?php
class LoadPages {
  var $__VAR_web_path;
  var $__VAR_page;
  var $__VAR_mode;
  var $__VAR_code;
  var $__VAR_currpage;
  var $__VAR_nextpage;
  var $__VAR_curroffset;
  var $__VAR_segmen;

  function __construct($path) {
    if($path!="")
      $this->__VAR_web_path = substr($path, 1);
    $this->ParseWebPath();
  }

  function ParseWebPath() {
    $arrWp = array();
	
    if($this->__VAR_web_path!="")
    	$arrWp = explode("/", $this->__VAR_web_path);
		
    $this->__VAR_page = $arrWp[0];
    $this->__VAR_mode = $arrWp[1];
    $this->__VAR_code = $arrWp[2];
    $this->__VAR_curroffset = $arrWp[4];
    $this->__VAR_currpage = $arrWp[3];
    $this->__VAR_nextpage = $arrWp[5];
	$this->__VAR_segmen = $arrWp;
  }

  function get_page() {
    return $this->__VAR_page;
  }

  function get_mode() {
    return $this->__VAR_mode;
  }

  function get_code() {
    return $this->__VAR_code;
  }
  
  function get_segmen($index) {
    return $this->__VAR_segmen[$index];
  }
}
?>
