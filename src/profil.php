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
    $username = $_SESSION['username'];

    $user = null;
    
    if($role == '1'){
        include_once 'classes/Admin.php';
        $user = new Admin();
    } else if($role == '2'){
        include_once 'classes/Kajur.php';
        $user = new Kajur();
    } else if($role == '3'){
        include_once 'classes/Mahasiswa.php';
        $user = new Mahasiswa();
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

        <style>
            body {
            background: url('img/homepageGradient.png') no-repeat center center fixed; /* Fixed background */
            background-size: cover; /* Ensures the image covers the entire area */
            flex: 1; /* Makes the main content expand to fill the space */
            }
        </style>
    </head>

    <body class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar -->
        <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r min-h-screen">
        <?php 
            echo $user->sidebar();
        ?>
        </aside>
        
        <!-- Main Content -->
        <!-- Profil -->
        <main class="flex-1 p-6 pt-8"> <!-- Added pt-8 for top padding -->
            <div>
                <?php 
                        $user->profilDetail($username);  
                ?>
            </div>

            <!-- List Prestasi -->
            <section class="bg-none p-6 rounded-xl border-2 border-orange-400 mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-4xl font-bold"> Prestasi Saya </h2>
                    <span class="text-4xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                </div>
                <div class="relative mb-4">
                    <input class="w-full p-2 border rounded-lg" placeholder="Cari Prestasi" type="text"/>
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                    <div class="flex justify-between items-center bg-orange-50 p-4 rounded-lg hover:bg-orange-100">
                        <span class="text-xl text-orange-400"> Juara 1 | Software Development | Play IT 1.0 </span>
                        <span class="text-xl font-bold bg-orange-200 text-orange-400 px-4 py-2 rounded"> 160 </span>
                    </div> 
                </div>
            </section> 
        </main>
    </body>
</html>