<?php
class ExampleModel extends DModel {

    function __construct() {
        parent::__construct();
    }

    public function catList($table){
        $sql = "select * from $table";
        return $this->db->select($sql);
    }

    public function catById($table, $id){
        $sql = "select * from $table where id=:id";
        $data = array(":id" => $id);

        return $this->db->select($sql, $data);
    }

    public function insertCat($table, $data){
        return $this->db->insert($table, $data);
    }

    public function catList2() {
        return array(
            array(
                'catOne' => 'Education',
                'catTwo' => 'Sports',
                'catThree' => 'Health'
            ),
            array(
                'catOne' => 'Education',
                'catTwo' => 'Sports',
                'catThree' => 'Health'
            )
        );
        
    }

    public function test() {
        $sql = "select * from category";
        $query = $this->db->query($sql);
        $result = $query->fetchAll();
        return $result;
    }

    public function test2(){
        return $this->db->select('category');
    }

}
?>