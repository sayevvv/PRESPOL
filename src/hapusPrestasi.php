<?php
header('Content-Type: text/plain'); // Ubah header menjadi text/plain

include_once 'classes/User.php';
include_once 'classes/Admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $idPrestasi = $_POST['id_prestasi'] ?? null;
        $deskripsi = htmlspecialchars($_POST['alasan'] ?? '');

        if (!$idPrestasi || !$deskripsi) {
            throw new Exception('ID Prestasi atau alasan tidak valid.');
        }

        $admin = new Admin();
        $result = $admin->softDelete($idPrestasi, $deskripsi);

        if ($result === false) {
            throw new Exception('Gagal menghapus data prestasi.');
        }

        // Kirim pesan sukses langsung
        echo 'Data berhasil dihapus!';
    } catch (Exception $e) {
        // Kirim pesan error langsung
        echo $e->getMessage();
    }
} else {
    echo 'Metode request tidak valid.';
}
