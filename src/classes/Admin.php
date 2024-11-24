<?php 
class Admin extends User{

    public function sidebar(){
        return 
        <<<HTML
                <div class="flex items-center mb-8">
                    <i class="fas fa-trophy text-orange-500 text-2xl"></i>
                    <span class="ml-2 text-xl font-bold">Prespol</span>
                </div>
                <nav class="space-y-4">
                <ul>
                    <li>
                        <a href="home.php" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-home"></i>
                            <span class="ml-4">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="inputPrestasi.php" class="flex items-center py-2 px-8 text-gray-700 bg-gray-200">
                            <i class="fas fa-trophy"></i>
                            <span class="ml-4">Tambah prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-list"></i>
                            <span class="ml-4">List Prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-user"></i>
                            <span class="ml-4">Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="daftarPengajuan.php" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-file-alt"></i>
                            <span class="ml-4">Pengajuan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-cog"></i>
                            <span class="ml-4">Setelan</span>
                        </a>
                    </li>
                </ul>
                </nav>
        HTML;
    }

    public function mainContent($username){
        try{
            $db = new Database();
            // Ambil query yang sesuai
            $sql = "SELECT 
                nama,
                foto_profile
            FROM pegawai
            WHERE no_induk = ?";
            $params = [$username];

            $row = $this->db->fetchOne($sql, $params);
            if ($row) {
                $nama = $row['nama'] ?? 'Unknown';
                $fotoProfile = $row['foto_profile'] ?? 'default-profile.png';
                echo 
                <<<HTML
                        <div class="flex justify-between items-center p-4" style="margin: 0; background: none;">
                            <div class="flex items-center ml-auto"> <!-- Added ml-auto to push this div to the right -->
                                <h3 class="text-xl font-bold">  $nama</h3>
                                <img src="{$fotoProfile}" alt="Profile Picture" class="w-10 h-10 rounded-full ml-2">
                            </div>
                        </div>
                HTML;

                echo 
                <<<HTML
                    <header class="flex flex-col lg:flex-row justify-between items-center mb-8">
                        <div class="text-center lg:text-left">
                            <h1 class="text-3xl font-bold">Selamat Datang</h1>
                            <h2 class="text-5xl font-bold text-black">Admin!</h2>
                            <p class="text-orange-500 mt-2">Kamu peringkat</p>
                            <button onclick="window.location.href='daftarPengajuan.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                                Validasi Prestasi
                            </button>
                        </div>
                    </header>
                HTML;
            } else {
                throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($username));
            }
        } catch (Exception $e) {
            // Log kesalahan dan lempar ulang
            error_log($e->getMessage());
            echo 'Akun tidak ditemukan';
        }
    }

    public function getPrestasiPendingList() {
        // Query untuk mendapatkan data dari VIEW
        $query = "SELECT id_pending, nama_mahasiswa, nama_kompetisi, nama_kategori, jenis_juara FROM vw_PrestasiPending";
    
        // Eksekusi query
        $stmt = sqlsrv_query($this->db->getConnection(), $query);
    
        if ($stmt === false) {
            throw new Exception('Gagal mengambil data prestasi pending: ' . print_r(sqlsrv_errors(), true));
        }
    
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $row;
        }
    
        return $result;
    }
    
    

    public function getPrestasiPendingDetail($id_pending) {
        // Query untuk mendapatkan data detail dari VIEW
        $query = "
            SELECT * 
            FROM vw_PrestasiPending 
            WHERE id_pending = ?
        ";
    
        $params = [$id_pending];
        return $this->db->fetchOne($query, $params);
    }
    

    public function validatePrestasi($id_pending, $status, $deskripsi) {
        try {
            // Panggil prosedur untuk memindahkan atau memperbarui data
            $queryMove = "EXEC sp_ValidatePrestasi @id_pending = ?, @status_validasi = ?, @deskripsi = ?";
            $params = [$id_pending, $status, $deskripsi];
    
            // Jalankan prosedur
            $this->db->executeProcedure($queryMove, $params);
    
            // Periksa hasil dan kembalikan pesan sesuai status
            if ($status === 'valid') {
                return "Validasi berhasil dilakukan dan data dipindahkan ke tabel prestasi.";
            } else {
                return "Prestasi ditolak. Status validasi diperbarui.";
            }
        } catch (Exception $e) {
            // Tangani kesalahan
            throw new Exception("Kesalahan validasi: " . $e->getMessage());
        }
    }
    
    

    public function closeConnection() {
        $this->db->close();
    }
}
?>