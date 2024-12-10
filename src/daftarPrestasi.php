<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Mahasiswa.php';
include_once 'classes/Auth.php';

Auth::checkLogin();


// Cek apakah user memiliki akses
$role = $_SESSION['role'];

$user = null;

if ($role == '1') {
    include_once 'classes/Admin.php';
    $user = new Admin();
} elseif ($role == '2') {
    include_once 'classes/Kajur.php';
    $user = new Kajur();
} elseif ($role == '3') {
    include_once 'classes/Mahasiswa.php';
    $user = new Mahasiswa();
}

// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $search = $_POST['search'] ?? '';
    $filterKategori = $_POST['filterKategori'] ?? '';
    $filterJuara = $_POST['filterJuara'] ?? '';
    $filterJurusan = $_POST['filterJurusan'] ?? '';
    $sort = $_POST['sort'] ?? 'newest';

    echo $user->listPrestasi($search, $filterKategori, $filterJuara, $filterJurusan, $sort);
    exit;
}

$username = $_SESSION['username'];
?>

<html lang="en">

<head>
    <link rel="icon" href="img/pres.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi Mahasiswa</title>
    <!-- Tailwin CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            /* Fixed background */
            background-size: cover;
            /* Ensures the image covers the entire area */
            flex: 1;
            /* Makes the main content expand to fill the space */
        }
    </style>
</head>

