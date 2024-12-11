<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Kajur.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';
include_once 'classes/Admin.php';

Auth::checkLogin();

if ($_SESSION['role'] == '3') {
    header('Location: home.php');
}
$no_induk = $_SESSION['no_induk'];
if($_SESSION['role'] == '1'){
    $user = new Admin($no_induk);
} else if($_SESSION['role'] == '2'){
    $user = new Kajur($no_induk);
}


$db = new Database();

if (isset($_GET['export']) && $_GET['export'] == 'achievements') {
    $export_type = $_GET['export_type'] ?? 'all';
    $kategori = $_GET['kategori'] ?? '';
    $jurusan = $_GET['jurusan'] ?? '';

    // Call the export function
    $user->eksporData($export_type, $kategori, $jurusan);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Data Prestasi | PRESPOL</title>
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
        <div class="container mx-auto max-w-3/4 space-y-6">
                <h1 class="text-2xl font-bold mb-4">
                    Ekspor Data Prestasi Mahasiswa
                </h1>
                
                <div class="space-y-8 mt-16">
                    <form action="eksporData.php" method="get" class="space-y-4">
                        <input type="hidden" name="export" value="achievements">
                        
                        <div class="flex flex-col space-y-2">
                            <label for="export-type" class="text-gray-700 font-medium">
                                Pilihan Ekspor
                            </label>
                            <select 
                                id="export-type" 
                                name="export_type" 
                                class="w-3/4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="all">Seluruh Data</option>
                                <option value="recent">Data 30 Hari Terakhir</option>
                            </select>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <label for="kategori" class="text-gray-700 font-medium">
                                Kategori
                            </label>
                            <select 
                                id="kategori" 
                                name="kategori" 
                                class="w-3/4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Seluruh Kategori</option>
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Regional">Regional</option>
                                <option value="Lokal">Lokal</option>
                            </select>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <label for="jurusan" class="text-gray-700 font-medium">
                                Jurusan
                            </label>
                            <select 
                                id="jurusan" 
                                name="jurusan" 
                                class="w-3/4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Seluruh Jurusan</option>
                                <option value="Adminitrasi Niaga">Adminitrasi Niaga</option>
                                <option value="Akuntansi">Akuntansi</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Teknik Kimia">Teknik Kimia</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
                                <option value="Teknologi Informasi">Teknologi Informasi</option>
                            </select>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-3/4 bg-orange-500 text-white p-2 rounded-md hover:bg-orange-400 transition duration-300 flex items-center justify-center"
                        >
                            Unduh
                        </button>
                    </form>
                </div>
        </div>
    </main>
</body>
</html>