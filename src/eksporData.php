<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Kajur.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

if ($_SESSION['role'] != '2') {
    header('Location: home.php');
}

$db = new Database();
$user = new Kajur($db);

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
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md ">
            <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">
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
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                        class="w-full bg-orange-500 text-white p-2 rounded-md hover:bg-orange-400 transition duration-300 flex items-center justify-center"
                    >
                        Unduh
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>