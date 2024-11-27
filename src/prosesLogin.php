<?php 
include_once 'classes/Auth.php';
include_once 'classes/CSRFToken.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->validateToken($_POST['csrf_token'])) {
        header("HTTP/1.1 403 Forbidden");
        die("Invalid CSRF Token");
    }
    
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