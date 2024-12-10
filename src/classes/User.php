<?php 
include_once 'config/Database.php';

abstract class User {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    abstract public function sidebar();

    abstract public function mainContent();

    abstract function profile();

    abstract function listPrestasi($search = '', $filterKategori = '', $filterJuara = '', $filterJurusan = '', $sort = 'newest');

    abstract public function profilDetail();

    abstract public function getPrestasiDetail($id_prestasi);
}
?>