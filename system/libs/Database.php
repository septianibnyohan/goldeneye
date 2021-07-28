<?php
/**
 * Class Database
 */
class Database extends PDO {

    public function __construct() {
        $dsn = 'mysql:dbname=db_mvc; host=localhost';
        $user = 'root';
        $pass = '';
        parent::__construct($dsn, $user, $pass);
    }

}
?>