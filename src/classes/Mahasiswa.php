<?php

class Mahasiswa extends User
{

    public function sidebar()
    {
        // Get the current page filename
        $currentPage = basename($_SERVER['PHP_SELF']);

        return
            <<<HTML
            <aside class="hidden md:block md:w-20 lg:w-64 bg-white h-screen fixed left-0 top-0 border-r transition-all duration-300 ease-in-out">
            <div class="hidden lg:block flex items-center justify-center mb-8 p-4">
                <img src="../src/img/logoBlack.svg" alt="Logo Prespol" class="w-10 lg:w-40">
            </div>
            <div class="hidden md:block lg:hidden flex items-center justify-center mb-8 p-4">
                <img src="../src/img/logoPrespolSaja.png" alt="Logo Prespol Saja" class="w-10 lg:w-40">
            </div>
            <nav class="space-y-4 gap-4 flex flex-col h-full">
                <ul class="space-y-2">
                    <li>
                        <a href="home.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'home.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-home"></i>
                            <span class="hidden lg:inline ml-4">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="profil.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'profile.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-user"></i>
                            <span class="hidden lg:inline ml-5">Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="inputPrestasi.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'inputPrestasi.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-trophy"></i>
                            <span class="hidden lg:inline ml-4">Tambah prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="historiPengajuan.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'historiPengajuan.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-file-alt"></i>
                            <span class="hidden lg:inline ml-6">Pengajuan</span>
                        </a>
                    </li>
                    <li>
                        <a href="daftarPrestasi.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'daftarPrestasi.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-list"></i>
                            <span class="hidden lg:inline ml-5">List Prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="openModal('logoutModal')" class="flex items-center mx-2 py-2 px-4 lg:px-6 hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden lg:inline ml-4">Keluar</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

<!-- Bottom Navigation for Mobile -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t z-50 flex justify-around py-2 shadow-lg rounded-t-lg">
        <a href="home.php" class="flex flex-col items-center rounded-xl {$this->getActiveClass($currentPage, 'home.php')} px-2 py-1">
            <i class="fas fa-home text-lg"></i>
            <span class="text-[10px] mt-1">Beranda</span>
        </a>
        <a href="profil.php" class="flex flex-col items-center rounded-xl {$this->getActiveClass($currentPage, 'profile.php')} px-2 py-1">
            <i class="fas fa-user text-lg"></i>
            <span class="text-[10px] mt-1">Profil</span>
        </a>
        <a href="inputPrestasi.php" class="flex flex-col items-center rounded-xl {$this->getActiveClass($currentPage, 'inputPrestasi.php')} px-2 py-1">
            <i class="fas fa-trophy text-lg"></i>
            <span class="text-[10px] mt-1">Tambah</span>
        </a>
        <a href="daftarPengajuan.php" class="flex flex-col items-center rounded-xl {$this->getActiveClass($currentPage, 'daftarPengajuan.php')} px-2 py-1">
            <i class="fas fa-file-alt text-lg"></i>
            <span class="text-[10px] mt-1">Pengajuan</span>
        </a>
        <a href="#" onclick="openModal('logoutModal')" class="flex flex-col items-center rounded-xl px-2 py-1">
            <i class="fas fa-sign-out-alt text-lg"></i>
            <span class="text-[10px] mt-1">Keluar</span>
        </a>
    </nav>


    <!-- Logout Modal HTML (unchanged from previous version) -->
    <div id="logoutModal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-50 overflow-y-auto h-full w-full px-4" style="backdrop-filter: blur(5px);">
        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <div class="flex justify-end p-2">
                <button onclick="closeModal('logoutModal')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 pt-0 text-center">
                <svg class="w-20 h-20 text-orange-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-normal text-gray-500 mt-5 mb-6">Kamu yakin mau keluar?</h3>
                <a href="logout.php" 
                    class="text-white bg-orange-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                    Ya, Keluar
                </a>
                <a href="#" onclick="closeModal('logoutModal')"
                    class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.openModal = function(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        window.closeModal = function(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close all modals when press ESC
        document.onkeydown = function(event) {
            event = event || window.event;
            if (event.keyCode === 27) {
                document.body.style.overflow = 'auto';
                let modals = document.getElementsByClassName('modal');
                Array.prototype.slice.call(modals).forEach(i => {
                    i.style.display = 'none';
                });
            }
        };
    </script>
HTML;
}

// Helper method to determine active class (unchanged)
private function getActiveClass($currentPage, $pageName)
{
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
            <header class="flex flex-col lg:flex-row justify-between items-center mt-24 md:mt-16 mb-16 md:mb-0">
                <div class="text-center lg:text-left">
                    <h1 class="text-xl md:text-xl lg:text-3xl font-bold">Selamat Datang</h1>
                    <h2 class="text-2xl md:text-3xl lg:text-5xl font-bold text-black">Champions!</h2>
                    <p class="text-orange-500 mt-4">Kamu peringkat ke-$peringkat di Leaderboard Prespol terkini. Teruskan semangatmu!</p>
                    <button onclick="window.location.href='inputPrestasi.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                        Tambah Prestasi
                    </button>
                </div>
            </header>
        HTML;
    }

    public function profile($no_induk)
    {
        try {
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
                    <div class="relative">
                    <!-- Mobile View: Logo -->
                        <div class="flex justify-between">
                            <div class="block md:hidden items-center">
                                <img 
                                    src="../src/img/logoBlack.svg" 
                                    alt="Logo" 
                                    class="w-24 h-auto mr-4"
                                >
                            </div>
                            <div class="block md:hidden items-center">
                                    <img 
                                        src="{$fotoProfile}" 
                                        alt="Profile Picture" 
                                        class="w-10 h-10 rounded-full"
                                    >
                            </div>
                        </div>

                    <!-- Profile Section (Visible in larger screens) -->
                    <div class="hidden md:block relative">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center ml-auto">
                                <h3 class="text-xl mr-2">$nama</h3>
                                <div class="relative group cursor-pointer" id="profile-trigger">
                                    <img 
                                        src="{$fotoProfile}" 
                                        alt="Profile Picture" 
                                        class="w-10 h-10 rounded-full"
                                    >
                                    <div class="absolute inset-0 bg-black bg-opacity-30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div 
                            id="dropdown-menu" 
                            class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden"
                        >
                            <ul class="py-2">
                                <li>
                                    <a 
                                        href="#" 
                                        id="settings-btn" 
                                        class="block px-4 py-2 hover:bg-gray-100 text-gray-800 hover:text-black"
                                    >
                                        <i class="mr-2">⚙️</i>Settings
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        href="#" 
                                        id="logout-btn" 
                                        class="block px-4 py-2 hover:bg-red-100 text-red-600 hover:text-red-800"
                                    >
                                        <i class="mr-2">🚪</i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                HTML;
                echo <<<SCRIPT
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const profileTrigger = document.getElementById('profile-trigger');
                            const dropdownMenu = document.getElementById('dropdown-menu');
                            
                            // Toggle dropdown when profile picture is clicked
                            profileTrigger.addEventListener('click', function(e) {
                                e.stopPropagation();
                                dropdownMenu.classList.toggle('hidden');
                            });

                            // Close dropdown when clicking outside
                            document.addEventListener('click', function() {
                                dropdownMenu.classList.add('hidden');
                            });

                            // Prevent dropdown from closing when clicking inside
                            dropdownMenu.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });

                            // Settings button click handler
                            document.getElementById('settings-btn').addEventListener('click', function(e) {
                                e.preventDefault();
                                alert('Settings clicked');
                                dropdownMenu.classList.add('hidden');
                            });

                            // Logout button click handler
                            document.getElementById('logout-btn').addEventListener('click', function(e) {
                                e.preventDefault();
                                dropdownMenu.classList.add('hidden');
                                openModal('logoutModal');
                            });
                        });
                        </script>
                SCRIPT;
            } else {
                throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($no_induk));
            }
        } catch (Exception $e) {
            // Log kesalahan dan lempar ulang
            error_log($e->getMessage());
            echo 'Akun tidak ditemukan';
        }
    }

    public function getHistoryPendingList($nim, $page = 1, $limit = 10) {

        $offset = ($page - 1) * $limit;

        $sql = " SELECT 
            nama_kompetisi, 
            event, 
            status, 
            deskripsi
        FROM vw_prestasi_list_by_nim
        WHERE nim = ? AND status ='pending'
        ORDER BY nim
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

        $params = [$nim, $offset, $limit];

        $result = $this->db->fetchAll($sql, $params); // Ambil data prestasi berdasarkan NIM

        $countQuery = "SELECT COUNT(*) as total 
            FROM vw_prestasi_list_by_nim 
            WHERE nim = ? AND status ='pending'";
        $countResult = $this->db->fetchOne($countQuery, [$nim]); // Ambil total data prestasi berdasarkan NIM
        $totalItems = $countResult['total'];
        $totalPages = ceil($totalItems / $limit);
    
        return [
            'data' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function getHistoryPrestasiList($nim, $page = 1, $limit = 10){
        $offset = ($page - 1) * $limit;

        $sql = " SELECT 
            nama_kompetisi, 
            event, 
            status, 
            deskripsi
        FROM vw_prestasi_list_by_nim
        WHERE nim = ? AND status IN ('valid', 'tolak', 'dihapus')
        ORDER BY nim
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

        $params = [$nim, $offset, $limit];

        $result = $this->db->fetchAll($sql, $params); // Ambil data prestasi berdasarkan NIM

        $countQuery = "SELECT COUNT(*) as total 
            FROM vw_prestasi_list_by_nim 
            WHERE nim = ? AND status IN ('valid', 'tolak', 'dihapus')";
        $countResult = $this->db->fetchOne($countQuery, [$nim]);
        $totalItems = $countResult['total'];
        $totalPages = ceil($totalItems / $limit);
    
        return [
            'data' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function listPrestasi($search = '', $filterKategori = '', $filterJuara = '', $filterJurusan = '', $sort = 'newest')
    {
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
                $rows .= "<td class='py-3 px-6 border'>" . htmlspecialchars($row['juara'] ?? '') . "</td>";
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

    //Profil
    public function profilDetail($no_induk) {
        try {
            $sql = "SELECT 
                m.nim,
                m.nama,
                m.foto_profile,
                p.nama_prodi,
                j.nama_jurusan
            FROM mahasiswa m 
            JOIN prodi p ON m.id_prodi = p.id_prodi
            JOIN jurusan j ON m.id_jurusan = j.id_jurusan
            WHERE m.nim = ?";
            $params = [ $no_induk ];

            // Ambil hasil query
            $row = $this->db->fetchOne( $sql, $params );
            if ( $row ) {
                $nim = $row[ 'nim' ] ?? 'Unknown';
                $nama = $row[ 'nama' ] ?? 'Unknown';
                $fotoProfile = $row[ 'foto_profile' ] ?? 'default-profile.png';
                $prodi = $row[ 'nama_prodi' ] ?? 'Unknown';
                $jurusan = $row[ 'nama_jurusan' ] ?? 'Unknown';
                echo
                <<<HTML
                    <div class = 'flex items-center mb-8'>
                        <img alt = 'User profile picture' class = 'space-y-8 rounded-full mr-4' height = '100' src = '$fotoProfile' width = '100'/>
                        <div class="space-y-2">
                            <h1 class = 'text-3xl font-bold'> $nama </h1>
                            <div class = 'flex items-center'>
                            <!-- <span class = 'bg-orange-200 text-orange-600 px-2 py-1 rounded-full text-sm'> $nim </span> -->
                            <span class = 'text-xl bg-orange-400 text-white py-2 px-6 rounded'> NIM $nim </span>
                        </div>
                        <div class="space-y-12">
                            <div class="flex justify-between items-center rounded-lg gap-4">
                                <div class="text-left">
                                    <h4 class="text-xl text-gray-500 font-bold">Program Studi</h4>
                                    <p class="text-xl text-black">$prodi</p>
                                </div>
                                <!-- Jurusan -->
                                <div class="text-left">
                                    <h4 class="text-xl text-gray-500 font-bold">Jurusan</h4>
                                    <p class="text-xl text-black">$jurusan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src = "img/setting.svg" alt = 'Profile Picture' class = 'w-10 h-10 rounded-full ml-2'>
                HTML;

            } else {
                throw new Exception( 'Data tidak ditemukan untuk username: ' . htmlspecialchars( $no_induk ) );
            }
        } catch ( Exception $e ) {
            // Log kesalahan dan lempar ulang
            error_log( $e->getMessage() );
            echo 'Akun tidak ditemukan';
        }
    }

    public function listPrestasiByNim($no_induk, $page = 1, $limit = 10, $search = '') {
        $offset = ($page - 1) * $limit;
    
        $query = "SELECT 
                    id_prestasi, 
                    nama_kompetisi, 
                    event, 
                    juara,
                    total_poin
                  FROM vw_daftar_prestasi
                  WHERE nim = ? 
                  AND (
                      LOWER(nama_kompetisi) LIKE LOWER(?) OR 
                      LOWER(event) LIKE LOWER(?) OR 
                      LOWER(juara) LIKE LOWER(?)
                  )
                  ORDER BY id_prestasi
                  OFFSET ? ROWS FETCH NEXT ? ROWS ONLY;";
    
        $searchTerm = "%$search%";
        $params = [$no_induk, $searchTerm, $searchTerm, $searchTerm, $offset, $limit];
    
        $result = $this->db->fetchAll($query, $params);
    
        // Hitung total data untuk pagination
        $countQuery = "SELECT COUNT(*) as total FROM vw_daftar_prestasi WHERE nim = ? 
                        AND (
                            LOWER(nama_kompetisi) LIKE LOWER(?) OR 
                            LOWER(event) LIKE LOWER(?) OR 
                            LOWER(juara) LIKE LOWER(?)
                        );";
        $countResult = $this->db->fetchOne($countQuery, [$no_induk, $searchTerm, $searchTerm, $searchTerm]);
    
        return [
            'data' => $result,
            'total' => $countResult['total']
        ];
    }

    public function getPrestasiDetail($id_prestasi)
    {
        // Query untuk mendapatkan data detail dari VIEW
        $query = "
            SELECT * 
            FROM vw_daftar_prestasi 
            WHERE id_prestasi = ?
        ";

        $params = [$id_prestasi];
        return $this->db->fetchOne($query, $params);
    }
    
}