<body class="min-h-screen flex flex-col md:flex-row overflow-y-auto">
    <!-- Sidebar -->
    <aside class="flex-1">
        <?php echo $user->sidebar(); ?>
    </aside>

    <!-- Main Content -->

    <main class="flex-2 lg:overflow-y-auto md:w-[calc(100%-5rem)] lg:w-[calc(100%-16rem)] p-4 md:p-6 pt-8 bg-white/60 md:bg-transparent">
        <div class="container mx-auto max-w-full space-y-6">

            <?php $user->profile($username); ?>

            <h1 class="text-2xl font-bold mb-10 mt-6">Daftar Prestasi Mahasiswa</h1>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                <!-- Sorting: Left Corner -->
                <div class="w-full md:w-auto">
                    <select id="sortBy" class="border rounded-2xl py-2 px-4 w-full md:w-auto focus:ring-2 focus:ring-blue-300 transition duration-300">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="A-Z">A-Z</option>
                        <option value="Z-A">Z-A</option>
                    </select>
                </div>

                <!-- Search: Center -->
                <div class="flex w-full md:w-auto">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari berdasarkan nama mahasiswa, kompetisi, atau event"
                        class="border rounded-l-2xl p-2 w-full md:w-[500px] focus:ring-2 focus:ring-blue-300 transition duration-300" />
                    <button id="searchButton" class="bg-blue-500 text-white px-4 py-2 rounded-r-2xl hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 transition duration-300">
                        Cari
                    </button>
                </div>



                <!-- Filters: Right Corner -->
                <div class="flex flex-wrap gap-2 w-full md:w-auto justify-end">
                    <select id="filterKategori" class="border rounded-2xl p-2 w-full md:w-auto focus:ring-2 focus:ring-blue-300 transition duration-300">
                        <option value="">Semua Kategori</option>
                        <option value="Internasional">Internasional</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Regional">Regional</option>
                        <option value="Lokal">Lokal</option>
                    </select>

                    <select id="filterJuara" class="border rounded-2xl p-2 w-full md:w-auto focus:ring-2 focus:ring-blue-300 transition duration-300">
                        <option value="">Semua Juara</option>
                        <option value="Juara 1">Juara 1</option>
                        <option value="Juara 2">Juara 2</option>
                        <option value="Juara 3">Juara 3</option>
                        <option value="Harapan 1">Harapan 1</option>
                        <option value="Harapan 2">Harapan 2</option>
                        <option value="Harapan 3">Harapan 3</option>
                    </select>

                    <select id="filterJurusan" class="border rounded-2xl p-2 w-full md:w-auto focus:ring-2 focus:ring-blue-300 transition duration-300">
                        <option value="">Semua Jurusan</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                        <option value="Teknik Kimia">Teknik Kimia</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                        <option value="Teknik Sipil">Teknik Sipil</option>
                        <option value="Akuntansi">Akuntansi</option>
                        <option value="Adminitrasi Niaga">Adminitrasi Niaga</option>
                    </select>
                </div>
            </div>

            <table class="w-full bg-white rounded-3xl overflow-hidden">
                <thead>
                    <tr class="bg-orange-500 text-white">
                        <th class="py-3 px-6 border-r">No</th>
                        <th class="py-3 px-6 border-r">Nama Mahasiswa</th>
                        <th class="py-3 px-6 border-r">Jurusan</th>
                        <th class="py-3 px-6 border-r">Nama Kompetisi</th>
                        <th class="py-3 px-6 border-r">Event</th>
                        <th class="py-3 px-6 border-r">Juara</th>
                        <th class="py-3 px-6">Tingkat Kompetisi</th>
                        <th class="py-3 px-6 border-l">Tahun</th>
                        <?php
                        if ($user instanceof Kajur  || $user instanceof Admin) {
                            echo "<th class='py-3 px-6 border'>Aksi</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data akan dimuat oleh AJAX -->
                </tbody>
            </table>

            <div id="pagination" class="flex justify-center mt-4">
                <!-- Pagination angka akan dimuat oleh AJAX -->
            </div>
        </div>

    </main>

    <script>
        function loadTable(page = 1) {
            const search = $('#searchInput').val();
            const sort = $('#sortBy').val();
            const filterKategori = $('#filterKategori').val();
            const filterJuara = $('#filterJuara').val();
            const filterJurusan = $('#filterJurusan').val();

            $.ajax({
                url: 'daftarPrestasi.php',
                method: 'POST',
                data: {
                    search: search,
                    sort: sort,
                    filterKategori: filterKategori,
                    filterJuara: filterJuara,
                    filterJurusan: filterJurusan,
                    page: page
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    $('#tableBody').html(data.rows);

                    // Update pagination
                    const {
                        current_page,
                        total_pages
                    } = data.pagination;
                    let paginationHtml = '';

                    for (let i = 1; i <= total_pages; i++) {
                        paginationHtml += `<button 
                        class="px-4 py-2 mx-1 mb-12 ${i === current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'} rounded" 
                        onclick="loadTable(${i})">${i}</button>`;
                    }

                    $('#pagination').html(paginationHtml);
                },
                error: function() {
                    $('#tableBody').html('<tr><td colspan="8" class="text-center">Gagal memuat data.</td></tr>');
                }
            });
        }

        $(document).ready(function() {
            loadTable();

            $(document).on('click', '.delete-button', function() {
                const prestasiId = $(this).data('id'); // Ambil ID Prestasi

                // SweetAlert untuk Konfirmasi Hapus
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Masukkan alasan untuk penghapusan data ini.',
                    input: 'text',
                    inputPlaceholder: 'Alasan penghapusan',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Alasan penghapusan diperlukan!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data ke server
                        $.ajax({
                            url: 'hapusPrestasi.php',
                            method: 'POST',
                            data: {
                                'id_prestasi': prestasiId,
                                'alasan': result.value
                            },
                            success: function(response) {
                                // SweetAlert menampilkan pesan sukses atau error
                                Swal.fire({
                                    title: 'Respon Server',
                                    text: response, // Tampilkan respons teks dari server
                                    icon: 'success'
                                }).then(() => {
                                    loadTable(); // Refresh tabel setelah penghapusan
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan pada server.',
                                    icon: 'error'
                                });
                                console.error('Server error:', error);
                                console.error('Response:', xhr.responseText);
                            }
                        });
                    }
                });
            });

            $('#searchButton').on('click', () => loadTable());
            $('#sortBy, #filterKategori, #filterJuara, #filterJurusan').on('change', () => loadTable());
        });
    </script>
</body>

</html>