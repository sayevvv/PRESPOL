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
    $username = $_SESSION['username'];

    // Data dummy untuk leaderboard (bisa diganti dengan query database)
    $leaderboardData = [
        ['rank' => 1, 'name' => 'Dwi Ahmad Khairy', 'points' => 180],
        ['rank' => 2, 'name' => 'Abdullah Shamil Basayev', 'points' => 120],
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

    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            /* Fixed background */
            background-size: cover;
            /* Ensures the image covers the entire area */
            flex: 1;
            /* Makes the main content expand to fill the space */
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r min-h-screen">
        <?php
        echo $user->sidebar();
        ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 pt-8"> <!-- Added pt-8 for top padding -->
        <!-- Top Navigation Section -->
        <div>
            <?php
            $user->mainContent($username);
            ?>
        </div>

        <!-- Leaderboard Section -->
        <section class="bg-none p-6 rounded-xl border-2 border-slate-800 mx-auto">
            <h3 class="text-2xl mb-8">Peringkat Prestasi</h3>
            <div class="space-y-3">
                <?php
                // Find the maximum points in the leaderboard for normalization
                $maxPoints = max(array_column($leaderboardData, 'points'));

                // Define an array of orange gradient colors
                $orangeGradient = [
                    'bg-orange-500',   // 1st place
                    'bg-orange-400',   // 2nd place
                    'bg-orange-300',   // 3rd place
                    'bg-orange-300',   // 4th place
                    'bg-orange-300'    // 5th and below
                ];
                foreach ($leaderboardData as $index => $data):
                    // Calculate the width as a percentage of the maximum points
                    $widthPercentage = ($data['points'] / $maxPoints) * 100;

                    // Select background color based on rank (use last color for ranks beyond the gradient)
                    $bgColor = $orangeGradient[$index] ?? end($orangeGradient);
                ?>
                    <div class="flex flex-col space-y-1">
                        <div class="w-full bg-gray-200 rounded-full h-12 relative">
                            <div class="<?php echo $bgColor; ?> h-12 rounded-full flex items-center justify-between px-4 relative" style="width: <?php echo $widthPercentage; ?>%;">
                                <span class="text-white font-bold text-base truncate">
                                    <?php echo $data['rank']; ?> - <?php echo $data['name']; ?>
                                </span>
                                <span class="text-white font-bold text-base bg-white bg-opacity-20 px-2 py-1 rounded-full">
                                    <?php echo $data['points']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>

</html>