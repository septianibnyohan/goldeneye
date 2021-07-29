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
        $dbModel = $this->load->model("DbModel");
        $wew = $dbModel->dbList('document_type');
        $data['document_types'] = $dbModel->dbList('document_type');
        $data['document_status'] = $dbModel->dbList('document_status');
        $data['location'] = $dbModel->dbList('location');

        //var_dump($wew); die();
        $this->load->view('request/index', $data);
        
    }

    public function list()
    {
        $dbModel = $this->load->model("DbModel");
        $wew = $dbModel->dbList('document_type');
        $data['document_types'] = $dbModel->dbList('document_type');
        $data['document_status'] = $dbModel->dbList('document_status');
        $data['location'] = $dbModel->dbList('location');

        //var_dump($wew); die();
        $this->load->view('request/list', $data);
    }

    public function listData()
    {
        $dbModel = $this->load->model("DbModel");
        $requestList = $dbModel->dbList('request');

        $result = array();

        $i = 1;
        foreach($requestList as $req){
            $result['aaData'][] = array($i++, $req['document_type'], $req['document_name'],$req['document_status'], 
                $req['document_number'],$req['document_date'],$req['subject'],$req['subject'],$req['created_date']);
        }

        echo json_encode($result);
    }

    public function submit(){
        $document_type = $_POST["document_type"];
        $document_name = $_POST["document_name"];
        $document_status = $_POST["document_status"];
        $document_number = $_POST["document_number"];
        $document_date = $_POST["document_date"];
        $subject = $_POST["subject"];
        $location = $_POST["location"];

        $data = array(
            'document_type' => $document_type,
            'document_name' => $document_name,
            'document_status' => $document_status,
            'document_number' => $document_number,
            'document_date' => $document_date,
            'subject' => $subject,
            'location' => $location
        );

        $dbModel = $this->load->model("DbModel");
        $dbModel->insertDb('request', $data);
        header("Location: ".BASE_URL."request/list");
    }

    public function test(){
        $data = array();
        $catModel = $this->load->model("ExampleModel");

        $this->load->view("home/test", $data);
    }


}