<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Mahasiswa.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

// Cek apakah user memiliki akses
if ($_SESSION['role'] != '3') {
    header('Location: home.php');
}

$user = new Mahasiswa();
$username = $_SESSION['username'];
$nim = $_SESSION['no_induk']; // Pastikan NIM disimpan di sesi saat login

$diprosesPage = isset($_GET['diproses_page']) ? intval($_GET['diproses_page']) : 1;
$sudahDiprosesPage = isset($_GET['sudahDiproses_page']) ? intval($_GET['sudahDiproses_page']) : 1;

$activeTab = isset($_GET['active_tab']) ? $_GET['active_tab'] : 'diproses';

$listDiproses = $user->getHistoryPendingList($nim, $diprosesPage);
$listSudahDiproses = $user->getHistoryPrestasiList($nim, $sudahDiprosesPage);
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
            background-size: cover;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r">
        <?php echo $user->sidebar(); ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 pt-8">
        <div>
            <?php $user->profile($username); ?>
        </div>

        <!-- Buttons -->
        <button id="btnDiproses" class="bg-blue-600 text-white px-4 py-2 rounded-md mt-4" 
            onclick="switchTab('diproses')">Sedang Diproses</button>
        <button id="btnSudahDiproses" class="bg-green-600 text-white px-4 py-2 rounded-md mt-4" 
            onclick="switchTab('sudahDiproses')">Sudah Diproses</button>

        <!-- Table Pengajuan -->
        <div id="tablePengajuan" class="container mx-auto py-8 <?php echo $activeTab === 'sudahDiproses' ? 'hidden' : ''; ?>">
            <h1 class="text-2xl font-bold mb-4">Daftar prestasi dalam proses validasi</h1>
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-orange-500 text-white">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Nama Kompetisi</th>
                        <th class="py-2 px-4">Event</th>
                        <th class="py-2 px-4">Status Validasi</th>
                        <th class="py-2 px-4">Deskripsi Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = ($listDiproses['currentPage'] - 1) * 10 + 1;
                    foreach ($listDiproses['data'] as $item): 
                    ?>
                        <tr class="border-b">
                            <td class='py-3 px-6 border'><?php echo $no++; ?></td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kompetisi']); ?></td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['event']); ?></td>
                            <td class='py-3 px-6 border text-orange-600 font-bold'><?php echo htmlspecialchars($item['status']); ?></td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['deskripsi']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination for Pengajuan -->
            <div class="flex justify-center mt-4">
                <?php for ($i = 1; $i <= $listDiproses['totalPages']; $i++): ?>
                    <a href="?diproses_page=<?php echo $i; ?>&sudahDiproses_page=<?php echo $sudahDiprosesPage; ?>&active_tab=diproses" 
                    class="mx-1 px-3 py-1 mb-12 <?php echo $i == $listDiproses['currentPage'] ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?> rounded">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Table Dilayani -->
        <div id="tableDilayani" class="container mx-auto py-8 <?php echo $activeTab === 'diproses' ? 'hidden' : ''; ?>">
            <h1 class="text-2xl font-bold mb-4">Daftar Prestasi yang sudah divalidasi</h1>
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-orange-500 text-white">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Nama Kompetisi</th>
                        <th class="py-2 px-4">Event</th>
                        <th class="py-2 px-4">Status Validasi</th>
                        <th class="py-2 px-4">Deskripsi Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = ($listSudahDiproses['currentPage'] - 1) * 10 + 1;
                    foreach ($listSudahDiproses['data'] as $item): 
                    ?>
                        <tr class="border-b">
                            <td class='py-3 px-6 border'><?php echo $no++; ?></td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['nama_kompetisi']); ?></td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['event']); ?></td>
                            <td class='py-3 px-6 border 
                                <?php 
                                    echo ($item['status'] === 'valid') ? 'text-green-600 font-bold' : 
                                        (($item['status'] === 'tolak' || $item['status'] === 'dihapus') ? 'text-red-600 font-bold' : '');
                                ?>'>
                                <?php echo htmlspecialchars($item['status']); ?>
                            </td>
                            <td class='py-3 px-6 border'><?php echo htmlspecialchars($item['deskripsi']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination for Dilayani -->
            <div class="flex justify-center mt-4">
                <?php for ($i = 1; $i <= $listSudahDiproses['totalPages']; $i++): ?>
                    <a href="?diproses_page=<?php echo $diprosesPage; ?>&sudahDiproses_page=<?php echo $i; ?>&active_tab=sudahDiproses" 
                    class="mx-1 px-3 py-1 mb-12 <?php echo $i == $listSudahDiproses['currentPage'] ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?> rounded">
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
