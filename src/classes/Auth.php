<?php
session_start();
include_once 'config/Database.php';

class Auth {
    private $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function authenticate($username, $password) {

        $sql = "SELECT u.user_id, u.username, u.password, r.role_id 
                FROM [user] u
                JOIN role r ON u.role_id = r.role_id
                WHERE u.username = ?";
        
        $stmt = sqlsrv_prepare($this->connection, $sql, [$username]);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_execute($stmt)) {
            $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role_id'];
                return true;
            }
        }

        return false;
    }

    public static function checkLogin() {
        // Cek apakah 'role' dan 'username' ada dalam sesi
        if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
            // Jika tidak, arahkan ke halaman login
            header('Location: login.html');
            exit();
        }
    }
}

?>

