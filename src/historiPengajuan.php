<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Mahasiswa.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

// Cek apakah user memiliki akses
if ($_SESSION['role'] != '3') {
    header('Location: home.php');
}

$user = new Mahasiswa();
$username = $_SESSION['username'];
$nim = $_SESSION['no_induk']; // Pastikan NIM disimpan di sesi saat login
$db = new Database();
$sql = " SELECT 
            nama_kompetisi, 
            event, 
            status, 
            deskripsi
        FROM vw_prestasi_list_by_nim
        WHERE nim = ?";
$prestasiList = $db->fetchAll($sql, [$nim]); // Ambil data prestasi berdasarkan NIM
?>

<html>

<head>
    <title>Pengajuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        rel="stylesheet" />
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

<body class="min-h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r">
        <?php
        echo $user->sidebar();
        ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 pt-8">
        <div>
            <?php
            $user->profile($username);
            ?>
        </div>
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-10 mt-6">Pengajuan Prestasi</h2>
            <table class="w-full bg-white rounded shadow-md">
                <thead>
                    <tr class="bg-orange-500 text-white">
                        <th class="py-3 px-6 border">No</th>
                        <th class="py-3 px-6 border">Nama Kompetisi</th>
                        <th class="py-3 px-6 border">Event</th>
                        <th class="py-3 px-6 border">Status</th>
                        <th class="py-3 px-6 border">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($prestasiList)) {
                        $no = 1;
                        foreach ($prestasiList as $prestasi) {
                            echo "<tr class='text-center hover:bg-gray-100 transition'>";
                            echo "<td class='py-3 px-6 border'>{$no}</td>";
                            echo "<td class='py-3 px-6 border'>{$prestasi['nama_kompetisi']}</td>";
                            echo "<td class='py-3 px-6 border'>{$prestasi['event']}</td>";
                            $statusColor = $prestasi['status'] == 'Disetujui' ? 'text-green-500' : ($prestasi['status'] == 'Menunggu' ? 'text-yellow-500' : 'text-red-500');
                            echo "<td class='py-3 px-6 border {$statusColor}'>{$prestasi['status']}</td>";
                            echo "<td class='py-3 px-6 border'>{$prestasi['deskripsi']}</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='5' class='py-3 px-6 border text-center'>Tidak ada data prestasi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>