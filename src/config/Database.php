<?php 
class Database {
    private $serverName = 'ARCH';
    private $connectionInfo = array( "Database"=>"Prespol");
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
}
?>