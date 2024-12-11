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
$listDilayani = $user->getPrestasiVerifiedList($dilayaniPage);
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

<body class="min-h-screen flex flex-col md:flex-row max-h-[400px] overflow-y-auto 
            [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-neutral-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-neutral-300">
    <!-- Sidebar -->
    <aside class="flex-1">
        <?php echo $user->sidebar(); ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-2 lg:overflow-y-auto md:w-[calc(100%-5rem)] lg:w-[calc(100%-16rem)] p-4 md:p-6 pt-8 bg-white/60 md:bg-transparent">
        <div class="container mx-auto max-w-full space-y-6">
            <!-- Table Pengajuan -->
            <div id="tablePengajuan" class="container mx-auto py-8 <?php echo $activeTab === 'dilayani' ? 'hidden' : ''; ?>">
                <h1 class="text-2xl font-bold mb-4">Daftar prestasi dalam proses validasi</h1>
                <div class="flex justify-end mb-4">
                    <select id="tabSelector" class="px-4 py-2 border rounded-2xl" onchange="switchTab(this.value)">
                        <option value="pengajuan" <?php echo ($activeTab === 'pengajuan' || $activeTab === '') ? 'selected' : ''; ?>>
                            Sedang Diproses
                        </option>
                        <option value="dilayani" <?php echo $activeTab === 'dilayani' ? 'selected' : ''; ?>>
                            Sudah Diproses
                        </option>
                    </select>
                </div>
                <table class="w-full bg-white rounded-3xl overflow-hidden">
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
                <h1 class="text-2xl font-bold mb-4">Daftar Prestasi yang sudah divalidasi</h1>
                <div class="flex justify-end mb-4">
                    <select id="tabSelector" class="px-4 py-2 border rounded-2xl" onchange="switchTab(this.value)">
                        <option value="pengajuan" <?php echo ($activeTab === 'pengajuan' || $activeTab === '') ? 'selected' : ''; ?>>
                            Sedang Diproses
                        </option>
                        <option value="dilayani" <?php echo $activeTab === 'dilayani' ? 'selected' : ''; ?>>
                            Sudah Diproses
                        </option>
                    </select>
                </div>
                <table class="w-full bg-white rounded-3xl overflow-hidden">
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
                                echo ($item['status_validasi'] === 'valid') ? 'text-green-600 font-bold' : (($item['status_validasi'] === 'tolak' || $item['status_validasi'] === 'dihapus') ? 'text-red-600 font-bold' : '');
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