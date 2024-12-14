<?php
session_start();
include_once 'config/Database.php';
include_once 'classes/Auth.php';
Auth::checkLogin();

function sanitizeInput($data) {
    return trim($data) === '' ? null : htmlspecialchars(trim($data));
}

function uploadFile($file, $allowedExtensions, $maxSize, $key, $nim, $increment) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error uploading file: " . $file['name']);
    }

    if ($file['size'] > $maxSize) {
        throw new Exception("File size exceeds the limit for: {$file['name']}.");
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!empty($allowedExtensions) && !in_array($extension, $allowedExtensions)) {
        throw new Exception("Invalid file extension for: {$file['name']}.");
    }

    $mimeType = mime_content_type($file['tmp_name']);
    $allowedMimeTypes = getAllowedMimeTypes($extension);
    if (!in_array($mimeType, $allowedMimeTypes)) {
        throw new Exception("Invalid MIME type for: {$file['name']}.");
    }

    $directoryMapping = [
        'foto_kompetisi' => 'upload/prestasi/kompetisi/',
        'flyer' => 'upload/prestasi/flyer/',
        'sertifikat' => 'upload/prestasi/sertifikat/',
        'surat_tugas' => 'upload/prestasi/surat-tugas/',
        'karya_kompetisi' => 'upload/prestasi/karya/',
    ];

    if (!isset($directoryMapping[$key])) {
        throw new Exception("Invalid file key: {$key}");
    }

    $targetDirectory = $directoryMapping[$key];
    $originalFileName = pathinfo($file['name'], PATHINFO_FILENAME);
    $sanitizedOriginalFileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalFileName);
    $sanitizedExtension = preg_replace('/[^a-zA-Z0-9]/', '', $extension);

    // Generate unique file name with nim, original name, and increment
    $uniqueFileName = "{$nim}_{$sanitizedOriginalFileName}_{$increment}.{$sanitizedExtension}";
    $targetFilePath = $targetDirectory . $uniqueFileName;

    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        throw new Exception("Failed to move uploaded file: {$file['name']}.");
    }

    return $targetFilePath;
}


function getAllowedMimeTypes($extension) {
    $mimeTypes = [
        'jpg' => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png' => ['image/png'],
        'gif' => ['image/gif'],
        'pdf' => ['application/pdf'],
        'mkv' => ['video/x-matroska'],
        'mov' => ['video/quicktime'],
        'mp4' => ['video/mp4'],
    ];

    return $mimeTypes[$extension] ?? [];
}

function getCurrentIncrement() {
    $file = 'increment_counter.txt';
    if (!file_exists($file)) {
        file_put_contents($file, 1);
    }
    return (int) file_get_contents($file);
}

function updateIncrement($newIncrement) {
    $file = 'increment_counter.txt';
    file_put_contents($file, $newIncrement);
}


function processForm($db, $formData, $fileData) {
    try {
        $query = "SELECT id_mahasiswa FROM mahasiswa WHERE nim = ?";
        $params = [$formData['nim']];
        $student = $db->fetchOne($query, $params);

        if (!$student) {
            throw new Exception("Student not found with NIM: {$formData['nim']}.");
        }

        $increment = getCurrentIncrement();

        $data = [
            'id_mahasiswa' => $student['id_mahasiswa'],
            'nama_kompetisi' => sanitizeInput($formData['nama_kompetisi']),
            'id_juara' => (int) sanitizeInput($formData['id_juara']),
            'penyelenggara' => sanitizeInput($formData['penyelenggara']),
            'event' => sanitizeInput($formData['event']),
            'dosen_pembimbing_1' => sanitizeInput($formData['dosen_pembimbing_1']),
            'dosen_pembimbing_2' => sanitizeInput($formData['dosen_pembimbing_2']),
            'jumlah_peserta' => (int) sanitizeInput($formData['jumlah_peserta']),
            'id_kategori' => (int) sanitizeInput($formData['id_kategori']),
            'tanggal_mulai' => date("Y-m-d", strtotime($formData['tanggal_mulai'])),
            'tanggal_selesai' => date("Y-m-d", strtotime($formData['tanggal_selesai'])),
        ];

        $fileRules = [
            'foto_kompetisi' => ['allowed' => ['jpg', 'jpeg', 'png', 'gif'], 'size' => 5 * 1024 * 1024],
            'flyer' => ['allowed' => ['jpg', 'jpeg', 'png', 'gif', 'pdf'], 'size' => 5 * 1024 * 1024],
            'sertifikat' => ['allowed' => ['pdf'], 'size' => 5 * 1024 * 1024],
            'surat_tugas' => ['allowed' => ['pdf'], 'size' => 5 * 1024 * 1024],
            'karya_kompetisi' => ['allowed' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'mkv', 'mov', 'mp4'], 'size' => 75 * 1024 * 1024],
        ];

        foreach ($fileRules as $key => $rules) {
            $data[$key] = (isset($fileData[$key]) && $fileData[$key]['size'] > 0)
                ? uploadFile($fileData[$key], $rules['allowed'], $rules['size'], $key, $formData['nim'], $increment)
                : null;
        }

        $procedure = "EXEC sp_InsertPrestasiPending @id_mahasiswa=?, @nama_kompetisi=?, @id_juara=?, @penyelenggara=?,
        @event=?, @dosen_pembimbing_1=?, @dosen_pembimbing_2=?, @jumlah_peserta=?,
        @id_kategori=?, @tanggal_mulai=?, @tanggal_selesai=?,
        @foto_kompetisi=?, @sertifikat=?, @flyer=?, @surat_tugas=?, @karya_kompetisi=?";

        $params = [
            $data['id_mahasiswa'], $data['nama_kompetisi'], $data['id_juara'], $data['penyelenggara'],
            $data['event'], $data['dosen_pembimbing_1'], $data['dosen_pembimbing_2'], $data['jumlah_peserta'],
            $data['id_kategori'], $data['tanggal_mulai'], $data['tanggal_selesai'],
            $data['foto_kompetisi'], $data['sertifikat'], $data['flyer'], $data['surat_tugas'], $data['karya_kompetisi']
        ];

        $db->executeProcedure($procedure, $params);
        updateIncrement($increment + 1);
        return "Data successfully saved!";
    } catch (Exception $e) {
        throw new Exception("Error: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $formData = $_POST;
        $fileData = $_FILES;

        $response = processForm($db, $formData, $fileData);
        echo json_encode(['status' => 'success', 'message' => $response]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
