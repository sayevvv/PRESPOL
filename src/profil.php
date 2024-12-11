<?php

include_once 'config/Database.php';
include_once 'classes/User.php';

// Ambil koneksi dari class Database
$db = new Database();
$connection = $db->getConnection();

session_start();

// Redirect ke halaman login jika belum login
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// Ambil data dari session
$role = $_SESSION['role'];
$no_induk = $_SESSION['no_induk'];

$user = null;

if ($role == '1') {
    include_once 'classes/Admin.php';
    $user = new Admin($no_induk);
} else if ($role == '2') {
    include_once 'classes/Kajur.php';
    $user = new Kajur($no_induk);
} else if ($role == '3') {
    include_once 'classes/Mahasiswa.php';
    $user = new Mahasiswa($no_induk);
    
    $sql = 'SELECT total_poin FROM leaderboard_view WHERE nim = ?';
    $params = [$no_induk];
    $stmt = $db->fetchOne($sql, $params);

    $totalPoin = $stmt['total_poin'];

    // Handle AJAX request for prestasi data
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['page'])) {
        $page = $_POST['page'] ?? 1;
        $search = $_POST['search'] ?? '';

        $result = $user->listPrestasiByNim($page, 10, $search);

        $data = $result['data'];
        $total = $result['total'];
        $totalPages = ceil($total / 10);

        $html = '';
        foreach ($data as $prestasi) {
            $html .= "<a href=\"detailPrestasi.php?id_prestasi={$prestasi['id_prestasi']}\" class=\"flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100\">"
                . "<span class=\"text-xl text-orange-400\">{$prestasi['juara']} | {$prestasi['nama_kompetisi']} | {$prestasi['event']}</span>"
                . "<span class=\"text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded\">{$prestasi['total_poin']}</span>"
                . "</a>";
        }


        $pagination = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            $pagination .= "<a href=\"#\" class=\"pagination-link p-2 " . ($i == $page ? 'font-bold' : '') . "\" data-page=\"$i\">$i</a> ";
        }

        echo json_encode([
            'html' => $html,
            'pagination' => $pagination
        ]);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="img/pres.png" type="image/x-icon">

    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            background-size: cover;
            flex: 1;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col md:flex-row">
    <!-- Sidebar -->
    <div class="flex-1">
        <?php
        echo $user->sidebar();
        ?>
    </div>

    <!-- Main Content -->
    <main class="flex-2 lg:overflow-y-auto md:w-[calc(100%-5rem)] lg:w-[calc(100%-16rem)] p-4 md:p-6 pt-8 bg-white/60 md:bg-transparent">
        <div class="container mx-auto max-w-full space-y-6">
            <div>
                <?php $user->profilDetail(); ?>
            </div>

            <?php
            if ($user instanceof Mahasiswa):
                echo
                <<<HTML
                        <section class="bg-white/60 p-6 rounded-xl border mx-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-base font-bold md:text-xl mb-6 md:mb-8">Prestasi Saya</h2>
                                <p class='text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded'>$totalPoin</p>
                            </div>

                            <!-- Search Input -->
                            <div class="relative mb-4">
                                <input id="searchInput" class="w-full p-2 border rounded-lg" placeholder="Cari Prestasi" type="text"/>
                                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                            </div>

                            <!-- Prestasi Table -->
                            <div id="prestasiContainer">
                                <!-- Data will be loaded here dynamically -->
                            </div>

                            <!-- Pagination -->
                            <div id="pagination" class="flex justify-center mt-4"></div>
                        </section>
                    HTML;
            elseif ($user instanceof Admin):
                echo
                <<<HTML
                        <header class="flex flex-col lg:flex-row justify-between items-center mb-8">
                        </header>
                    HTML;
            elseif ($user instanceof Kajur):
                echo
                <<<HTML
                        <header class="flex flex-col lg:flex-row justify-between items-center mb-8">
                        </header>
                    HTML;
            endif;
            ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadPrestasi(page = 1) {
            const search = $('#searchInput').val();
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    page,
                    search
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    $('#prestasiContainer').html(data.html);
                    $('#pagination').html(data.pagination);
                },
                error: function() {
                    $('#prestasiContainer').html('<div class="text-center">Gagal memuat data.</div>');
                }
            });
        }

        $(document).ready(function() {
            loadPrestasi();

            $('#searchInput').on('keyup', function() {
                loadPrestasi();
            });

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                loadPrestasi(page);
            });
        });
    </script>
</body>

</html>