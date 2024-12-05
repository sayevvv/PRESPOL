<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

if($_SESSION['role'] != '1'){
    header('Location: home.php');
}


$db = new Database();
$user = new Admin($db);
$list = $user->getPrestasiPendingList();

$no = 1; // Inisialisasi variabel nomor urut
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan Prestasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed; /* Fixed background */
            background-size: cover; /* Ensures the image covers the entire area */
            flex: 1; /* Makes the main content expand to fill the space */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 h-screen fixed top-0 left-0 border-r">
    <?php 
        echo $user->sidebar();
    ?>
    </aside>
    
    <!-- Main Content -->
    <main class="ml-[20%] w-[80%] p-8"> <!-- Added pt-8 for top padding -->
        <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Daftar Pengajuan Prestasi</h1>
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500 text-white">
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">Nama Mahasiswa</th>
                    <th class="py-2 px-4">Nama Kompetisi</th>
                    <th class="py-2 px-4">Kategori</th>
                    <th class="py-2 px-4">Juara</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list as $item): ?>
                    <tr class="border-b">
                        <td class='py-3 px-6 border'><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_mahasiswa']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kompetisi']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kategori']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['jenis_juara']); ?></td>
                        <td class='py-3 px-6 border text-center'>
                                <a href="detailPengajuan.php?id_pending=<?php echo $item['id_pending']; ?>">
                                    <button class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700'>
                                        Detail
                                    </button>
                                </a>
                            </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </main>
</body>
</html>
