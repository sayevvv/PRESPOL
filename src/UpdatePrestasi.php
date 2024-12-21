<?php
session_start();
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

function logError($message) {
    error_log($message, 3, 'error_log.txt'); // Log ke file error_log.txt untuk debugging
}

function getIncrementValue($filePath) {
    if (!file_exists($filePath)) {
        file_put_contents($filePath, '1'); // Jika file tidak ada, buat file dengan nilai awal 1
        return 1;
    }

    $currentValue = (int) file_get_contents($filePath);
    $newValue = $currentValue + 1;
    file_put_contents($filePath, (string)$newValue); // Perbarui nilai increment di file

    return $newValue;
}

function uploadFile($fieldName, $currentFilePath, $uploadBaseDir, $subDir, $allowedExtensions, $nim, $incrementValue = null) {
    $incrementFilePath = 'increment_counter.txt';

    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
        $fileExtension = strtolower(pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return ["error" => "Format file tidak valid"];
        }

        $targetDir = rtrim($uploadBaseDir, '/') . '/' . trim($subDir, '/') . '/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Periksa increment dari file lama
        if ($currentFilePath && file_exists($currentFilePath)) {
            $currentFileName = basename($currentFilePath);
            $pattern = '/^' . preg_quote($nim, '/') . '_' . preg_quote($fieldName, '/') . '_(\d+)\.[a-z]+$/';
            if (preg_match($pattern, $currentFileName, $matches)) {
                $incrementValue = $matches[1]; // Gunakan increment dari file lama
            }
        }

        // Jika tidak ada file lama atau nilai increment, hasilkan increment baru
        if (!$incrementValue) {
            $incrementValue = getIncrementValue($incrementFilePath);
        }

        // Ganti nama file menjadi {nim}_{fieldName}_{increment}.{extension}
        $newFileName = $nim . '_' . $fieldName . '_' . $incrementValue . '.' . $fileExtension;
        $newFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $newFilePath)) {
            if ($currentFilePath && file_exists($currentFilePath)) {
                unlink($currentFilePath); // Hapus file lama
            }
            return ["path" => $newFilePath];
        } else {
            return ["error" => "Gagal mengunggah file"];
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
    try {
        $nim = $data['nim'];
        $id_mahasiswa = getIdMahasiswa($db, $nim);
        $id_prestasi = $data['id_prestasi'];
        $detailPrestasi = getDetailPrestasi($db, $id_prestasi);

        $uploadBaseDir = 'upload/prestasi/';
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

        // Hasilkan nilai increment satu kali
        $incrementValue = getIncrementValue('increment_counter.txt');

        $fotoLomba = uploadFile('foto_kompetisi', $detailPrestasi['foto_kompetisi'], $uploadBaseDir, 'kompetisi', $allowedExtensions, $nim, $incrementValue);
        $flyerLomba = uploadFile('flyer', $detailPrestasi['flyer'], $uploadBaseDir, 'flyer', $allowedExtensions, $nim, $incrementValue);
        $sertifikat = uploadFile('sertifikat', $detailPrestasi['sertifikat'], $uploadBaseDir, 'sertifikat', $allowedExtensions, $nim, $incrementValue);
        $suratTugas = uploadFile('surat_tugas', $detailPrestasi['surat_tugas'], $uploadBaseDir, 'surat-tugas', $allowedExtensions, $nim, $incrementValue);
        $karyaKompetisi = uploadFile('karya_kompetisi', $detailPrestasi['karya_kompetisi'], $uploadBaseDir, 'karya', $allowedExtensions, $nim, $incrementValue);

        foreach ([$fotoLomba, $flyerLomba, $sertifikat, $suratTugas, $karyaKompetisi] as $uploadResult) {
            if (isset($uploadResult['error'])) {
                throw new Exception($uploadResult['error']);
            }
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

        $params = [
            $id_mahasiswa['id_mahasiswa'],
            $data['nama_kompetisi'],
            $data['penyelenggara'],
            $data['event'],
            $data['id_kategori'],
            $data['id_juara'],
            $data['jumlah_peserta'],
            $data['dosen_pembimbing_1'] ?: NULL,
            $data['dosen_pembimbing_2'] ?: NULL,
            $fotoLomba['path'] ?? NULL,
            $flyerLomba['path'] ?? NULL,
            $sertifikat['path'] ?? NULL,
            $suratTugas['path'] ?? NULL,
            $karyaKompetisi['path'] ?? NULL,
            $id_prestasi
        ];

        $stmt = sqlsrv_query($db->getConnection(), $queryUpdate, $params);

        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        return ["success" => true];
    } catch (Exception $e) {
        logError($e->getMessage());
        return ["error" => "Maaf, perubahan gagal disimpan. Harap coba lagi."];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $data = $_POST;
    $id_prestasi = $data['id_prestasi'];

    $result = updatePrestasi($db, $data);

    if ($result) {
        // Redirect ke detailPrestasi.php dengan pesan sukses
        header("Location: detailPrestasi.php?id_prestasi=$id_prestasi&status=success");
        exit();
    } else {
        // Redirect ke detailPrestasi.php dengan pesan error
        header("Location: detailPrestasi.php?id_prestasi=$id_prestasi&status=error");
        exit();
    }
}
?>
