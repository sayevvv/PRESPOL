<?php
include_once 'src/config/Database.php';
$db = new Database();
$connection = $db->getConnection();

session_start();

$leaderboardData = [
    ['rank' => 1, 'name' => 'Dwi Ahmad Khairy', 'points' => 180],
    ['rank' => 2, 'name' => 'Abdullah Shamil Basayev', 'points' => 100],
    ['rank' => 3, 'name' => 'Rizki Rahmat', 'points' => 96],
    ['rank' => 4, 'name' => 'Adinda Lova', 'points' => 68],
    ['rank' => 5, 'name' => 'Amanda M.', 'points' => 45],
];
?>

<!DOCTYPE html>
<html class="scroll-smooth" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | PRESPOL</title>
    <link rel="icon" href="src/img/pres.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script src="src/script.js"></script>
    <style>
        body {
            overflow: hidden;
        }

        .page {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        /* Smooth tab transition styles */
        .tab-content {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            position: absolute;
            width: 100%;
        }

        .tab-content.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        .tab-content.hidden {
            display: none;
        }

        /* Ensure parent container is relatively positioned for absolute positioning */
        section[id="panduan"] .space-y-20 {
            position: relative;
        }
    </style>
</head>

<body class="font-helvetica text-stone-900 
            bg-cover bg-center bg-no-repeat bg-fixed
            max-h-[400px] overflow-y-auto
            [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-neutral-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-neutral-300"
    style="background-image: url('src/img/homepageGradient.png')">

    <div id="app" class="w-full h-full">
        <!-- Page 1 -->
        <div id="page1" class="page hidden">
            <!-- Navbar -->
            <nav
                x-data="{
                    isOpen: false, 
                    hasShadow: false,
                    prevScrollPos: window.pageYOffset,
                    visible: true
                }"
                x-init="window.addEventListener('scroll', () => {
                    const currentScrollPos = window.pageYOffset;
                    const scrollingDown = prevScrollPos < currentScrollPos;
                    const scrolledFarDown = currentScrollPos > 200;
                    
                    // Update shadow
                    hasShadow = currentScrollPos > 10;
                    
                    // Update visibility based on scroll direction
                    visible = scrolledFarDown ? !scrollingDown : true;
                    
                    prevScrollPos = currentScrollPos;
                })"
                :class="[
                    hasShadow ? 'shadow-lg bg-white' : 'shadow-none',
                    visible ? 'translate-y-0' : '-translate-y-full'
                ]"
                class="fixed w-screen left-0 top-0 z-50 px-6 lg:flex lg:justify-between lg:items-center transition-all duration-300 ease-in-out">
                <section class="container mx-auto flex items-center justify-between w-full px-5 py-6 sm:px-3 sm:py:5">
                    <a href="">
                        <img class="w-auto h-8 sm:h-10" src="src/img/logoBlack.svg" alt="logo">
                    </a>

                    <!-- Mobile menu button -->
                    <div class="flex lg:hidden">
                        <button x-cloak @click="isOpen = !isOpen" type="button" class="text-orange-500 text-orange-200 hover:text-orange-600 hover:text-orange-400 focus:outline-none focus:text-orange-600 focus:text-orange-400" aria-label="toggle menu">
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>

                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div x-cloak
                        :class="[isOpen ? 'translate-x-0 opacity-100 bg-gradient-to-r from-white to-orange-100' : 'opacity-0 -translate-x-full']"
                        class="rounded absolute inset-x-0 z-20 w-full mt-80 px-6 py-4 transition-all duration-300 ease-in-out shadow-md lg:shadow-none lg:mt-0 lg:p-0 lg:top-0 lg:bg-transparent lg:relative lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center lg:justify-center">
                        <div class="flex flex-col space-y-4 lg:mt-0 lg:flex-row lg:space-y-0 lg:items-center lg:justify-center">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-6">
                                <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#">
                                    Beranda</a>
                                <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#leaderb">
                                    Leaderboard</a>
                                <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#fitur">
                                    Fitur</a>
                                <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#tentangKami">
                                    Tentang Kami</a>
                                <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 font-semibold text-stone-500 hover:text-orange-400 hover:text-orange-500 cursor-pointer" href="src/login.php">
                                    Masuk</a>
                                <a class="block px-5 py-2 mt-4 text-sm text-center text-orange-700 capitalize transition-colors duration-300 transform border rounded-md hover:bg-orange-400 text-stone-600 font-semibold lg:mt-0 hover:bg-orange-100 lg:w-auto cursor-pointer whitespace-nowrap" href="src/signup.html">
                                    Sign Up</a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            </nav>

            <!-- Halaman Utama -->
            <section class="mt-36">
                <div class="container px-6 py-16 mx-auto text-center">
                    <!-- CTA -->
                    <div class="max-w-lg mx-auto">
                        <h1 class="text-6xl font-semibold text-slate-800 tracking-wider">Selamat Datang <b>Champions!</b></h1>

                        <h2 class="text-xl mt-6 text-stone-600">
                            Torehkan Prestasi, Wujudkan Eksistensi!
                        </h2>

                        <div class="flex justify-center space-x-4 mt-12">
                            <a href="src/signup.html">
                                <button class="text-white h-10 px-4 py-2 transition-colors duration-300 transform bg-orange-500 rounded-md hover:bg-orange-400 focus:outline-none focus:bg-orange-400">
                                    Gabung Kami!
                                </button>
                            </a>
                            <button onclick="transitionToPage(2)" class="text-white h-10 px-4 py-2 transition-colors duration-300 transform bg-orange-500 rounded-md hover:bg-orange-400 focus:outline-none focus:bg-orange-400">
                                Panduan
                            </button>
                        </div>
                    </div>
                    <!-- Tampilan Jurusan -->
                    <div class="max-w-screen-xl mx-auto mt-24 animate-fadeIn opacity-0 transition-opacity duration-4500">
                        <div class="max-w-lg mx-auto">
                            <p class="mt-6 text-stone-600">Dipercaya oleh:</p><br>
                        </div>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-8 lg:grid-cols-7">
                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://jti.polinema.ac.id/"><img src="src/img/jti.svg" alt="jti"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://tekkim.polinema.ac.id/"><img src="src/img/tekkim.svg" alt="tekkim"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://www.instagram.com/polinema.jtm/"><img src="src/img/MESIN.svg" alt="mesin"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://tekniksipilpolinema.id/"><img src="src/img/sipil.svg" alt="sipil"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://akuntansi.polinema.ac.id/"><img src="src/img/AK.svg" alt="akuntansi"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://www.instagram.com/anpolinema/?hl=en"><img src="src/img/AN.svg" alt="an"></a>
                            </div>

                            <div class="flex items-center justify-center col-span-1 md:col-span-2 lg:col-span-1">
                                <a href="https://jte.polinema.ac.id/"><img src="src/img/ELEKTRO.svg" alt="elektro"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Penjelasan PRESPOL  -->
            <section id="about" class="mt-12">
                <div class="container px-6 py-10 mx-auto text-center">
                    <div class="animate-fadeIn opacity-0 transition-opacity duration-4500">
                        <h1 class="text-6xl font-bold text-orange-800 tracking-widest">PRESPOL</h1>
                        <p class="mt-4 text-2xl text-orange-600 xl:mt-6">
                            <i>Platform Pencatatan Prestasi Mahasiswa POLINEMA</i>
                        </p>
                        <p class="max-w-3xl mx-auto text-center mt-4 text-l text-gray-500">Platform berbasis web yang dirancang untuk memudahkan proses pendaftaran, pendataan, pencatatan, verifikasi, dan pengelolaan data prestasi mahasiswa di lingkungan kampus Politeknik Negeri Malang.</p>
                    </div>

                    <!-- Leaderboard Section -->
                    <section id="leaderb" class="container px-6 py-10 mx-auto mt-36 text-center">
                        <div class="bg-none p-6 rounded-xl border-2 border-slate-800 mx-auto">
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
                        </div>
                    </section>

                    <div id="fitur" class="mt-36">
                        <div class="animate-fadeIn opacity-0 transition-opacity duration-4500">
                            <h1 class="text-4xl font-bold text-orange-800 tracking-wide">Fitur</h1>
                            <p class="text-2xl text-orange-700 font-semibold">
                                <span class="underline decoration-orange-500"><i>/prespol/</i></span>
                            </p>
                        </div>
                        <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 xl:gap-12 md:grid-cols-2 xl:grid-cols-3">
                            <div class="p-8 space-y-3 border-2 border-orange-400 rounded-xl animate-fadeIn opacity-0 transition-opacity duration-3500">
                                <span class="inline-block text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                                    </svg>
                                </span>

                                <h1 class="text-xl font-semibold text-gray-700 capitalize">Pencatatan Prestasi</h1>

                                <p class="text-gray-500">
                                    Fitur <b>Pencatatan Prestasi</b> memungkinkan mahasiswa untuk mengunggah data prestasi mereka melalui formulir yang terstruktur dan mudah diakses. Data yang diunggah akan tersimpan dalam sistem secara otomatis, sehingga mempermudah pengelolaan dan pencatatan.
                                </p>
                            </div>

                            <div class="p-8 space-y-3 border-2 border-orange-400 rounded-xl animate-fadeIn opacity-0 transition-opacity duration-3500">
                                <span class="inline-block text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                </span>

                                <h1 class="text-xl font-semibold text-gray-700 capitalize">Pengarsipan Prestasi Mahasiswa</h1>

                                <p class="text-gray-500">
                                    Fitur <b>Pengarsipan Prestasi</b> berfungsi untuk menyimpan seluruh data prestasi mahasiswa secara terorganisir, memastikan setiap informasi terdokumentasi dengan baik dan dapat diakses kapan saja.
                                </p>
                            </div>

                            <div class="p-8 space-y-3 border-2 border-orange-400 rounded-xl animate-fadeIn opacity-0 transition-opacity duration-3500">
                                <span class="inline-block text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                </span>

                                <h1 class="text-xl font-semibold text-gray-700 capitalize">Leaderboard/Peringkat Mahasiswa</h1>

                                <p class="text-gray-500">
                                    Sistem juga menyediakan <b>Tampilan Leaderboard</b>, yang menampilkan peringkat mahasiswa berdasarkan capaian prestasi mereka, memberikan motivasi tambahan bagi mahasiswa untuk terus berprestasi.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 xl:gap-12 md:grid-cols-2 xl:grid-cols-2">
                            <div class="p-8 space-y-3 border-2 border-orange-400 rounded-xl animate-fadeIn opacity-0 transition-opacity duration-3500">
                                <span class="inline-block text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                    </svg>
                                </span>
                                <h1 class="text-xl font-semibold text-gray-700 capitalize">Validasi dan Verifikasi Data Prestasi</h1>
                                <p class="text-gray-500">
                                    Agar data yang tercatat valid, <b>Fitur Validasi Data Prestasi</b> oleh Admin memastikan setiap data yang diunggah diverifikasi terlebih dahulu sebelum ditampilkan dalam sistem. Dengan ini, dapat memeriksa apakah ada kesalahan dalam data prestasi yang mahasiswa akan input.
                                </p>
                            </div>

                            <div class="p-8 space-y-3 border-2 border-orange-400 rounded-xl animate-fadeIn opacity-0 transition-opacity duration-3500">
                                <span class="inline-block text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                </span>
                                <h1 class="text-xl font-semibold text-gray-700 capitalize">Ekspor Data</h1>
                                <p class="text-gray-500">
                                    Sebagai penunjang pengelolaan data, sistem juga dilengkapi dengan <b>Fitur Ekspor Laporan dalam Bentuk Excel</b>, yang memungkinkan pengguna untuk mengunduh laporan data prestasi dalam format yang mudah dibaca dan dianalisis untuk kebutuhan administrasi maupun pelaporan. Dengan fitur-fitur ini, sistem mendukung transparansi, akurasi, dan efisiensi dalam pengelolaan data prestasi mahasiswa.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tentang Kami  -->
            <section id="tentangKami" class="mt-12">
                <div class="h-[32rem]">
                    <div class="container px-6 py-10 mx-auto animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                        <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">Tentang Kami</h1>

                        <div class="flex justify-center mx-auto mt-6">
                            <span class="inline-block w-40 h-1 bg-orange-500 rounded-full"></span>
                            <span class="inline-block w-3 h-1 mx-1 bg-orange-500 rounded-full"></span>
                            <span class="inline-block w-1 h-1 bg-orange-500 rounded-full"></span>
                        </div>

                        <p class="max-w-2xl mx-auto mt-6 text-center text-gray-500">
                            Proyek PRESPOL dikerjakan dengan kontribusi dari anggota Kelompok 3 PBL dari Kelas TI-2D Program Studi D-IV Teknik Informatika Jurusan Teknologi Informasi Politeknik Negeri Malang.
                        </p>
                    </div>
                </div>

                <div class="container px-6 py-10 mx-auto -mt-72 sm:-mt-80 md:-mt-96 ">
                    <div class="grid xl:grid-cols-5 md:grid-cols-2 gap-8 mt-8 xl:mt-16 animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                        <div class="flex flex-col items-center text-center p-4 border border-orange-400 sm:p-6 rounded-xl bg-white">
                            <img class="object-cover w-full rounded-xl aspect-square" src="src/img/shamel.jpg" alt="shameel">

                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize ">Abdullah Shamil Basayev</h1>

                            <p class="mt-2 text-gray-500 capitalize ">UI/UX Designer & Frontend Developer</p>

                            <div class="flex mt-6 -mx-2">
                                <a href="https://www.linkedin.com/in/shamilcoy" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.732-.766-1.732-1.732s.766-1.732 1.732-1.732 1.732.766 1.732 1.732-.766 1.732-1.732 1.732zm13.5 11.268h-3v-5.397c0-1.285-.025-2.933-1.789-2.933-1.789 0-2.064 1.4-2.064 2.843v5.487h-3v-10h2.881v1.367h.041c.402-.761 1.386-1.561 2.852-1.561 3.051 0 3.615 2.008 3.615 4.621v5.573z" />
                                    </svg>
                                </a>

                                <a href="https://instagram.com/abdul.sayev" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 30 30" fill="currentColor">
                                        <path d="M 11.46875 5 C 7.917969 5 5 7.914063 5 11.46875 L 5 20.53125 C 5 24.082031 7.914063 27 11.46875 27 L 20.53125 27 C 24.082031 27 27 24.085938 27 20.53125 L 27 11.46875 C 27 7.917969 24.085938 5 20.53125 5 Z M 11.46875 7 L 20.53125 7 C 23.003906 7 25 8.996094 25 11.46875 L 25 20.53125 C 25 23.003906 23.003906 25 20.53125 25 L 11.46875 25 C 8.996094 25 7 23.003906 7 20.53125 L 7 11.46875 C 7 8.996094 8.996094 7 11.46875 7 Z M 21.90625 9.1875 C 21.402344 9.1875 21 9.589844 21 10.09375 C 21 10.597656 21.402344 11 21.90625 11 C 22.410156 11 22.8125 10.597656 22.8125 10.09375 C 22.8125 9.589844 22.410156 9.1875 21.90625 9.1875 Z M 16 10 C 12.699219 10 10 12.699219 10 16 C 10 19.300781 12.699219 22 16 22 C 19.300781 22 22 19.300781 22 16 C 22 12.699219 19.300781 10 16 10 Z M 16 12 C 18.222656 12 20 13.777344 20 16 C 20 18.222656 18.222656 20 16 20 C 13.777344 20 12 18.222656 12 16 C 12 13.777344 13.777344 12 16 12 Z" />
                                    </svg>
                                </a>

                                <a href="https://github.com/sayevvv" class="mx-2 text-gray-600 transition-colors duration-300  hover:text-orange-500 " aria-label="Github">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col items-center text-center p-4 border border-orange-400 sm:p-6 rounded-xl bg-white">
                            <img class="object-cover w-full rounded-xl aspect-square" src="src/img/dwik.jpg" alt="dwi">

                            <h1 class="mt-8 text-2xl font-semibold text-gray-700 capitalize ">Dwi Ahmad Khairy</h1>

                            <p class="mt-6 text-gray-500 capitalize ">Project Manager & Frontend Developer</p>

                            <div class="flex mt-6 -mx-2">
                                <a href="https://www.linkedin.com/in/dwikh" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.732-.766-1.732-1.732s.766-1.732 1.732-1.732 1.732.766 1.732 1.732-.766 1.732-1.732 1.732zm13.5 11.268h-3v-5.397c0-1.285-.025-2.933-1.789-2.933-1.789 0-2.064 1.4-2.064 2.843v5.487h-3v-10h2.881v1.367h.041c.402-.761 1.386-1.561 2.852-1.561 3.051 0 3.615 2.008 3.615 4.621v5.573z" />
                                    </svg>
                                </a>

                                <a href="https://www.instagram.com/dwi.khh/" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 30 30" fill="currentColor">
                                        <path d="M 11.46875 5 C 7.917969 5 5 7.914063 5 11.46875 L 5 20.53125 C 5 24.082031 7.914063 27 11.46875 27 L 20.53125 27 C 24.082031 27 27 24.085938 27 20.53125 L 27 11.46875 C 27 7.917969 24.085938 5 20.53125 5 Z M 11.46875 7 L 20.53125 7 C 23.003906 7 25 8.996094 25 11.46875 L 25 20.53125 C 25 23.003906 23.003906 25 20.53125 25 L 11.46875 25 C 8.996094 25 7 23.003906 7 20.53125 L 7 11.46875 C 7 8.996094 8.996094 7 11.46875 7 Z M 21.90625 9.1875 C 21.402344 9.1875 21 9.589844 21 10.09375 C 21 10.597656 21.402344 11 21.90625 11 C 22.410156 11 22.8125 10.597656 22.8125 10.09375 C 22.8125 9.589844 22.410156 9.1875 21.90625 9.1875 Z M 16 10 C 12.699219 10 10 12.699219 10 16 C 10 19.300781 12.699219 22 16 22 C 19.300781 22 22 19.300781 22 16 C 22 12.699219 19.300781 10 16 10 Z M 16 12 C 18.222656 12 20 13.777344 20 16 C 20 18.222656 18.222656 20 16 20 C 13.777344 20 12 18.222656 12 16 C 12 13.777344 13.777344 12 16 12 Z" />
                                    </svg>
                                </a>

                                <a href="https://github.com/Archin0" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500 " aria-label="Github">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col items-center text-center p-4 border border-orange-400 sm:p-6 rounded-xl bg-white">
                            <img class="object-cover w-full rounded-xl aspect-square" src="src/img/rifda.jpg" alt="">

                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize ">Muhammad Rifda Musyaffa'</h1>

                            <p class="mt-2 text-gray-500 capitalize text-center">Database Designer-Administrator & Fullstack Developer</p>

                            <div class="flex mt-6 -mx-2">
                                <a href="https://www.linkedin.com/in/muhammad-rifda-musyaffa-21ab712a2" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.732-.766-1.732-1.732s.766-1.732 1.732-1.732 1.732.766 1.732 1.732-.766 1.732-1.732 1.732zm13.5 11.268h-3v-5.397c0-1.285-.025-2.933-1.789-2.933-1.789 0-2.064 1.4-2.064 2.843v5.487h-3v-10h2.881v1.367h.041c.402-.761 1.386-1.561 2.852-1.561 3.051 0 3.615 2.008 3.615 4.621v5.573z" />
                                    </svg>
                                </a>

                                <a href="https://www.instagram.com/muhammad.rifda.m" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 30 30" fill="currentColor">
                                        <path d="M 11.46875 5 C 7.917969 5 5 7.914063 5 11.46875 L 5 20.53125 C 5 24.082031 7.914063 27 11.46875 27 L 20.53125 27 C 24.082031 27 27 24.085938 27 20.53125 L 27 11.46875 C 27 7.917969 24.085938 5 20.53125 5 Z M 11.46875 7 L 20.53125 7 C 23.003906 7 25 8.996094 25 11.46875 L 25 20.53125 C 25 23.003906 23.003906 25 20.53125 25 L 11.46875 25 C 8.996094 25 7 23.003906 7 20.53125 L 7 11.46875 C 7 8.996094 8.996094 7 11.46875 7 Z M 21.90625 9.1875 C 21.402344 9.1875 21 9.589844 21 10.09375 C 21 10.597656 21.402344 11 21.90625 11 C 22.410156 11 22.8125 10.597656 22.8125 10.09375 C 22.8125 9.589844 22.410156 9.1875 21.90625 9.1875 Z M 16 10 C 12.699219 10 10 12.699219 10 16 C 10 19.300781 12.699219 22 16 22 C 19.300781 22 22 19.300781 22 16 C 22 12.699219 19.300781 10 16 10 Z M 16 12 C 18.222656 12 20 13.777344 20 16 C 20 18.222656 18.222656 20 16 20 C 13.777344 20 12 18.222656 12 16 C 12 13.777344 13.777344 12 16 12 Z" />
                                    </svg>
                                </a>

                                <a href="https://github.com/MRifdaM" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Github">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col items-center text-center p-4 border border-orange-400 sm:p-6 rounded-xl bg-white">
                            <img class="object-cover w-full rounded-xl aspect-square" src="src/img/bella.jpg" alt="bella">

                            <h1 class="mt-8 text-2xl font-semibold text-gray-700 capitalize ">Rizkya Salsabila</h1>

                            <p class="mt-6 text-gray-500 capitalize ">Database Administrator & Backend Developer</p>

                            <div class="flex mt-6 -mx-2">
                                <a href="https://www.linkedin.com/in/rizkya-salsabila-279b3b28b" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.732-.766-1.732-1.732s.766-1.732 1.732-1.732 1.732.766 1.732 1.732-.766 1.732-1.732 1.732zm13.5 11.268h-3v-5.397c0-1.285-.025-2.933-1.789-2.933-1.789 0-2.064 1.4-2.064 2.843v5.487h-3v-10h2.881v1.367h.041c.402-.761 1.386-1.561 2.852-1.561 3.051 0 3.615 2.008 3.615 4.621v5.573z" />
                                    </svg>
                                </a>

                                <a href="https://instagram.com/rzky.salsabila" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 30 30" fill="currentColor">
                                        <path d="M 11.46875 5 C 7.917969 5 5 7.914063 5 11.46875 L 5 20.53125 C 5 24.082031 7.914063 27 11.46875 27 L 20.53125 27 C 24.082031 27 27 24.085938 27 20.53125 L 27 11.46875 C 27 7.917969 24.085938 5 20.53125 5 Z M 11.46875 7 L 20.53125 7 C 23.003906 7 25 8.996094 25 11.46875 L 25 20.53125 C 25 23.003906 23.003906 25 20.53125 25 L 11.46875 25 C 8.996094 25 7 23.003906 7 20.53125 L 7 11.46875 C 7 8.996094 8.996094 7 11.46875 7 Z M 21.90625 9.1875 C 21.402344 9.1875 21 9.589844 21 10.09375 C 21 10.597656 21.402344 11 21.90625 11 C 22.410156 11 22.8125 10.597656 22.8125 10.09375 C 22.8125 9.589844 22.410156 9.1875 21.90625 9.1875 Z M 16 10 C 12.699219 10 10 12.699219 10 16 C 10 19.300781 12.699219 22 16 22 C 19.300781 22 22 19.300781 22 16 C 22 12.699219 19.300781 10 16 10 Z M 16 12 C 18.222656 12 20 13.777344 20 16 C 20 18.222656 18.222656 20 16 20 C 13.777344 20 12 18.222656 12 16 C 12 13.777344 13.777344 12 16 12 Z" />
                                    </svg>
                                </a>

                                <a href="https://github.com/RizkyaSalsabila" class="mx-2 text-gray-600 transition-colors duration-300  hover:text-orange-500 " aria-label="Github">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col items-center text-center p-4 border border-orange-400 sm:p-6 rounded-xl bg-white">
                            <img class="object-cover w-full rounded-xl aspect-square" src="src/img/yan.jpg" alt="yan">

                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize ">Yan Daffa Putra Liandhie</h1>

                            <p class="mt-2 text-gray-500 capitalize ">Database Administrator & Backend Developer</p>

                            <div class="flex mt-6 -mx-2">
                                <a href="https://www.linkedin.com/in/yan-daffa-putra-liandhie-7723aa294/" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.732-.766-1.732-1.732s.766-1.732 1.732-1.732 1.732.766 1.732 1.732-.766 1.732-1.732 1.732zm13.5 11.268h-3v-5.397c0-1.285-.025-2.933-1.789-2.933-1.789 0-2.064 1.4-2.064 2.843v5.487h-3v-10h2.881v1.367h.041c.402-.761 1.386-1.561 2.852-1.561 3.051 0 3.615 2.008 3.615 4.621v5.573z" />
                                    </svg>
                                </a>

                                <a href="https://www.instagram.com/yan_daffa_/profilecard/?igsh=eTN0Y2xxM3MzcjM5" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500" aria-label="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 30 30" fill="currentColor">
                                        <path d="M 11.46875 5 C 7.917969 5 5 7.914063 5 11.46875 L 5 20.53125 C 5 24.082031 7.914063 27 11.46875 27 L 20.53125 27 C 24.082031 27 27 24.085938 27 20.53125 L 27 11.46875 C 27 7.917969 24.085938 5 20.53125 5 Z M 11.46875 7 L 20.53125 7 C 23.003906 7 25 8.996094 25 11.46875 L 25 20.53125 C 25 23.003906 23.003906 25 20.53125 25 L 11.46875 25 C 8.996094 25 7 23.003906 7 20.53125 L 7 11.46875 C 7 8.996094 8.996094 7 11.46875 7 Z M 21.90625 9.1875 C 21.402344 9.1875 21 9.589844 21 10.09375 C 21 10.597656 21.402344 11 21.90625 11 C 22.410156 11 22.8125 10.597656 22.8125 10.09375 C 22.8125 9.589844 22.410156 9.1875 21.90625 9.1875 Z M 16 10 C 12.699219 10 10 12.699219 10 16 C 10 19.300781 12.699219 22 16 22 C 19.300781 22 22 19.300781 22 16 C 22 12.699219 19.300781 10 16 10 Z M 16 12 C 18.222656 12 20 13.777344 20 16 C 20 18.222656 18.222656 20 16 20 C 13.777344 20 12 18.222656 12 16 C 12 13.777344 13.777344 12 16 12 Z" />
                                    </svg>
                                </a>

                                <a href="https://github.com/YanDaffaPutraLiandhie" class="mx-2 text-gray-600 transition-colors duration-300 hover:text-orange-500 " aria-label="Github">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Advertised -->
            <section class="mt-20">
                <div class="container px-6 py-10 mx-auto text-center animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                    <div>
                        <h1 class="text-6xl font-bold text-orange-800 tracking-normal">Mulai Sekarang!</h1>
                        <p class="mt-4 text-2xl text-orange-600 xl:mt-6">
                            Catatkan Prestasimu di PRESPOL.
                        </p>
                    </div>
                    <div class="flex justify-center space-x-4 mt-4">
                        <a href="src/signup.html">
                            <button class="cursor-pointer inline-block text-white transition-all duration-300 tracking-normal h-10 px-4 py-2 transition-colors duration-300 transform bg-orange-500 rounded-md hover:bg-orange-400 hover:h-15 hover:tracking-widest focus:outline-none focus:bg-orange-400">
                                Gabung!
                            </button>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="mt-8 bg-red-900 text-white">
                <div class="container px-6 py-8 mx-auto">
                    <div class="flex flex-col items-center text-center animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                        <a href="#">
                            <img class="w-auto h-10" src="src/img/logoWhitePrespol.svg" alt="">
                        </a>

                        <div class="flex flex-wrap justify-center mt-6 -mx-4">
                            <a href="#" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Home </a>

                            <a href="#about" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> About </a>

                            <a href="#tentangKami" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Teams </a>

                            <a onclick="transitionToPage(2)" href="#panduan" class="cursor-pointer mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Guide </a>

                            <a href="https://www.polinema.ac.id/" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Polinema </a>
                        </div>

                    </div>

                    <hr class="my-6 border-gray-200 md:my-10 animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500" />

                    <div class="flex flex-col items-center sm:flex-row sm:justify-between animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                        <p class="text-sm">© Prespol 2024. All Rights Reserved.</p>

                        <a href="https://github.com/Archin0/PRESPOL" class="mx-2 transition-colors duration-300 hover:text-orange-500" aria-label="Github">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
        </div>
        </footer>
    </div>

        <!-- Page 2 -->
        <div id="page2" class="page">
            <!-- Navbar -->
            <nav 
                x-data="{
                    isOpen: false, 
                    hasShadow: false,
                    prevScrollPos: window.pageYOffset,
                    visible: true
                }"
            x-init="window.addEventListener('scroll', () => {
                    const currentScrollPos = window.pageYOffset;
                    const scrollingDown = prevScrollPos < currentScrollPos;
                    const scrolledFarDown = currentScrollPos > 200;
                    
                    // Update shadow
                    hasShadow = currentScrollPos > 10;
                    
                    // Update visibility based on scroll direction
                    visible = scrolledFarDown ? !scrollingDown : true;
                    
                    prevScrollPos = currentScrollPos;
                })"
            :class="[
                    hasShadow ? 'shadow-lg bg-white' : 'shadow-none',
                    visible ? 'translate-y-0' : '-translate-y-full'
                ]"
            class="fixed w-screen left-0 top-0 z-50 px-6 lg:flex lg:justify-between lg:items-center transition-all duration-300 ease-in-out">
            <section class="container mx-auto flex items-center justify-between w-full px-5 py-6 sm:px-3 sm:py:5">
                <a onclick="navigateToPage('indexLead.php')">
                    <img class="w-auto h-8 sm:h-10" src="src/img/logoBlack.svg" alt="logo">
                </a>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button x-cloak @click="isOpen = !isOpen" type="button" class="text-orange-500 text-orange-200 hover:text-orange-600 hover:text-orange-400 focus:outline-none focus:text-orange-600 focus:text-orange-400" aria-label="toggle menu">
                        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div x-cloak
                    :class="[isOpen ? 'translate-x-0 opacity-100 bg-gradient-to-r from-white to-orange-100' : 'opacity-0 -translate-x-full']"
                    class="rounded absolute inset-x-0 z-20 w-full mt-72 px-6 py-4 transition-all duration-300 ease-in-out shadow-md lg:shadow-none lg:mt-0 lg:p-0 lg:top-0 lg:bg-transparent lg:relative lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center lg:justify-center">
                    <div class="flex flex-col space-y-4 lg:mt-0 lg:flex-row lg:space-y-0 lg:items-center lg:justify-center">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-6">
                            <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#">
                                Beranda</a>
                            <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#tentang">
                                Tentang</a>
                            <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 text-stone-500 hover:text-orange-400 hover:text-orange-500" href="#panduan">
                                Panduan</a>
                            <a class="inline-block px-4 py-2 text-center whitespace-nowrap tracking-normal transition-all duration-300 hover:tracking-wide text-orange-700 font-semibold text-stone-500 hover:text-orange-400 hover:text-orange-500 cursor-pointer" href="src/login.php">
                                Masuk</a>
                            <a class="block px-5 py-2 mt-4 text-sm text-center text-orange-700 capitalize transition-colors duration-300 transform border rounded-md hover:bg-orange-400 text-stone-600 font-semibold lg:mt-0 hover:bg-orange-100 lg:w-auto cursor-pointer whitespace-nowrap" href="src/signup.html">
                                Sign Up</a>
                        </div>
                    </div>
                </div>
            </section>
        </nav>

        <!-- Halaman Utama -->
        <section class="mt-60">
            <div class="container px-6 py-16 mx-auto text-center">
                <!-- CTA -->
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-6xl font-semibold text-slate-800 tracking-wider">Panduan Untukmu, <b>Champions!</b></h1>

                    <h2 class="text-xl mt-6 text-stone-600">
                        Torehkan Prestasi, Wujudkan Eksistensi!
                    </h2>

                    <div class="flex justify-center space-x-4 mt-12">
                        <button onclick="transitionToPage(1)" class="text-white h-10 px-4 py-2 transition-colors duration-300 transform bg-orange-500 rounded-md hover:bg-orange-400 focus:outline-none focus:bg-orange-400">
                            Kembali ke Landing Page
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Penjelasan PRESPOL  -->
        <section id="tentang" class="mt-48">
            <div class="container px-6 py-10 mx-auto text-center">
                <div class="animate-fadeIn opacity-0 transition-opacity duration-4500">
                    <h1 class="text-6xl font-bold text-orange-800 tracking-widest">PRESPOL</h1>
                    <p class="mt-4 text-2xl text-orange-600 xl:mt-6">
                        <i>Platform Pencatatan Prestasi Mahasiswa POLINEMA</i>
                    </p>
                    <p class="max-w-3xl mx-auto text-center mt-4 text-l text-gray-500">Platform berbasis web yang dirancang untuk memudahkan proses pendaftaran, pendataan, pencatatan, verifikasi, dan pengelolaan data prestasi mahasiswa di lingkungan kampus Politeknik Negeri Malang.</p>
                </div>
            </div>
        </section>

        <!-- Panduan Halaman -->
        <section id="panduan" class="mt-36">
            <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">Panduan</h1>
            <div class="flex justify-center mx-auto mt-6">
                <span class="inline-block w-24 h-1 bg-orange-500 rounded-full"></span>
                <span class="inline-block w-3 h-1 mx-1 bg-orange-500 rounded-full"></span>
                <span class="inline-block w-1 h-1 bg-orange-500 rounded-full"></span>
            </div>

            <!-- Tab Switch -->
            <div x-data="{ selectedTab: 'homepage' }" class="w-screen py-4 mt-4 overflow-x-auto overflow-y-hidden space-y-16 justify-center">
                <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()" class="flex gap-2 overflow-x-auto border-b border-neutral-300 justify-center" role="tablist" aria-label="tab options">
                    <button @click="selectedTab = 'homepage'" :aria-selected="selectedTab === 'homepage'" :tabindex="selectedTab === 'homepage' ? '0' : '-1'" :class="selectedTab === 'homepage' ? 'font-semibold text-orange-700 border-b-2 border-orange-500' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="h-min px-4 py-2 text-md" type="button" role="tab" aria-controls="tabpanelHomepage" >Homepage</button>
                    <button @click="selectedTab = 'mahasiswa'" :aria-selected="selectedTab === 'mahasiswa'" :tabindex="selectedTab === 'mahasiswa' ? '0' : '-1'" :class="selectedTab === 'mahasiswa' ? 'font-semibold text-orange-700 border-b-2 border-orange-500' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="h-min px-4 py-2 text-md" type="button" role="tab" aria-controls="tabpanelMahasiswa" >Mahasiswa</button>
                    <button @click="selectedTab = 'admin'" :aria-selected="selectedTab === 'admin'" :tabindex="selectedTab === 'admin' ? '0' : '-1'" :class="selectedTab === 'admin' ? 'font-semibold text-orange-700 border-b-2 border-orange-500' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="h-min px-4 py-2 text-md" type="button" role="tab" aria-controls="tabpanelAdmin" >Admin</button>
                    <button @click="selectedTab = 'kajur'" :aria-selected="selectedTab === 'kajur'" :tabindex="selectedTab === 'kajur' ? '0' : '-1'" :class="selectedTab === 'kajur' ? 'font-semibold text-orange-700 border-b-2 border-orange-500' : 'text-neutral-600 font-medium    hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="h-min px-4 py-2 text-md" type="button" role="tab" aria-controls="tabpanelKajur" >Ketua Jurusan</button>
                </div>

                <!-- homepage -->
                <div x-show="selectedTab === 'homepage'" class="space-y-20" id="tabpanelHomepage" role="tabpanel" aria-label="homepage">
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Homepage</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman Homepage adalah halaman utama dari PRESPOL yang akan menampilkan informasi umum tentang platform ini, tujuan penggunaannya, serta fitur-fitur utama yang tersedia. Di sini, pengguna dapat melihat gambaran singkat tentang sistem pencatatan prestasi. Halaman ini juga akan menyertakan tombol untuk masuk (login) atau mendaftar (signup) ke dalam platform bagi pengguna yang baru.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Panduan</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman ini berisi petunjuk lengkap untuk menggunakan platform PRESPOL. Termasuk penjelasan tentang fitur-fitur untuk setiap jenis pengguna (Mahasiswa, Admin, dan Ketua Jurusan).</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                </div>

                <!-- mahasiswa -->
                <div x-show="selectedTab === 'mahasiswa'" class="space-y-20" id="tabpanelMahasiswa" role="tabpanel" aria-label="mahasiswa">
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Masuk / Log in</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk mahasiswa masuk ke dalam sistem menggunakan akun yang telah terdaftar.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Daftar / Sign up</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur pendaftaran bagi mahasiswa baru yang belum memiliki akun. Mahasiswa perlu meng-input-kan data seperti username, kata sandi, nama, NIM, jurusan, program studi, dan juga foto profil untuk membuat akun.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Beranda</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman setelah login berhasil yang menampilkan ucapan selamat datang dan leaderboard terkini. Leaderboard memperlihatkan peringkat mahasiswa berdasarkan jumlah poin prestasi.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Profil</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman untuk melihat dan mengedit informasi pribadi mahasiswa, seperti nama, email, foto profil, dan total poin prestasi.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Tambah Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Formulir untuk menambahkan data prestasi yang telah diraih, seperti lomba atau penghargaan. Mahasiswa dapat meng-input-kan data perlombaan dan mengunggah bukti prestasi seperti sertifikat, foto kompetisi, dan lain lain dalam format dokumen atau gambar.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Pengajuan</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Menampilkan status dari prestasi yang diajukan sebelumnya. Status prestasi bisa berupa:
                                <ul class="list-disc pl-6">
                                    <li>Pending: Sedang menunggu validasi oleh admin.</li>
                                    <li>Ditolak: Prestasi tidak disetujui dengan alasan yang tercantum.</li>
                                    <li>Valid: Prestasi telah disetujui dan ditampilkan dalam list prestasi juga dihitung dalam leaderboard.</li>
                                </ul>
                            </h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>List Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman yang menampilkan daftar seluruh prestasi mahasiswa yang telah terdaftar dalam sistem. Dilengkapi dengan fitur search, sort, dan filter untuk mempermudah pencarian berdasarkan kriteria seperti kategori prestasi, tanggal, atau status.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Keluar / Log out</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk keluar dari sistem dan mengakhiri sesi login dengan aman.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    
                </div>

                <!-- admin -->
                <div x-show="selectedTab === 'admin'" class="space-y-20" id="tabpanelAdmin" role="tabpanel" aria-label="admin">
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Masuk / Log in</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk admin masuk ke dalam sistem menggunakan akun yang telah disediakan.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Beranda</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman setelah login berhasil yang menampilkan ucapan selamat datang dan leaderboard terkini. Leaderboard memperlihatkan peringkat mahasiswa berdasarkan jumlah poin prestasi.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Tambah Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk admin menambahkan data prestasi secara manual, misalnya jika terdapat prestasi yang belum diajukan oleh mahasiswa tetapi sudah diketahui.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>List Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman daftar seluruh prestasi mahasiswa yang dapat dikelola oleh admin. Dilengkapi dengan fitur search, sort, dan filter untuk mempermudah pencarian dan pengelolaan data.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Profil</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman untuk melihat dan memperbarui informasi akun admin.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Validasi Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman untuk memproses prestasi yang diajukan oleh mahasiswa. Admin dapat memvalidasi atau menolak pengajuan dengan memberikan keterangan alasan.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Keluar / Log out</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk keluar dari sistem dan mengakhiri sesi login dengan aman.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                </div>

                <!-- kajur -->
                <div x-show="selectedTab === 'kajur'" class="space-y-20" id="tabpanelKajur" role="tabpanel" aria-label="kajur">
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Masuk / Log in</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk ketua jurusan masuk ke dalam sistem menggunakan akun yang telah disediakan.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Beranda</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman setelah login berhasil yang menampilkan ucapan selamat datang dan leaderboard terkini. Leaderboard memperlihatkan peringkat mahasiswa berdasarkan jumlah poin prestasi.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Profil</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman untuk melihat dan memperbarui informasi akun ketua jurusan.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>List Prestasi</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman daftar seluruh prestasi mahasiswa yang dapat dilihat oleh ketua jurusan. Dilengkapi dengan fitur search, sort, dan filter untuk mempermudah pencarian dan analisis data.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Ekspor Data</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Halaman untuk mengunduh laporan data prestasi mahasiswa dalam format Excel. Data ini mencakup seluruh informasi dari tabel prestasi mahasiswa sesuai dengan jurusan yang dipilih.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                    <section class="lg:flex lg:items-center">
                        <div class="lg:w-1/2 pl-10 pr-10">
                            <p class="text-lg tracking-wider text-orange-500 uppercase"><b>Keluar / Log out</b></p>
                            <h2 class="mt-2 text-md text-gray-600 text-justify">
                            Fitur untuk keluar dari sistem dan mengakhiri sesi login dengan aman.</h2>
                        </div>
                        <div class="mt-4 lg:w-1/2 lg:mt-0 mr-16 drop-shadow-md hover:drop-shadow-xl">
                            <img class="object-cover w-full h-64 rounded-lg md:h-96"
                                src="src/img/homepage.png"
                                alt="">
                        </div>
                    </section>
                </div>
            </div>

            <div class="flex justify-center mx-auto mt-16">
                        <span class="inline-block w-96 h-1 bg-orange-500 rounded-full"></span>
                        <span class="inline-block w-9 h-1 mx-1 bg-orange-500 rounded-full"></span>
                        <span class="inline-block w-1 h-1 bg-orange-500 rounded-full"></span>
                    </div>
        </section>

        <!-- Advertised -->
        <section class="mt-24 mb-36">
            <div class="container px-6 py-10 mx-auto text-center animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                <div>
                    <h1 class="text-6xl font-bold text-orange-800 tracking-normal">Mulai Sekarang!</h1>
                    <p class="mt-4 text-2xl text-orange-600 xl:mt-6">
                        Catatkan Prestasimu di PRESPOL.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button href="src/signup.html" class="cursor-pointer inline-block text-white transition-all duration-300 tracking-normal h-10 px-4 py-2 transition-colors duration-300 transform bg-orange-500 rounded-md hover:bg-orange-400 hover:h-15 hover:tracking-widest focus:outline-none focus:bg-orange-400">
                        Gabung!
                    </button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-8 bg-red-900 text-white">
            <div class="container px-6 py-8 mx-auto">
                <div class="flex flex-col items-center text-center animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                    <a href="#">
                        <img class="w-auto h-10" src="src/img/logoWhitePrespol.svg" alt="">
                    </a>

                    <div class="flex flex-wrap justify-center mt-6 -mx-4">
                        <a onclick="transitionToPage(1)" class="cursor-pointer mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Home </a>

                        <a href="#tentang" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> About </a>

                        <a onclick="transitionToPage(1)" href="#tentangKami" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Teams </a>

                        <a href="#panduan" class="cursor-pointer mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Guide </a>

                        <a href="https://www.polinema.ac.id/" class="mx-4 text-sm transition-colors duration-300 hover:text-orange-500"> Polinema </a>
                    </div>

                </div>

                <hr class="my-6 border-gray-200 md:my-10 animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500" />
                    <div class="flex flex-col items-center sm:flex-row sm:justify-between animate-fadeIn opacity-0 ease-in-out transition-opacity duration-4500">
                    <p class="text-sm">© Prespol 2024. All Rights Reserved.</p>

                    <a href="https://github.com/Archin0/PRESPOL" class="mx-2 transition-colors duration-300 hover:text-orange-500" aria-label="Github">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
    </div>
    </footer>
    </div>
    </div>
</body>

</html>