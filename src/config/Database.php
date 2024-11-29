<?php
class Database {
    private $serverName = 'LENOVO';
    private $connectionInfo = array( "Database"=>"PrespolTest");
    private $connection;

    public function __construct() {
        $this->connection = sqlsrv_connect($this->serverName, $this->connectionInfo);
        if ($this->connection === false) {
            die('Koneksi Gagal: ' . print_r(sqlsrv_errors(), true));
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function fetchOne($query, $params = []) {
        $stmt = sqlsrv_prepare($this->connection, $query, $params);
        if ($stmt === false || !sqlsrv_execute($stmt)) {
            throw new Exception('Kesalahan dalam query: ' . print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function executeProcedure($query, $params = []) {
        $stmt = sqlsrv_prepare($this->connection, $query, $params);
        if ($stmt === false) {
            $errors = sqlsrv_errors();
            throw new Exception('Gagal mempersiapkan query: ' . print_r($errors, true));
        }
        
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            throw new Exception('Gagal menjalankan query: ' . print_r($errors, true));
        }
        
        return true;
    }

    


    public function close() {
        sqlsrv_close($this->connection);
    }
}
?>
