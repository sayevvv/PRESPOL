<?php 
include_once 'config/Database.php';

abstract class User {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    abstract public function sidebar();

    abstract public function mainContent($username);

}
?>