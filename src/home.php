<?php
    session_start();
    include_once 'config/Database.php';
    include_once 'classes/User.php';
    include_once 'classes/Auth.php';
    Auth::checkLogin();

    // Ambil koneksi dari class Database
    $db = new Database();
    $connection = $db->getConnection();

    // Ambil data dari session
    $role = $_SESSION['role'];
    $no_induk = $_SESSION['no_induk'];

    $sql = "SELECT TOP 5 * FROM leaderboard_view";
    $params = [];

    $leaderboardData = $db->fetchAll($sql, $params);

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

    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r min-h-screen">
        <?php echo $user->sidebar(); ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 pt-8">
        <!-- Top Navigation Section -->
        <div>
            <?php $user->mainContent($no_induk); ?>
        </div>

        <!-- Leaderboard Section -->
        <section class="bg-none p-6 rounded-xl border-2 border-slate-800 mx-auto">
            <h3 class="text-2xl mb-8">Peringkat Prestasi</h3>
            <div class="space-y-3">
                <?php
                if (!empty($leaderboardData)) {
                    // Find the maximum points in the leaderboard for normalization
                    $maxPoints = max(array_column($leaderboardData, 'total_poin'));

                    // Define an array of orange gradient colors
                    $orangeGradient = [
                        'bg-orange-600',   // 1st place
                        'bg-orange-500',   // 2nd place
                        'bg-orange-400',   // 3rd place
                        'bg-orange-300',   // 4th place
                        'bg-orange-200'    // 5th and below
                    ];

                    foreach ($leaderboardData as $index => $data) {
                        // Calculate the width as a percentage of the maximum points
                        $widthPercentage = $maxPoints > 0 ? ($data['total_poin'] / $maxPoints) * 100 : 0;

                        // Select background color based on rank
                        $bgColor = $orangeGradient[$index] ?? end($orangeGradient);
                        ?>
                        <div class="flex flex-col space-y-1">
                            <div class="block md:hidden flex flex-col items-start space-y-1 mb-1">
                                <span class="text-sm font-semibold block">
                                    <?php echo $data['rank']; ?> - <?php echo $data['name']; ?>
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-10 md:h-12 relative">
                                <div class="<?php echo $bgColor; ?> h-10 md:h-12 rounded-full flex items-center justify-between px-2 md:px-4 relative" style="width: <?php echo $widthPercentage; ?>%;">
                                    <span class="hidden md:block text-white font-bold text-xs md:text-base truncate">
                                        <?php echo $data['peringkat']; ?> - <?php echo $data['nama']; ?>
                                    </span>
                                    <span class="text-sm md:text-base text-white font-bold bg-white bg-opacity-20 px-2 py-1 rounded-full whitespace-nowrap">
                                        <?php echo $data['total_poin']; ?> &#9734;
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text-gray-600">Data leaderboard tidak tersedia.</p>';
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>
