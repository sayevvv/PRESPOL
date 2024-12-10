<?php
include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';

header('Content-Type: application/json'); // Set header JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $id_pending = isset($_POST['id_pending']) ? (int)$_POST['id_pending'] : 0;
        $no_induk = ($_POST['no_induk']);
        $status = $_POST['status'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        
        $validasiAdmin = new Admin($no_induk);
        
        if ($id_pending <= 0) {
            throw new Exception("Invalid ID Pending");
        }

        // Memvalidasi atau menolak prestasi berdasarkan status
        $result = $validasiAdmin->validatePrestasi($id_pending, $status, $deskripsi, $no_induk);

        echo json_encode(['status' => 'success', 'message' => $result]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

