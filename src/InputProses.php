<?php 
session_start();
include 'config/Database.php';

class InputProses {
    private $db;
    private $uploadDir = "upload/";
    private $fileRules = [
        'foto_kompetisi' => ['allowed' => ['jpg', 'jpeg', 'png', 'gif'], 'size' => 5 * 1024 * 1024],
        'flyer' => ['allowed' => ['jpg', 'jpeg', 'png', 'gif', 'pdf'], 'size' => 5 * 1024 * 1024],
        'sertifikat' => ['allowed' => ['pdf'], 'size' => 5 * 1024 * 1024],
        'surat_tugas' => ['allowed' => ['pdf'], 'size' => 5 * 1024 * 1024],
        'karya_kompetisi' => ['allowed' => [], 'size' => 5 * 1024 * 1024], // Semua jenis file
    ];

    public function __construct(Database $db) {
        $this->db = $db;
        $this->prepareUploadDir();
    }

    private function prepareUploadDir() {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function sanitizeInput($data) {
        $trimmed = trim($data);
        return $trimmed === '' ? null : htmlspecialchars($trimmed);
    }
    
    
    public function uploadFile($file, $allowedExtensions, $maxSize, $key) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Terjadi kesalahan saat mengunggah file.");
        }
    
        if ($file['size'] > $maxSize) {
            throw new Exception("Ukuran file {$file['name']} melebihi batas maksimum 5 MB.");
        }
    
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!empty($allowedExtensions) && !in_array($extension, $allowedExtensions)) {
            throw new Exception("File {$file['name']} memiliki ekstensi yang tidak diizinkan.");
        }
    
        // Peta subdirektori
        $subDirMap = [
            'foto_kompetisi' => 'upload/prestasi/kompetisi/',
            'flyer' => 'upload/prestasi/flyer/',
            'sertifikat' => 'upload/prestasi/sertifikat/',
            'surat_tugas' => 'upload/prestasi/surat-tugas/',
            'karya_kompetisi' => 'upload/prestasi/karya/',
        ];
    
        if (!isset($subDirMap[$key])) {
            throw new Exception("Key file tidak valid: {$key}");
        }
    
        // Tentukan path file dengan nama unik
        $subDir = $subDirMap[$key];
        $fileName = strtolower(uniqid() . "_" . $file['name']);
        $filePath = $subDir . $fileName;
    
        if (file_exists($filePath)) {
            throw new Exception("File dengan nama {$file['name']} sudah ada di direktori tujuan.");
        }

        // Pindahkan file ke direktori tujuan
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Gagal memindahkan file {$file['name']} ke direktori tujuan.");
        }
    
        return $filePath;
    }
    

    public function processForm($formData, $fileData) {
        try {
            $sql = "SELECT
                        id_mahasiswa
                    FROM mahasiswa WHERE nim = ?";
            $params = [$formData['nim']]; // Tambahkan array jika params salah
            $id_mahasiswa = $this->db->fetchOne($sql, $params);
            
            if (!$id_mahasiswa) {
                throw new Exception("Mahasiswa dengan NIM {$formData['nim']} tidak ditemukan.");
            }

            $data = [
                'id_mahasiswa' => $id_mahasiswa['id_mahasiswa'],
                'nama_kompetisi' => $this->sanitizeInput($formData['nama_kompetisi']),
                'id_juara' => $this->sanitizeInput($formData['id_juara']),
                'penyelenggara' => $this->sanitizeInput($formData['penyelenggara']),
                'event' => $this->sanitizeInput($formData['event']),
                'dosen_pembimbing_1' => $this->sanitizeInput($formData['dosen_pembimbing_1']),
                'dosen_pembimbing_2' => $this->sanitizeInput($formData['dosen_pembimbing_2']),
                'jumlah_peserta' => $this->sanitizeInput($formData['jumlah_peserta']),
                'id_kategori' => $this->sanitizeInput($formData['id_kategori']),
                'tanggal_mulai' => $this->sanitizeInput($formData['tanggal_mulai']),
                'tanggal_selesai' => $this->sanitizeInput($formData['tanggal_selesai']),
            ];

            $data['tanggal_mulai'] = date("Y-m-d", strtotime($formData['tanggal_mulai']));
            $data['tanggal_selesai'] = date("Y-m-d", strtotime($formData['tanggal_selesai']));

            // Upload file dan tambahkan ke data
            foreach ($this->fileRules as $key => $config) {
                $data[$key] = isset($fileData[$key]) && $fileData[$key]['size'] > 0
                    ? $this->uploadFile($fileData[$key], $config['allowed'], $config['size'], $key)
                    : null;
            }
            

            // Gunakan metode `insert` dari Database
            $this->db->insert('prestasi', $data);

            return "Data berhasil disimpan!";
        } catch (Exception $e) {
            throw new Exception("Kesalahan: " . $e->getMessage());
        }
    }

    public function closeConnection() {
        $this->db->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Buat objek Database dan InputProses
        $db = new Database();
        $inputProses = new InputProses($db);

        // Ambil data form dan file
        $formData = $_POST;  // Ambil semua data dari form
        $fileData = $_FILES; // Ambil data file yang diupload

        // Proses form dengan InputProses
        $result = $inputProses->processForm($formData, $fileData);

        // Menampilkan pesan sukses
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil diterima']);

    } catch (Exception $e) {
        // Menangani kesalahan
        echo json_encode(['status' => 'error', 'message' => 'Metode tidak didukung']);
    }
}
?>