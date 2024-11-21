<?php 
class Database {
    private $serverName = 'LENOVO';
    private $connectionInfo = array( "Database"=>"PrespolTest");
    private $connection;

    public function __construct(){
        $this->connection = sqlsrv_connect($this->serverName, $this->connectionInfo);
        if ($this->connection === false){
            die('Koneksi Gagal');
        }
    }


    public function getConnection(){
        return $this->connection;
    }

    public function fetchOne($query, $params = []) {
        $stmt = sqlsrv_prepare($this->connection, $query, $params);
        if ($stmt === false || !sqlsrv_execute($stmt)) {
            throw new Exception('Kesalahan dalam query: ' . print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $values = array_values($data);

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = sqlsrv_prepare($this->connection, $query, $values);

        if ($stmt === false || !sqlsrv_execute($stmt)) {
            throw new Exception("Gagal menyimpan data: " . print_r(sqlsrv_errors(), true));
        }

        return true;
    }

    public function close() {
        sqlsrv_close($this->connection);
    }
}
?>