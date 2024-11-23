<?php 
session_start();
include_once 'Auth.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Auth();
    if ($login->authenticate($username, $password)) {
        header('Location: home.php');
        exit;
    } else {
        header('Location: login.html');
    }
}
?>