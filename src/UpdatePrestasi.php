<?php
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

class UpdatePrestasi {
    private $db;
    private $uploadBaseDir;
    private $allowedExtensions;

    public function __construct($db, $uploadBaseDir = 'upload/prestasi/', $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf']) {
        $this->db = $db;
        $this->uploadBaseDir = $uploadBaseDir;
        $this->allowedExtensions = $allowedExtensions;
    }

    // Fungsi untuk mengunggah file
    private function uploadFile($fieldName, $currentFilePath, $subDir) {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
            $fileName = $_FILES[$fieldName]['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validasi ekstensi file
            if (!in_array($fileExtension, $this->allowedExtensions)) {
                return ["error" => "File $fieldName memiliki format tidak valid."];
            }

            // Direktori target berdasarkan jenis file
            $targetDir = rtrim($this->uploadBaseDir, '/') . '/' . trim($subDir, '/') . '/';

            // Buat direktori jika belum ada
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Hapus file lama jika ada
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }

            $fileBaseName = basename($fileName); // Mengambil nama file tanpa path tambahan
            $uuid = uniqid(); // Membuat ID unik
            $newFileName = $uuid . '_' . $fileBaseName; // Menggabungkan UUID dan nama file asli
            $newFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $newFilePath)) {
                return ["path" => $newFilePath];
            } else {
                return ["error" => "Gagal mengunggah file $fieldName."];
            }
        }

        // Jika tidak ada file baru, kembalikan path lama
        return ["path" => $currentFilePath];
    }

    // Fungsi untuk mendapatkan detail prestasi dari database
    public function getIdMahasiswa($nim) {
        $query = "SELECT id_mahasiswa FROM mahasiswa WHERE nim = ?";
        $params = [$nim];
        $result = $this->db->fetchOne($query, $params);

        return $result;
    }

    public function getDetailPrestasi($id_prestasi) {
        $query = "SELECT * FROM prestasi WHERE id_prestasi = ?";
        $params = [$id_prestasi];
        $result = $this->db->fetchOne($query, $params);

        return $result;
    }

    // Fungsi untuk memperbarui data prestasi
    public function updatePrestasi($data) {
        $nim = $data['nim'];
        $id_mahasiswa = $this->getIdMahasiswa($nim);
        $id_prestasi = $data['id_prestasi'];
        $detailPrestasi = $this->getDetailPrestasi($id_prestasi);

        // Upload file baru dan dapatkan path file baru
        $fotoLomba = $this->uploadFile('foto_kompetisi', $detailPrestasi['foto_kompetisi'], 'kompetisi');
        $flyerLomba = $this->uploadFile('flyer', $detailPrestasi['flyer'], 'flyer');
        $sertifikat = $this->uploadFile('sertifikat', $detailPrestasi['sertifikat'], 'sertifikat');
        $suratTugas = $this->uploadFile('surat_tugas', $detailPrestasi['surat_tugas'], 'surat-tugas');
        $karyaKompetisi = $this->uploadFile('karya_kompetisi', $detailPrestasi['karya_kompetisi'], 'karya');

        // Jika ada error saat upload
        if (isset($fotoLomba['error']) || isset($flyerLomba['error']) || isset($sertifikat['error']) || isset($suratTugas['error']) || isset($karyaKompetisi['error'])) {
            return "Error: " . implode(', ', array_filter([$fotoLomba['error'], $flyerLomba['error'], $sertifikat['error'], $suratTugas['error'], $karyaKompetisi['error']]));
        }

        // Perbarui database
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
            $data['dosen_pembimbing_1'],
            $data['dosen_pembimbing_2'],
            $fotoLomba['path'],
            $flyerLomba['path'],
            $sertifikat['path'],
            $suratTugas['path'],
            $karyaKompetisi['path'],
            $id_prestasi
        ];

        $stmt = sqlsrv_query($this->db->getConnection(), $queryUpdate, $params);

        if ($stmt === false) {
            return "Error: " . print_r(sqlsrv_errors(), true);
        }

        return "Data berhasil diperbarui!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $editPrestasi = new UpdatePrestasi($db);

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

    $result = $editPrestasi->updatePrestasi($data);
    if ($result != NULL) {
        // Redirect ke halaman detailPrestasi
        header('Location: detailPrestasi.php?id_prestasi=' . $data['id_prestasi']);
        exit;
    } else {
        echo $result; // Menampilkan pesan error
    }
}
?>
