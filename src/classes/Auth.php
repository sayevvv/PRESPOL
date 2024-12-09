<?php
include_once 'config/Database.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function authenticate($username, $password) {
        // Query untuk autentikasi user
        $sql = "SELECT 
                    u.user_id,
                    u.username,
                    u.password_hash,
                    u.role_id,
                    u.id_pegawai,
                    u.id_mahasiswa
                FROM [user] u 
                WHERE u.username = ?";
    
        try {
            // Gunakan fetchOne untuk mengambil data user
            $user = $this->db->fetchOne($sql, [$username]);
    
            // Verifikasi password
            if ($user && password_verify($password, $user['password_hash'])) {
                // Simpan informasi ke sesi
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role_id'];
                
                // Ambil informasi tambahan berdasarkan role
                if (in_array($user['role_id'], [1, 2])) {
                    $query = "SELECT 
                                u.username,
                                p.id_pegawai,
                                p.no_induk AS [no_induk]
                            FROM [user] u
                            JOIN pegawai p ON u.id_pegawai = p.id_pegawai
                            WHERE p.id_pegawai = ?";
                    $result = $this->db->fetchOne($query, [$user['id_pegawai']]);
                } elseif ($user['role_id'] == 3) {
                    $query = "SELECT 
                                u.username,
                                m.id_mahasiswa,
                                m.nim AS [no_induk]
                            FROM [user] u
                            JOIN mahasiswa m ON u.id_mahasiswa = m.id_mahasiswa
                            WHERE m.id_mahasiswa = ?";
                    $result = $this->db->fetchOne($query, [$user['id_mahasiswa']]);
                } else {
                    return false; // Role tidak valid
                }
                // Jika data tambahan ditemukan, simpan ke sesi
                if ($result) {
                    $_SESSION['no_induk'] = $result['no_induk'];
                    return true;
                }
            }
        } catch (Exception $e) {
            // Tangani kesalahan query
            echo "Error: " . $e->getMessage();
        }
    
        // Jika gagal autentikasi
        return false;
    }

    public static function checkLogin() {
        // Cek apakah 'role' dan 'username' ada dalam sesi
        if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
            // Jika tidak, arahkan ke halaman login
            header('Location: login.php');
            exit();
        }
    }

}

?>

