<?php
class DbModel extends DModel {

    function __construct() {
        parent::__construct();
    }

    public function dbList($table){
        $sql = "select * from $table";
        return $this->db->select($sql);
    }

    public function dbById($table, $id){
        $sql = "select * from $table where id=:id";
        $data = array(":id" => $id);

        return $this->db->select($sql, $data);
    }

    public function insertDb($table, $data){
        return $this->db->insert($table, $data);
    }

    public function dbUpdate($table, $data, $cond){
        return $this->db->update($table, $data, $cond);
    }

    public function delCatById($table, $cond){
        return $this->db->delete($table, $cond);
    }

}
?>