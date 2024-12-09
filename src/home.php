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

if ($role == '1') {
    include_once 'classes/Admin.php';
    $user = new Admin();
} else if ($role == '2') {
    include_once 'classes/Kajur.php';
    $user = new Kajur();
} else if ($role == '3') {
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
            min-height: 100vh;
            /* Ensures the background spans the full viewport height */
            margin: 0;
            /* Removes any default body margin */
        }

        @media (max-width: 768px) {

            /* Adjusts for mobile screens */
            body {
                background-attachment: scroll;
                /* Prevents potential issues with 'fixed' on mobile */
            }
        }
    </style>
</head>

<body class="min-h-screen  flex flex-col md:flex-row">
    <!-- Sidebar (from previous implementation) -->
    <div class="flex-1">
        <?php echo $user->sidebar(); ?>
    </div>

    <!-- Main Content Area -->
    <main class="flex-2 lg:overflow-y-auto md:w-[calc(100%-5rem)] lg:w-[calc(100%-16rem)] p-4 md:p-6 pt-8 bg-white/60 md:bg-transparent">
        <div class="container mx-auto max-w-full space-y-6">
            <!-- Top Navigation Section -->
            <div>
                <?php $user->mainContent($no_induk); ?>
            </div>
            <!-- Leaderboard Section -->
            <section id="leaderb" class="">
                <div class="bg-white/60 md:bg-opacity-80 p-4 md:p-6 rounded-xl border-2 mb-24 lg:mb-0">
                    <h3 class="text-base font-bold md:text-xl mb-6 md:mb-8">Peringkat Prestasi</h3>
                    <div class="space-y-3">
                        <?php
                        if (!empty($leaderboardData)) {
                            // Find the maximum points in the leaderboard for normalization
                            $maxPoints = max(array_column($leaderboardData, 'total_poin'));

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
                                $widthPercentage = ($data['total_poin'] / $maxPoints) * 100;

                                // Select background color based on rank (use last color for ranks beyond the gradient)
                                $bgColor = $orangeGradient[$index] ?? end($orangeGradient);
                        ?>
                                <div class="flex flex-col space-y-1">
                                    <div class="block md:hidden flex flex-col items-start space-y-1 mb-1">
                                        <span class="text-sm font-semibold block">
                                            <?php echo $data['peringkat']; ?> - <?php echo $data['nama']; ?>
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-10 md:h-12 relative">
                                        <div class="<?php echo $bgColor; ?> h-10 md:h-12 rounded-full flex items-center justify-between px-2 md:px-4 relative" style="width: <?php echo $widthPercentage; ?>%;">
                                            <span class="hidden md:block text-white font-bold text-xs md:text-base truncate">
                                                <?php echo $data['peringkat']; ?> - <?php echo $data['nama']; ?>
                                            </span>
                                            <span class="text-sm md:text-base text-white font-bold bg-white/10 bg-opacity-20 px-2 py-1 rounded-full whitespace-nowrap">
                                                <?php echo $data['total_poin']; ?> &#9734;
                                            </span>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        } else {
                            echo '<p class="text-gray-600">Data leaderboard tidak tersedia.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>


        </div>
    </main>
</body>

</html>