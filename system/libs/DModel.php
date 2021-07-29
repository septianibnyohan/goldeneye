<?php
/**
 * Main Model
 */
class DModel{

    protected $db = array();

    public function __construct() {
        $dsn = 'mysql: host=localhost;dbname=golden_eye';
        $user = 'root';
        $pass = '';

        $this->db = new Database($dsn, $user, $pass);
    }
}?>