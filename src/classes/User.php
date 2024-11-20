<?php 
include_once 'config/Database.php';

abstract class User {

    public function __construct(){

    }

    abstract public function sidebar();

    abstract public function mainContent($username);

}
?>