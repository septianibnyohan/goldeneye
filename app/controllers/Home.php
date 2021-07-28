<?php
/**
 * Home Controller
 */
class Home extends DController {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        /*
        if (isset($_SESSION['userid'])){
            header("location:apps/index.php");
        } else {
            header("location:apps/login.php");
        }
        */
        
        if (isset($_SESSION['userid'])){
            //header("location:apps/index.php");
            $this->load->view('home/home');
        } else {
            //header("location:apps/login.php");
            //echo $__CFG_dir_class; die();
            $this->load->view('home/login');
        }
        
    }

    public function test(){
        $data = array();
        $catModel = $this->load->model("ExampleModel");
        $data['cat'] = $catModel->catList();
        $this->load->view("home/test", $data);
    }


}