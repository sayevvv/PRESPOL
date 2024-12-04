<?php

class CSRFToken
{
    private $sessionKey;

    /**
     * Konstruktor
     * @param string $sessionKey Kunci untuk menyimpan token dalam sesi
     */
    public function __construct($sessionKey = 'csrf_token')
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(); // Pastikan sesi aktif
        }
        $this->sessionKey = $sessionKey;
    }

    /**
     * Menghasilkan token CSRF
     * @return string Token CSRF yang dihasilkan
     */
    public function generateToken()
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = bin2hex(random_bytes(32));
        }
        return $_SESSION[$this->sessionKey];
    }

    /**
     * Memvalidasi token CSRF yang dikirimkan
     * @param string $token Token yang diterima dari klien
     * @return bool True jika token valid, false jika tidak
     */
    public function validateToken($token)
    {
        return isset($_SESSION[$this->sessionKey]) && hash_equals($_SESSION[$this->sessionKey], $token);
    }

    /**
     * Menghapus token setelah digunakan (opsional)
     */
    public function clearToken()
    {
        unset($_SESSION[$this->sessionKey]);
    }
}

?>
