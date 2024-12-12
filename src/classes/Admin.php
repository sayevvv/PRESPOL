<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

class Admin extends User
{

    private $nip;
    public function __construct($nip) {
        parent::__construct();
        $this->nip = $nip;
    }

    public function getNim() {
        return $this->nip;
    }

    public function sidebar()
    {
        // Get the current page filename
        $currentPage = basename($_SERVER['PHP_SELF']);

        return
            <<<HTML
            <!-- Sidebar for desktop and icon-only for medium screens -->
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
                            <a href="daftarPengajuan.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'daftarPengajuan.php')} {$this->getActiveClass($currentPage, 'detailPengajuan.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                                <i class="fas fa-file-alt"></i>
                                <span class="hidden lg:inline ml-6">Validasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="daftarPrestasi.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'daftarPrestasi.php')} {$this->getActiveClass($currentPage, 'detailPrestasi.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                                <i class="fas fa-list"></i>
                                <span class="hidden lg:inline ml-5">List Prestasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="eksporData.php" class="flex items-center mx-2 py-2 px-4 lg:px-6 {$this->getActiveClass($currentPage, 'eksporData.php')} hover:bg-orange-400 hover:text-white rounded-lg transition duration-200">
                                <i class="fas fa-file-alt"></i>
                                <span class="hidden lg:inline ml-6">Ekspor Data</span>
                            </a>
                        </li>
                        <li style="margin-top: 320px">
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
                    <span class="text-[10px] mt-1">Validasi</span>
                </a>
                <a href="daftarPrestasi.php" class="flex flex-col items-center rounded-xl {$this->getActiveClass($currentPage, 'daftarPrestasi.php')} px-2 py-1">
                    <i class="fas fa-list text-lg"></i>
                    <span class="text-[10px] mt-1">List Prestasi</span>
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

    public function mainContent()
    {
        $this->profile();
        echo
        <<<HTML
                    <header class="flex flex-col lg:flex-row justify-between items-center mt-24 md:mt-16 mb-16 md:mb-0">
                        <div class="text-center lg:text-left">
                            <h1 class="text-xl md:text-xl lg:text-3xl font-bold">Selamat Datang</h1>
                            <h2 class="text-2xl md:text-3xl lg:text-5xl font-bold text-black">Admin!</h2>
                            <button onclick="window.location.href='daftarPengajuan.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                                Validasi Prestasi
                            </button>
                        </div>
                    </header>
                HTML;
    }

    public function profile()
    {
        try {
            $sql = "SELECT 
                nama,
                foto_profile
            FROM pegawai
            WHERE no_induk = ?";
            $params = [$this->nip];

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
                throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($this->nip));
            }
        } catch (Exception $e) {
            // Log kesalahan dan lempar ulang
            error_log($e->getMessage());
            echo 'Akun tidak ditemukan';
        }
    }

    public function getPrestasiPendingList($page = 1, $limit = 10)
    {
        // Calculate offset
        $offset = ($page - 1) * $limit;

        // Query to get paginated data from VIEW
        $query = "SELECT id_pending, nama_mahasiswa, nama_kompetisi, nama_kategori, jenis_juara 
            FROM vw_PrestasiPending
            WHERE status_validasi <> 'tolak'
            ORDER BY id_pending
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

        // Parameters for query
        $params = [$offset, $limit];

        // Execute query
        $result = $this->db->fetchAll($query, $params);

        if ($result === false) {
            throw new Exception('Gagal mengambil data prestasi pending: ' . print_r(sqlsrv_errors(), true));
        }

        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total 
            FROM vw_PrestasiPending 
            WHERE status_validasi <> 'tolak'";
        $countResult = $this->db->fetchOne($countQuery);
        $totalItems = $countResult['total'];
        $totalPages = ceil($totalItems / $limit);

        return [
            'data' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function getPrestasiVerifiedList($page = 1, $limit = 10)
    {
        // Calculate offset
        $offset = ($page - 1) * $limit;

        $query = "SELECT status_validasi, nama_mahasiswa, nama_kompetisi, nama_kategori, jenis_juara 
            FROM vw_daftar_pengajuan_terlayani
            WHERE no_induk_pegawai = ?
            ORDER BY id_validasi
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

        $params = [$this->nip, $offset, $limit];

        $result = $this->db->fetchAll($query, $params);

        if ($result === false) {
            throw new Exception('Gagal mengambil data prestasi pending: ' . print_r(sqlsrv_errors(), true));
        }

        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total 
            FROM vw_daftar_pengajuan_terlayani 
            WHERE no_induk_pegawai = ?";
        $countParams = [$this->nip];
        $countResult = $this->db->fetchOne($countQuery, $countParams);
        $totalItems = $countResult['total'];
        $totalPages = ceil($totalItems / $limit);

        return [
            'data' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }


    public function getPrestasiPendingDetail($id_pending)
    {
        // Query untuk mendapatkan data detail dari VIEW
        $query = "
            SELECT * 
            FROM vw_PrestasiPending 
            WHERE id_pending = ?
        ";

        $params = [$id_pending];
        return $this->db->fetchOne($query, $params);
    }


    public function validatePrestasi($id_pending, $status, $deskripsi)
    {
        try {
            // mengambil path kelima file dari tabel prestasi_pending
            $queryFetchFiles = "SELECT foto_kompetisi, flyer, sertifikat, surat_tugas, karya_kompetisi 
                                FROM prestasi_pending WHERE id_pending = ?";
            $filesResult = $this->db->fetchOne($queryFetchFiles, [$id_pending]);

            if (!$filesResult) {
                throw new Exception("Data dengan ID tersebut tidak ditemukan.");
            }
            //mengambil id_pegawai
            $sql = 'SELECT id_pegawai FROM pegawai WHERE no_induk = ?';
            $stmt = $this->db->fetchOne($sql, [$this->nip]);
            $id_pegawai = $stmt['id_pegawai'];

            // Panggil prosedur untuk memindahkan atau memperbarui data
            $queryMove = "EXEC sp_ValidatePrestasi @id_pending = ?, @status_validasi = ?, @deskripsi = ?, @id_pegawai = ?";
            $params = [$id_pending, $status, $deskripsi, $id_pegawai];

            // Jalankan prosedur
            $this->db->executeProcedure($queryMove, $params);

            // Jika status 'tolak', hapus semua file yang terkait
            if ($status === 'tolak') {
                $filePaths = [
                    $filesResult['foto_kompetisi'],
                    $filesResult['flyer'],
                    $filesResult['sertifikat'],
                    $filesResult['surat_tugas'],
                    $filesResult['karya_kompetisi']
                ];

                $deletedFiles = [];
                foreach ($filePaths as $filePath) {
                    if (!empty($filePath) && file_exists($filePath)) {
                        if (unlink($filePath)) {
                            $deletedFiles[] = basename($filePath); // Simpan nama file yang berhasil dihapus
                        } else {
                            throw new Exception("Gagal menghapus file: " . basename($filePath));
                        }
                    }
                }

                // Berikan konfirmasi penghapusan
                return "Prestasi ditolak dengan alasan " . $deskripsi;
            }

            // Periksa hasil dan kembalikan pesan sesuai status
            return "Validasi berhasil dilakukan dan data dipindahkan ke tabel prestasi.";
        } catch (Exception $e) {
            // Tangani kesalahan
            throw new Exception("Kesalahan validasi: " . $e->getMessage());
        }
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

                // URL untuk tombol Detail dan Hapus
                $detailUrl = "detailPrestasi.php?id_prestasi=" . urlencode($row['id_prestasi']);

                // Tambahkan tombol Detail dan Hapus
                $rows .= "<td class='py-3 px-6 border text-center'>
                            <div class='flex justify-center space-x-2'>
                                <a href='" . htmlspecialchars($detailUrl) . "'>
                                    <button class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700'>
                                        Detail
                                    </button>
                                </a>
                                 <button 
                                    class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 delete-button' 
                                    data-id='" . htmlspecialchars($row['id_prestasi']) . "'>
                                    Hapus
                                </button>
                            </div>
                          </td>";
                $rows .= '</tr>';
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

    public function profilDetail()
    {
        try {
            $sql = "SELECT 
                p.no_induk,
                p.nama,
                p.foto_profile
            FROM pegawai p
            WHERE p.no_induk = ?";
            $params = [$this->nip];

            // Ambil hasil query
            $row = $this->db->fetchOne($sql, $params);
            if ($row) {
                $nama = $row['nama'] ?? 'Unknown';
                $fotoProfile = $row['foto_profile'] ?? 'default-profile.png';
                echo
                <<<HTML
                    <div class="flex flex-col pt-20 mb-8 w-full max-w-screen-md">
                        <div class="flex items-center mb-8">
                        <img 
                            alt="User profile picture" 
                            class="w-36 h-36 rounded-full object-cover mr-4" 
                            src="$fotoProfile" 
                            />
                            <div class="space-y-2">
                                <h1 class="text-5xl font-semibold">$nama</h1>
                                <div class="flex items-center">
                                    <span class="text-xl md:text-2xl bg-orange-400 text-white py-2 px-6 rounded-full">NIP $this->nip</span>
                                </div>
                            </div>
                        </div>
                        <!-- Ketua Jurusan Card -->
                        <div class="bg-white border px-6 py-4 rounded-lg shadow-lg">
                            <p class="text-lg font-semibold">Admin Prespol</p>
                        </div>
                    </div>
                HTML;
            } else {
                throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($this->nip));
            }
        } catch (Exception $e) {
            // Log kesalahan dan lempar ulang
            error_log($e->getMessage());
            echo 'Akun tidak ditemukan';
        }
    }

    public function softDelete($id_prestasi, $deskripsi)
    {
        $queryFetchPath = 'SELECT foto_kompetisi, sertifikat, flyer, karya_kompetisi, surat_tugas FROM prestasi WHERE id_prestasi = ?';
        $row = $this->db->fetchOne($queryFetchPath, [$id_prestasi]);

        $mapDirectories = [
            'foto_kompetisi' => 'archive/kompetisi/',
            'karya_kompetisi' => 'archive/karya/',
            'flyer' => 'archive/flyer/',
            'sertifikat' => 'archive/sertifikat/',
            'surat_tugas' => 'archive/surat-tugas/'
        ];

        $newPaths = []; // Array untuk menyimpan path baru
        $rollbackPaths = []; // Array untuk menyimpan rollback file

        try {
            // Loop untuk memindahkan file
            foreach ($row as $column => $filePath) {
                if (!empty($filePath)) {
                    $fileName = basename($filePath);
                    $destinationDir = $mapDirectories[$column] ?? '';

                    if (!empty($destinationDir)) {
                        if (!is_dir($destinationDir)) {
                            mkdir($destinationDir, 0777, true);
                        }

                        $destinationPath = $destinationDir . $fileName;

                        if (file_exists($filePath)) {
                            if (rename($filePath, $destinationPath)) {
                                $newPaths[$column] = $destinationPath; // Simpan path baru
                                $rollbackPaths[$column] = $filePath; // Simpan path asli untuk rollback
                            } else {
                                throw new Exception("Gagal memindahkan file $filePath ke $destinationPath");
                            }
                        } else {
                            throw new Exception("File $filePath tidak ditemukan");
                        }
                    }
                }
            }

            // Eksekusi prosedur hanya jika semua file berhasil dipindahkan
            $querySoftDelete = 'EXEC sp_SoftDeletePrestasi 
                @id_prestasi = ?,
                @foto_kompetisi = ?,
                @sertifikat  = ?,
                @flyer  = ?,
                @karya_kompetisi  = ?,
                @surat_tugas  = ?,
                @deskripsi  = ?';

            $params = [
                $id_prestasi,
                $newPaths['foto_kompetisi'] ?? null,
                $newPaths['sertifikat'] ?? null,
                $newPaths['flyer'] ?? null,
                $newPaths['karya_kompetisi'] ?? null,
                $newPaths['surat_tugas'] ?? null,
                $deskripsi
            ];
            $result = $this->db->executeProcedure($querySoftDelete, $params);

            return $result;
        } catch (Exception $e) {
            // Rollback file yang sudah berhasil dipindahkan
            foreach ($rollbackPaths as $column => $originalPath) {
                if (isset($newPaths[$column]) && file_exists($newPaths[$column])) {
                    rename($newPaths[$column], $originalPath); // Kembalikan file ke lokasi semula
                }
            }
            // Lempar ulang exception agar bisa ditangani di luar
            throw $e;
        }
    }

    public function eksporData($export_type = 'all', $kategori = '', $jurusan = '') {
        // Set the base query
        $query = "SELECT 
            p.id_prestasi AS idpres, m.nama AS namaMhs, m.nim AS nimMhs, jn.nama_jurusan AS namaJur, 
            j.jenis_juara AS juara, p.nama_kompetisi AS namaKomp, p.event AS eventKomp, p.penyelenggara AS penyelenggara, 
            k.nama_kategori AS kategori, p.jumlah_peserta AS jlhPeserta, p.dosen_pembimbing_1 AS dosbing1, 
            p.dosen_pembimbing_2 AS dosbing2, FORMAT(CONVERT(DATE, p.tanggal_mulai, 111), 'dd MMMM yyyy', 'id-ID') AS tanggal_mulai,
            FORMAT(CONVERT(DATE, p.tanggal_selesai, 111), 'dd MMMM yyyy', 'id-ID') AS tanggal_selesai, p.flyer AS flyer, p.foto_kompetisi AS foto_kompetisi,
            p.sertifikat AS sertifikat, p.karya_kompetisi AS karya, p.surat_tugas AS surat_tugas
        FROM prestasi p
        JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
        JOIN jurusan jn ON m.id_jurusan = jn.id_jurusan
        JOIN kategori k ON p.id_kategori = k.id_kategori
        JOIN juara j ON p.id_juara = j.id_juara
        ";
        
        // Filter by date if required
        if ($export_type == 'recent') {
            $query .= " WHERE DATEDIFF(day, p.created_date, GETDATE()) <= 30";
        }

        // Filter by category if provided
        if (!empty($kategori)) {
            $query .= " AND k.nama_kategori = ?";
        }

        // Filter by jurusan if provided
        if (!empty($jurusan)) {
            $query .= " AND jn.nama_jurusan = ?";
        }

        // Prepare the query with potential parameters
        $params = [];
        if (!empty($kategori)) {
            $params[] = $kategori;
        }
        if (!empty($jurusan)) {
            $params[] = $jurusan;
        }

        $result = $this->db->fetchAll($query, $params);

        // Filename with timestamp
        $filename = "data_prestasi_" . date('Y-m-d_H-i-s') . ".xlsx";

        // Headers for Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create a new PHPExcel object
        require 'vendor/autoload.php'; // Assuming you're using PhpSpreadsheet
        

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        ob_clean();
        ob_flush();
        // Set Excel headers
        $headers = [
            'A' => 'ID Prestasi', 
            'B' => 'Nama Mahasiswa', 
            'C' => 'NIM',
            'D' => 'Jurusan',
            'E' => 'Peringkat', 
            'F' => 'Nama Kompetisi', 
            'G' => 'Event', 
            'H' => 'Penyelenggara', 
            'I' => 'Kategori', 
            'J' => 'Jumlah Peserta',
            'K' => 'Dosen Pembimbing 1',
            'L' => 'Dosen Pembimbing 2',
            'M' => 'Tanggal Mulai',
            'N' => 'Tanggal Selesai',
            'O' => 'Poster Kompetisi',
            'P' => 'Foto Kompetisi',
            'Q' => 'Sertifikat Kompetisi',
            'R' => 'Karya Kompetisi',
            'S' => 'Surat Tugas'
        ];
        
        // Write headers
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . '1', $header);
        }

        // Write data rows
        $rowCount = 2;
        foreach ($result as $row) {
            // Set basic data
            $sheet->setCellValue('A' . $rowCount, isset($row['idpres']) ? $row['idpres'] : 'N/A');
            $sheet->setCellValue('B' . $rowCount, isset($row['namaMhs']) ? $row['namaMhs'] : 'N/A');
            $sheet->setCellValue('C' . $rowCount, isset($row['nimMhs']) ? $row['nimMhs'] : 'N/A');
            $sheet->setCellValue('D' . $rowCount, isset($row['namaJur']) ? $row['namaJur'] : 'N/A');
            $sheet->setCellValue('E' . $rowCount, isset($row['juara']) ? $row['juara'] : 'N/A');
            $sheet->setCellValue('F' . $rowCount, isset($row['namaKomp']) ? $row['namaKomp'] : 'N/A');
            $sheet->setCellValue('G' . $rowCount, isset($row['eventKomp']) ? $row['eventKomp'] : 'N/A');
            $sheet->setCellValue('H' . $rowCount, isset($row['penyelenggara']) ? $row['penyelenggara'] : 'N/A');
            $sheet->setCellValue('I' . $rowCount, isset($row['kategori']) ? $row['kategori'] : 'N/A');
            $sheet->setCellValue('J' . $rowCount, isset($row['jlhPeserta']) ? $row['jlhPeserta'] : 'N/A');
            $sheet->setCellValue('K' . $rowCount, isset($row['dosbing1']) ? $row['dosbing1'] : 'N/A');
            $sheet->setCellValue('L' . $rowCount, isset($row['dosbing2']) ? $row['dosbing2'] : 'N/A');
            $sheet->setCellValue('M' . $rowCount, isset($row['tanggal_mulai']) ? $row['tanggal_mulai'] : 'N/A');
            $sheet->setCellValue('N' . $rowCount, isset($row['tanggal_selesai']) ? $row['tanggal_selesai'] : 'N/A');
            
            $sheet->setCellValue('O' . $rowCount, isset($row['flyer']) ? $row['flyer'] : 'N/A');
            $filePath = isset($row['flyer']) ? $row['flyer'] : null;
            $fileName = $filePath ? basename($filePath) : 'No file';
            $link_flyer = 'http://localhost/Programs/src/upload/prestasi/flyer/' . $fileName;
            $sheet->getCell('O' . $rowCount)->getHyperlink()->setUrl($link_flyer);

            $sheet->setCellValue('P' . $rowCount, isset($row['foto_kompetisi']) ? $row['foto_kompetisi'] : 'N/A');
            $filePath = isset($row['foto_kompetisi']) ? $row['foto_kompetisi'] : null;
            $fileName = $filePath ? basename($filePath) : 'No file';
            $link_foto = 'http://localhost/Programs/src/upload/prestasi/kompetisi/' . $fileName;
            $sheet->getCell('P' . $rowCount)->getHyperlink()->setUrl($link_foto);
            
            $sheet->setCellValue('Q' . $rowCount, isset($row['sertifikat']) ? $row['sertifikat'] : 'N/A');
            $filePath = isset($row['sertifikat']) ? $row['sertifikat'] : null;
            $fileName = $filePath ? basename($filePath) : 'No file';
            $link_sertif = 'http://localhost/Programs/src/upload/prestasi/sertifikat/' . $fileName;
            $sheet->getCell('Q' . $rowCount)->getHyperlink()->setUrl($link_sertif);

            $sheet->setCellValue('R' . $rowCount, isset($row['karya']) ? $row['karya'] : 'N/A');
            $filePath = isset($row['karya']) ? $row['karya'] : null;
            $fileName = $filePath ? basename($filePath) : 'No file';
            $link_karya = 'http://localhost/Programs/src/upload/prestasi/karya/' . $fileName;
            $sheet->getCell('R' . $rowCount)->getHyperlink()->setUrl($link_karya);

            $sheet->setCellValue('S' . $rowCount, isset($row['surat_tugas']) ? $row['surat_tugas'] : 'N/A');
            $filePath = isset($row['surat_tugas']) ? $row['surat_tugas'] : null;
            $fileName = $filePath ? basename($filePath) : 'No file';
            $link_surat = 'http://localhost/Programs/src/upload/prestasi/surat-tugas/' . $fileName;
            $sheet->getCell('S' . $rowCount)->getHyperlink()->setUrl($link_surat);
            
            $rowCount++;
        }
        
        // Set non-header cells 
        $sheet->getStyle('A:S')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Set header to center alignment
        $sheet->getStyle('A1:S1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'S') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Mendapatkan lokasi sel terakhir yang terisi
        $lastRow = $sheet->getHighestRow(); // Mendapatkan baris terakhir
        $lastColumn = $sheet->getHighestColumn(); // Mendapatkan kolom terakhir (dalam format huruf)
        $lastCell = $lastColumn . $lastRow; // Gabungkan kolom dan baris untuk mendapatkan sel terakhir

        // Create a table range
        $tableRange = 'A1:'.$lastCell; // Adjust based on your data range
        $table = new Table($tableRange);

        // Add table style
        $tableStyle = new TableStyle();
        $tableStyle->setShowRowStripes(true); // Add alternating row colors
        $table->setName('Table'); // Set table name
        $table->setStyle($tableStyle);

        // Add the table to the worksheet
        $sheet->addTable($table);

        // Save Excel file
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    public function closeConnection()
    {
        $this->db->close();
    }
}
