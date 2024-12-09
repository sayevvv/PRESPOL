<?php
session_start();
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

function uploadFile($fieldName, $currentFilePath, $uploadBaseDir, $subDir, $allowedExtensions) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
        $fileName = $_FILES[$fieldName]['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return ["error" => "File $fieldName memiliki format tidak valid."];
        }

        $targetDir = rtrim($uploadBaseDir, '/') . '/' . trim($subDir, '/') . '/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (file_exists($currentFilePath)) {
            unlink($currentFilePath);
        }

        $uuid = uniqid();
        $newFileName = $uuid . '_' . basename($fileName);
        $newFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $newFilePath)) {
            return ["path" => $newFilePath];
        } else {
            return ["error" => "Gagal mengunggah file $fieldName."];
        }
    }

    return ["path" => $currentFilePath];
}

function getIdMahasiswa($db, $nim) {
    $query = "SELECT id_mahasiswa FROM mahasiswa WHERE nim = ?";
    $params = [$nim];
    return $db->fetchOne($query, $params);
}

function getDetailPrestasi($db, $id_prestasi) {
    $query = "SELECT * FROM prestasi WHERE id_prestasi = ?";
    $params = [$id_prestasi];
    return $db->fetchOne($query, $params);
}

function updatePrestasi($db, $data) {
    $nim = $data['nim'];
    $id_mahasiswa = getIdMahasiswa($db, $nim);
    $id_prestasi = $data['id_prestasi'];
    $detailPrestasi = getDetailPrestasi($db, $id_prestasi);

    $uploadBaseDir = 'upload/prestasi/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

    $fotoLomba = uploadFile('foto_kompetisi', $detailPrestasi['foto_kompetisi'], $uploadBaseDir, 'kompetisi', $allowedExtensions);
    $flyerLomba = uploadFile('flyer', $detailPrestasi['flyer'], $uploadBaseDir, 'flyer', $allowedExtensions);
    $sertifikat = uploadFile('sertifikat', $detailPrestasi['sertifikat'], $uploadBaseDir, 'sertifikat', $allowedExtensions);
    $suratTugas = uploadFile('surat_tugas', $detailPrestasi['surat_tugas'], $uploadBaseDir, 'surat-tugas', $allowedExtensions);
    $karyaKompetisi = uploadFile('karya_kompetisi', $detailPrestasi['karya_kompetisi'], $uploadBaseDir, 'karya', $allowedExtensions);

    if (isset($fotoLomba['error']) || isset($flyerLomba['error']) || isset($sertifikat['error']) || isset($suratTugas['error']) || isset($karyaKompetisi['error'])) {
        return "Error: " . implode(', ', array_filter([
            $fotoLomba['error'],
            $flyerLomba['error'],
            $sertifikat['error'],
            $suratTugas['error'],
            $karyaKompetisi['error']
        ]));
    }

    $queryUpdate = "
        UPDATE prestasi SET
            id_mahasiswa = ?,
            nama_kompetisi = ?,
            penyelenggara = ?,
            event = ?,
            id_kategori = ?,
            id_juara = ?,
            jumlah_peserta = ?,
            dosen_pembimbing_1 = ?,
            dosen_pembimbing_2 = ?,
            foto_kompetisi = ?,
            flyer = ?,
            sertifikat = ?,
            surat_tugas = ?,
            karya_kompetisi = ?
        WHERE id_prestasi = ?
    ";

    $dosenPembimbing1 = trim($data['dosen_pembimbing_1']) !== '' ? $data['dosen_pembimbing_1'] : NULL;
    $dosenPembimbing2 = trim($data['dosen_pembimbing_2']) !== '' ? $data['dosen_pembimbing_2'] : NULL;

    $params = [
        $id_mahasiswa['id_mahasiswa'],
        $data['nama_kompetisi'],
        $data['penyelenggara'],
        $data['event'],
        $data['id_kategori'],
        $data['id_juara'],
        $data['jumlah_peserta'],
        $dosenPembimbing1,
        $dosenPembimbing2,
        $fotoLomba['path'] ?? NULL,
        $flyerLomba['path'] ?? NULL,
        $sertifikat['path'] ?? NULL,
        $suratTugas['path'] ?? NULL,
        $karyaKompetisi['path'] ?? NULL,
        $id_prestasi
    ];

    $stmt = sqlsrv_query($db->getConnection(), $queryUpdate, $params);

    if ($stmt === false) {
        return "Error: " . print_r(sqlsrv_errors(), true);
    }

    return "Data berhasil diperbarui!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();

    $data = [
        'id_prestasi' => $_POST['id_prestasi'],
        'nim' => $_POST['nim'],
        'nama_kompetisi' => $_POST['nama_kompetisi'],
        'penyelenggara' => $_POST['penyelenggara'],
        'event' => $_POST['event'],
        'id_kategori' => $_POST['id_kategori'],
        'id_juara' => $_POST['id_juara'],
        'jumlah_peserta' => $_POST['jumlah_peserta'],
        'dosen_pembimbing_1' => $_POST['dosen_pembimbing_1'],
        'dosen_pembimbing_2' => $_POST['dosen_pembimbing_2']
    ];

    $result = updatePrestasi($db, $data);

    if ($result !== NULL) {
        header('Location: detailPrestasi.php?id_prestasi=' . $data['id_prestasi']);
        exit;
    } else {
        echo $result;
    }
}
?>
