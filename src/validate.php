<?php
include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';

header('Content-Type: application/json'); // Set header JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $validasiAdmin = new Admin($db);

        $id_pending = isset($_POST['id_pending']) ? (int)$_POST['id_pending'] : 0;
        $status = $_POST['status'];
        $deskripsi = $_POST['deskripsi'] ?? '';

        if ($id_pending <= 0) {
            throw new Exception("Invalid ID Pending");
        }

        // Memvalidasi atau menolak prestasi berdasarkan status
        $result = $validasiAdmin->validatePrestasi($id_pending, $status, $deskripsi);

        echo json_encode(['status' => 'success', 'message' => $result]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

