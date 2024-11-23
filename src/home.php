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

    // Data dummy untuk leaderboard (bisa diganti dengan query database)
    $leaderboardData = [
        ['rank' => 1, 'name' => 'Dwi Ahmad Khairy', 'points' => 180],
        ['rank' => 2, 'name' => 'Abdullah Shamil Basayev', 'points' => 160],
        ['rank' => 3, 'name' => 'Rizki Rahmat', 'points' => 96],
        ['rank' => 4, 'name' => 'Adinda Lova', 'points' => 68],
        ['rank' => 5, 'name' => 'Amanda M.', 'points' => 45],
    ];

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
    <title>Prespol - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-white to-orange-100 min-h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r">
    <?php 
        echo $user->sidebar();
    ?>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 p-6 pt-8"> <!-- Added pt-8 for top padding -->
        <!-- Top Navigation Section -->
        <?php 
                $user->mainContent($username);  
        ?>

        <!-- Leaderboard Section -->
        <section class="bg-white p-6 rounded shadow">
            <h3 class="text-2xl font-bold mb-4">Peringkat Prestasi</h3>
            <div class="space-y-4">
                <?php foreach ($leaderboardData as $data): ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl font-bold mr-4">#<?php echo $data['rank']; ?></span>
                            <div class="bg-orange-500 text-white py-2 px-4 rounded-full">
                                <?php echo $data['name']; ?>
                            </div>
                        </div>
                        <span class="text-xl font-bold"><?php echo $data['points']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>

</html>
