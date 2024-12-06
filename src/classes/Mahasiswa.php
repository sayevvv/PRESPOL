<?php 

class Mahasiswa extends User {

    public function sidebar(){
        // Get the current page filename
        $currentPage = basename($_SERVER['PHP_SELF']);
        
        return 
        <<<HTML
            <div class="flex items-center mb-8">
                <img src="../src/img/logoBlack.svg" alt="Logo Prespol" class="w-40">
            </div>
            <nav class="space-y-4 gap-4">
            <ul class="space-y-2">
                <li>
                    <a href="home.php" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'home.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-home"></i>
                        <span class="ml-4">Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="inputPrestasi.php" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'inputPrestasi.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-trophy"></i>
                        <span class="ml-4">Tambah prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="daftarPrestasi.php" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'daftarPrestasi.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-list"></i>
                        <span class="ml-4">List Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'profile.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-user"></i>
                        <span class="ml-4">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="historiPengajuan.php" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'daftarPengajuan.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-file-alt"></i>
                        <span class="ml-4">Pengajuan</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="flex items-center py-2 px-8 {$this->getActiveClass($currentPage, 'daftarPengajuan.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-file-alt"></i>
                        <span class="ml-4">Logout</span>
                    </a>
                </li>
            </ul>
            </nav>
        HTML;
    }
    
    // Helper method to determine active class
    private function getActiveClass($currentPage, $pageName) {
        return $currentPage === $pageName 
            ? 'bg-orange-500 text-white' 
            : 'text-gray-700';
    }

    public function mainContent($no_induk){
        $this->profile($no_induk);
        $sql = "SELECT * FROM leaderboard_view WHERE nim = ?";
        $params = [$no_induk];
        $stmt = $this->db->fetchOne($sql, $params);
        $peringkat = $stmt['peringkat'];

        echo 
        <<<HTML
            <header class="flex flex-col lg:flex-row justify-between items-center mb-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-bold">Selamat Datang</h1>
                    <h2 class="text-5xl font-bold text-black">Champions!</h2>
                    <p class="text-orange-500 mt-2">Kamu peringkat $peringkat</p>
                    <button onclick="window.location.href='inputPrestasi.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                        Tambah Prestasi
                    </button>
                </div>
            </header>
        HTML;
    }

    public function profile($no_induk){
        try{
            $sql = "SELECT 
                nama,
                foto_profile
            FROM mahasiswa
            WHERE nim = ?";
            $params = [$no_induk];

            // Ambil hasil query
            $row = $this->db->fetchOne($sql, $params);
            if ($row) {
                $nama = $row['nama'] ?? 'Unknown';
                $fotoProfile = $row['foto_profile'] ?? 'default-profile.png';
                echo 
                <<<HTML
                        <div class="flex justify-between items-center p-4" style="margin: 0; background: none;">
                            <div class="flex items-center ml-auto"> <!-- Added ml-auto to push this div to the right -->
                                <h3 class="text-xl">  $nama</h3>
                                <img src="{$fotoProfile}" alt="Profile Picture" class="w-10 h-10 rounded-full ml-2">
                            </div>
                        </div>
                HTML;
            } else {
                throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($no_induk));
            }
        } catch (Exception $e) {
            // Log kesalahan dan lempar ulang
            error_log($e->getMessage());
            echo 'Akun tidak ditemukan';
        }
    }

    public function listPrestasi($search = '', $filterKategori = '', $filterJuara = '', $filterJurusan = '', $sort = 'newest') {
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1; // Change from $_GET to $_POST
        $limit = 10;
        $offset = ($page - 1) * $limit;
    
        $totalQuery = "SELECT COUNT(*) AS total FROM vw_daftar_prestasi WHERE 1=1";
        $params = [];
    
        // Filter conditions (keep existing code)
        if (!empty($search)) {
            $totalQuery .= " AND (
                [nama mahasiswa] LIKE ? OR 
                nama_kompetisi LIKE ? OR 
                event LIKE ?
            )";
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }
    
        if (!empty($filterKategori)) {
            $totalQuery .= " AND kategori = ?";
            $params[] = $filterKategori;
        }
        if (!empty($filterJuara)) {
            $totalQuery .= " AND juara = ?";
            $params[] = $filterJuara;
        }
        if (!empty($filterJurusan)) {
            $totalQuery .= " AND jurusan = ?";
            $params[] = $filterJurusan;
        }
    
        $totalRow = $this->db->fetchOne($totalQuery, $params);
        $totalData = $totalRow['total'];
        $totalPages = ceil($totalData / $limit);
    
        // Query data (keep existing query structure)
        $query = "SELECT 
                    id_prestasi,
                    [nama mahasiswa] AS nama,
                    jurusan,
                    nama_kompetisi,
                    event,
                    juara,
                    kategori,
                    tahun
                  FROM vw_daftar_prestasi 
                  WHERE 1=1";
    
        // Add filter conditions to the main query (similar to total query)
        if (!empty($search)) {
            $query .= " AND (
                [nama mahasiswa] LIKE ? OR 
                nama_kompetisi LIKE ? OR 
                event LIKE ?
            )";
        }
        
        if (!empty($filterKategori)) {
            $query .= " AND kategori = ?";
        }
        if (!empty($filterJuara)) {
            $query .= " AND juara = ?";
        }
        if (!empty($filterJurusan)) {
            $query .= " AND jurusan = ?";
        }
    
        // Sorting (keep existing sorting logic)
        switch ($sort) {
            case 'newest':
                $query .= " ORDER BY created_date DESC";
                break;
            case 'oldest':
                $query .= " ORDER BY created_date ASC";
                break;
            case 'A-Z':
                $query .= " ORDER BY nama ASC";
                break;
            case 'Z-A':
                $query .= " ORDER BY nama DESC";
                break;
        }
    
        $query .= " OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
        $params[] = $offset;
        $params[] = $limit;
    
        $result = $this->db->fetchAll($query, $params);
    
        $rows = '';
        if ($result) {
            foreach ($result as $index => $row) {
                $rows .= '<tr>';
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($index + 1 + $offset) . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['nama'] ?? '') . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['jurusan'] ?? '') . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['nama_kompetisi'] ?? '') . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['event'] ?? '') . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['juara'] ?? '') ."</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['kategori'] ?? '') . "</td>";
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['tahun'] ?? '') . "</td>";
            }
        } else {
            $rows = '<tr><td colspan="9" class="text-center">Tidak ada data ditemukan</td></tr>';
        }
    
        return json_encode([
            'rows' => $rows,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_data' => $totalData
            ]
        ]);
    }
}
?>