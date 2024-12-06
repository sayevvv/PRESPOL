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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi Mahasiswa</title>
    <!-- Tailwin CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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

<body class=" min-h-screen flex flex-col lg:flex-row">

    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 h-screen fixed top-0 left-0 border-r">
        <?php echo $user->sidebar(); ?>
    </aside>

    <!-- Main Content -->

    <main class="ml-[20%] w-[80%] p-8 pb-12 min-h-screen">
        <?php $user->profile($username); ?>

        <h1 class="text-2xl font-bold mb-10 mt-6">Daftar Prestasi Mahasiswa</h1>

        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            <!-- Sorting: Pojok Kiri -->
            <div class="w-full md:w-auto">
                <select id="sortBy" class="border rounded p-2 w-full md:w-auto">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="A-Z">A-Z</option>
                    <option value="Z-A">Z-A</option>
                </select>
            </div>

            <!-- Search: Tengah -->
            <div class="flex items-center w-full md:w-auto">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari berdasarkan nama mahasiswa, kompetisi, atau event"
                    class="border rounded-l p-2 w-full md:w-96" />
                <button id="searchButton" class="bg-blue-500 text-white px-4 py-2 rounded-r">Cari</button>
            </div>

            <!-- Filters: Pojok Kanan -->
            <div class="flex gap-2 w-full md:w-auto justify-end">
                <select id="filterKategori" class="border rounded p-2">
                    <option value="">Semua Kategori</option>
                    <option value="Internasional">Internasional</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Regional">Regional</option>
                    <option value="Lokal">Lokal</option>
                </select>

                <select id="filterJuara" class="border rounded p-2">
                    <option value="">Semua Juara</option>
                    <option value="Juara 1">Juara 1</option>
                    <option value="Juara 2">Juara 2</option>
                    <option value="Juara 3">Juara 3</option>
                    <option value="Harapan 1">Harapan 1</option>
                    <option value="Harapan 2">Harapan 2</option>
                    <option value="Harapan 3">Harapan 3</option>
                </select>

                <select id="filterJurusan" class="border rounded p-2">
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

        <div class="flex justify-between items-center mt-4 mb-12 pb-12">
            <button id="prevPage" class="bg-gray-400 text-white px-4 py-2 rounded" disabled>Previous</button>
            <span id="paginationInfo"></span>
            <button id="nextPage" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
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
            success: function (response) {
                const data = JSON.parse(response);
                $('#tableBody').html(data.rows);

                // Update pagination
                const { current_page, total_pages } = data.pagination;
                $('#paginationInfo').text(`Page ${current_page} of ${total_pages}`);
                $('#prevPage').prop('disabled', current_page <= 1);
                $('#nextPage').prop('disabled', current_page >= total_pages);

                // Attach new page handlers
                $('#prevPage').off('click').on('click', function () {
                    if (current_page > 1) loadTable(current_page - 1);
                });
                $('#nextPage').off('click').on('click', function () {
                    if (current_page < total_pages) loadTable(current_page + 1);
                });
            },
            error: function () {
                $('#tableBody').html('<tr><td colspan="9" class="text-center">Gagal memuat data.</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        loadTable();

        $('#searchButton').on('click', () => loadTable());
        $('#sortBy, #filterKategori, #filterJuara, #filterJurusan').on('change', () => loadTable());
    });
</script>

</body>

</html>