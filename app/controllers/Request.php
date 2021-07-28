<?php
/**
 * Request Controller
 */
class Request extends DController {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('request/index');
        
    }

    public function test(){
        $data = array();
        $catModel = $this->load->model("ExampleModel");
        $data['cat'] = $catModel->catList();
        $this->load->view("home/test", $data);
    }


}