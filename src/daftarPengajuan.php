<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

if ($_SESSION['role'] != '1') {
    header('Location: home.php');
}

$no_induk = $_SESSION['no_induk'];

$user = new Admin($no_induk);

// Get current page from URL, default to 1
$pengajuanPage = isset($_GET['pengajuan_page']) ? intval($_GET['pengajuan_page']) : 1;
$dilayaniPage = isset($_GET['dilayani_page']) ? intval($_GET['dilayani_page']) : 1;

// Determine active tab
$activeTab = isset($_GET['active_tab']) ? $_GET['active_tab'] : 'pengajuan';

// Get paginated lists
$listPengajuan = $user->getPrestasiPendingList($pengajuanPage);
$listDilayani = $user->getPrestasiVerifiedList($no_induk, $dilayaniPage);
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
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            background-size: cover;
            flex: 1;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 h-screen fixed top-0 left-0 border-r">
        <?php echo $user->sidebar(); ?>
    </aside>
    
    <!-- Main Content -->
    <main class="ml-[20%] w-[80%] p-8">
    <button id="btnPengajuan" class="bg-blue-600 text-white px-4 py-2 rounded-md mt-4" 
            onclick="switchTab('pengajuan')">Pengajuan</button>
    <button id="btnDilayani" class="bg-green-600 text-white px-4 py-2 rounded-md mt-4" 
            onclick="switchTab('dilayani')">Dilayani</button>
    
    <!-- Table Pengajuan -->
    <div id="tablePengajuan" class="container mx-auto py-8 <?php echo $activeTab === 'dilayani' ? 'hidden' : ''; ?>">
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
                $no = ($listPengajuan['currentPage'] - 1) * 10 + 1;
                foreach ($listPengajuan['data'] as $item): 
                ?>
                    <tr class="border-b">
                        <td class='py-3 px-6 border'><?php echo $no++; ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_mahasiswa']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kompetisi']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kategori']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['jenis_juara']); ?></td>
                        <td class='py-3 px-6 border text-center'>
                            <a href="detailPengajuan.php?id_pending=<?php echo $item['id_pending']; ?>">
                                <button class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700'>Detail</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Pagination for Pengajuan -->
        <div class="flex justify-center mt-4">
            <?php for ($i = 1; $i <= $listPengajuan['totalPages']; $i++): ?>
                <a href="?pengajuan_page=<?php echo $i; ?>&dilayani_page=<?php echo $dilayaniPage; ?>&active_tab=pengajuan" 
                   class="mx-1 px-3 py-1 mb-12 <?php echo $i == $listPengajuan['currentPage'] ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?> rounded">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    
    <!-- Table Dilayani -->
    <div id="tableDilayani" class="container mx-auto py-8 <?php echo $activeTab === 'pengajuan' ? 'hidden' : ''; ?>">
        <h1 class="text-2xl font-bold mb-4">Daftar Prestasi Dilayani</h1>
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-orange-500 text-white">
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">Nama Mahasiswa</th>
                    <th class="py-2 px-4">Nama Kompetisi</th>
                    <th class="py-2 px-4">Kategori</th>
                    <th class="py-2 px-4">Juara</th>
                    <th class="py-2 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = ($listDilayani['currentPage'] - 1) * 10 + 1;
                foreach ($listDilayani['data'] as $item): 
                ?>
                    <tr class="border-b">
                        <td class='py-3 px-6 border'><?php echo $no++; ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_mahasiswa']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kompetisi']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kategori']); ?></td>
                        <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['jenis_juara']); ?></td>
                        <td class='py-3 px-6 border 
                            <?php 
                                echo ($item['status_validasi'] === 'valid') ? 'text-green-600 font-bold' : 
                                    (($item['status_validasi'] === 'tolak' || $item['status_validasi'] === 'dihapus') ? 'text-red-600 font-bold' : '');
                            ?>'>
                            <?php echo htmlspecialchars($item['status_validasi']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Pagination for Dilayani -->
        <div class="flex justify-center mt-4">
            <?php for ($i = 1; $i <= $listDilayani['totalPages']; $i++): ?>
                <a href="?pengajuan_page=<?php echo $pengajuanPage; ?>&dilayani_page=<?php echo $i; ?>&active_tab=dilayani" 
                   class="mx-1 px-3 py-1 mb-12 <?php echo $i == $listDilayani['currentPage'] ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?> rounded">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</main>
<script>
    function switchTab(tab) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('active_tab', tab);
        window.location.search = urlParams.toString();
    }
</script>
</body>
</html>
