<?php
/**
 * Class Database
 */
class Database extends PDO {

    public function __construct($dsn, $user, $pass) {
        parent::__construct($dsn, $user, $pass);
    }

    public function select($sql, $data = array(), $fetchStyle = PDO::FETCH_ASSOC){
        /*
        $sql = "select * from $table";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        */
        $stmt = $this->prepare($sql);

        foreach ($data as $key => &$value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();
        $res = $stmt->fetchAll($fetchStyle);
        
        return $res;
    }

    public function insert($table, $data){
        $keys   = implode(",", array_keys($data));
        $values = ":".implode(", :", array_keys($data));

        //echo $keys."<br>";
        //echo $values."<br>";
        //die();

        $sql = "INSERT INTO $table($keys) VALUES($values)";
        echo "$sql<br>";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => &$value) {

            $stmt->bindParam(":$key", $value);  
        }

        $res = $stmt->execute();
        return $res;
    }

    public function update($table, $data, $cond){
        $updateKeys = NULL;
        foreach ($data as $key => $value){
            $updateKeys .= "$key=:$key,";
        }
        $updateKeys = rtrim($updateKeys, ",");

        $sql = "UPDATE $table SET $updateKeys WHERE $cond";
        $stmt = $this->prepare($sql);
        
        foreach ($data as $key => &$value) {
            $stmt->bindParam($key, $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $cond, $limit = 1){
        $sql = "DELETE FROM $table WHERE $cond LIMIT $limit";
        return $this->exec($sql);
    }

}
?>