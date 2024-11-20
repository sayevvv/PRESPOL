<?php 

class Mahasiswa extends User {

    public function sidebar(){
        return 
        <<<HTML
            <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r">
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
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
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
            </aside>
        HTML;
    }

    public function mainContent($username){
        try{
            $db = new Database();
            // Ambil query yang sesuai
            $sql = "SELECT 
                nama,
                foto_profile
            FROM mahasiswa
            WHERE nim = ?";
            $params = [$username];

            // Siapkan query menggunakan prepared statement
            $stmt = sqlsrv_prepare($db->getConnection(), $sql, $params);

            if ($stmt === false) {
                throw new Exception('Gagal mempersiapkan statement: ' . print_r(sqlsrv_errors(), true));
            }

            // Eksekusi query
            if (sqlsrv_execute($stmt) === false) {
                throw new Exception('Gagal mengeksekusi statement: ' . print_r(sqlsrv_errors(), true));
            }

            // Ambil hasil query
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
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
                            <h2 class="text-5xl font-bold text-black">Champions!</h2>
                            <p class="text-orange-500 mt-2">Kamu peringkat</p>
                            <button onclick="window.location.href='inputPrestasi.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                                Tambah Prestasi
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
}
?>