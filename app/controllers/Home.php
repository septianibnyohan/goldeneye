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

    public function logout(){
        if ($_SESSION['userid']) {
            global $__CFG_http_apps;
            $query = new GCD("SELECT * from users WHERE hide=0 AND username = ".QuotedStringTrim($__VAR_username));
            //$users = $query->getSingleData("");
            $query->updateData("logged_in_user", array("is_login", "logout_date"), array(0, date("Y-m-d H:i:s")), "user_id = ".$_SESSION['userid']." And is_login = 1");
            session_destroy();
            header("location: " . $__CFG_http_apps);
        }
    }

    public function test(){
        $data = array();
        $catModel = $this->load->model("ExampleModel");
        $data['cat'] = $catModel->catList();
        $this->load->view("home/test", $data);
    }


}