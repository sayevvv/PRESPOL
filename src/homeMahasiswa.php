<?php

    include_once 'config/Database.php';

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
        <div class="flex items-center mb-8">
            <i class="fas fa-trophy text-orange-500 text-2xl"></i>
            <span class="ml-2 text-xl font-bold">Prespol</span>
        </div>
        <nav class="space-y-4">
            <a href="#" class="flex items-center text-gray-700 hover:text-orange-500">
                <i class="fas fa-home mr-2"></i> Beranda
            </a>
                <a href="submit_prestasi.php" class="flex items-center text-gray-700 hover:text-orange-500">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Prestasi
                </a>
                <a href="view_progress.php" class="flex items-center text-gray-700 hover:text-orange-500">
                    <i class="fas fa-chart-line mr-2"></i> List Prestasi
                </a>
                <a href="view_progress.php" class="flex items-center text-gray-700 hover:text-orange-500">
                    <i class="fas fa-chart-line mr-2"></i> Profil
                </a>
                <a href="view_progress.php" class="flex items-center text-gray-700 hover:text-orange-500">
                    <i class="fas fa-chart-line mr-2"></i> Pengajuan
                </a>
            <a href="logout.php" class="flex items-center text-gray-700 hover:text-orange-500">
                <i class="fas fa-sign-out-alt mr-2"></i> Setting
            </a>
        </nav>
    </aside>
     <!-- Main Content -->
     <main class="flex-1 p-6 pt-8"> <!-- Added pt-8 for top padding -->
        <!-- Top Navigation Section -->
        <div class="flex justify-between items-center p-4" style="margin: 0; background: none;">
    <div class="flex items-center ml-auto"> <!-- Added ml-auto to push this div to the right -->
        <h3 class="text-xl font-bold"
        ><?php 

            try {
                // Query untuk mengambil data nama dan foto profil
                $sql = "SELECT 
                            nama,
                            foto_profile
                        FROM mahasiswa
                        WHERE nim = ?";

                $params = [$username]; // Gunakan array untuk parameter

                // Siapkan query menggunakan prepared statement
                $stmt = sqlsrv_prepare($connection, $sql, $params);

                if ($stmt === false) {
                    throw new Exception('Gagal mempersiapkan statement: ' . print_r(sqlsrv_errors(), true));
                }

                // Eksekusi query
                if (sqlsrv_execute($stmt) === false) {
                    throw new Exception('Gagal mengeksekusi statement: ' . print_r(sqlsrv_errors(), true));
                }

                // Ambil hasil query
                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                if ($row) {
                    $nama = $row['nama'] ?? 'Unknown';
                    $fotoProfile = $row['foto_profile'] ?? 'default-profile.png';
                    echo $nama;
                } else {
                    throw new Exception('Data tidak ditemukan untuk username: ' . htmlspecialchars($username));
                }
            } catch (Exception $e) {
                // Simpan log kesalahan untuk debugging (opsional)
                error_log($e->getMessage());

                // Tampilkan pesan error yang ramah
                echo "<p style='color: red;'>Terjadi kesalahan saat mengambil data pengguna. Silakan coba lagi nanti.</p>";
            }
            
        ?></h3>
        <img src="<?php echo htmlspecialchars($fotoProfile); ?>" alt="Profile Picture" class="w-10 h-10 rounded-full ml-2"> <!-- Icon on the right -->
    </div>
</div>

        <header class="flex flex-col lg:flex-row justify-between items-center mb-8">
            <div class="text-center lg:text-left">
                <h1 class="text-3xl font-bold">Selamat Datang</h1>
                <h2 class="text-5xl font-bold text-black">Champions!</h2>
                <p class="text-orange-500 mt-2">Kamu peringkat</p>
                <button onclick="window.location.href='input.php'" class="mt-4 bg-black text-white py-2 px-6 rounded hover:bg-gray-800">
                    Tambah Prestasi
                </button>
            </div>
        </header>

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
