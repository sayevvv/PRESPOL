<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'config/Database.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $jurusan_id = $_POST['jurusan'];
    $prodi_id = $_POST['prodi'];
    $role_id = '3';

    $foto_profile_tmp = $_FILES['dropzone-file']['tmp_name'];
    $foto_profile_ext = pathinfo($_FILES['dropzone-file']['name'], PATHINFO_EXTENSION);

    // Validasi file foto
    $uploadDir = 'upload/profile/mahasiswa/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Fungsi untuk mendapatkan increment saat ini dari file
    function getCurrentProfileIncrement() {
        $file = 'profile_increment_counter.txt';
        if (!file_exists($file)) {
            file_put_contents($file, 1);
        }
        return (int) file_get_contents($file);
    }

    // Fungsi untuk memperbarui increment
    function updateProfileIncrement($newIncrement) {
        $file = 'profile_increment_counter.txt';
        file_put_contents($file, $newIncrement);
    }

    // Generate nama file unik dengan increment
    $increment = getCurrentProfileIncrement();
    $sanitizedNama = preg_replace('/[^a-zA-Z0-9]/', '_', $nama);
    $newFileName = $nim . "_" . $sanitizedNama . "_" . $increment . "." . $foto_profile_ext;
    $uploadFile = $uploadDir . $newFileName;

    if (move_uploaded_file($foto_profile_tmp, $uploadFile)) {
        try {
            // Mulai transaksi
            sqlsrv_begin_transaction($conn);

            // Simpan data mahasiswa
            $insertMahasiswaQuery = "INSERT INTO mahasiswa (nim, nama, foto_profile, id_jurusan, id_prodi)
                                     OUTPUT INSERTED.id_mahasiswa 
                                     VALUES (?, ?, ?, ?, ?)";
            $paramsMahasiswa = [$nim, $nama, $uploadFile, $jurusan_id, $prodi_id];
            $mahasiswa = $db->fetchOne($insertMahasiswaQuery, $paramsMahasiswa);

            if (!$mahasiswa) {
                throw new Exception("Gagal menyimpan data mahasiswa.");
            }

            $id_mahasiswa = $mahasiswa['id_mahasiswa'];

            // Simpan data user
            $insertUserquery = "INSERT INTO [user] (username, password_hash, role_id, id_mahasiswa, password)
                                VALUES (?, ?, ?, ?, ?)";
            $paramsUser   = [$username, $password_hash, $role_id, $id_mahasiswa, $password];
            $db->executeProcedure($insertUserquery, $paramsUser);

            // Commit transaksi
            sqlsrv_commit($conn);

            // Update increment setelah berhasil menyimpan
            updateProfileIncrement($increment + 1);

        } catch (Exception $e) {
            // Rollback jika ada kesalahan
            sqlsrv_rollback($conn);
            echo ("Terjadi kesalahan: ") . $e->getMessage();
        }
    } else {
        echo "Gagal mengupload foto profile.";
    }

    // Set session untuk menandakan form sudah disubmit
    $_SESSION['form_submitted'] = true;
    // Redirect untuk me-reload halaman
    // header("Location: " . $_SERVER['PHP_SELF']);
    // exit();
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
        echo "<script>
            window.onload = function() {
                createAlertSuccess(); 
                setTimeout(function() {
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                }, 3000); // Tunda reload selama 3 detik
            };
        </script>";
        unset($_SESSION['form_submitted']);
    }
    setcookie('username', $username, time() + (86400 * 30)); // 86400 = 1 day
    setcookie('password', $password, time() + (86400 * 30)); // 86400 = 1 day
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | PRESPOL</title>
    <link rel="icon" href="img/pres.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <style>
        .invalid {
            border: 2px solid orange;
        }
        /* slideshow */
        .bg-slideshow {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        .bg-slide.active {
            opacity: 1;
        }
    </style>
    <!-- <script src="script.js"></script> -->
</head>
<body class="overflow-x-hidden m-0 p-0 font-helvetica text-stone-900 
            bg-cover bg-center bg-no-repeat bg-fixed"
            style="background-image: url('img/homepageGradient.png')">

    <div class="font-helvetica">
        <div class="flex justify-center min-h-screen">
            <div class="hidden lg:block lg:w-3/5 relative">
                <div class="bg-slideshow h-full">
                    <div class="bg-slide" style="background-image: url('img/imgLogin7.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin8.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin3.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin4.jpeg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin5.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin6.jpg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin1.jpeg')"></div>
                    <div class="bg-slide" style="background-image: url('img/imgLogin2.jpg')"></div>
                </div>
                <div class="absolute inset-0 bg-gray-900 bg-opacity-60 flex items-end pb-20 px-20">
                    <div>
                        <h2 class="text-8xl font-bold text-gray-300">Catat Prestasimu!</h2>
                        <p class="max-w-xl mt-3 text-gray-200">
                            "Torehkan Prestasi, Wujudkan Eksistensi!"
                        </p>
                    </div>
                </div>
            </div>
    
            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1">
                    <div class="text-center">
                        <div class="flex justify-center mx-auto">
                            <a href="../indexLead.php"><img class="cursor-pointer h-7 sm:h-10" src="img/logoBlack.svg" alt="logo">
                            </a>
                        </div>
    
                        <p class="text-l mt-3 text-gray-500">Daftarkan akunmu untuk mengakses website PRESPOL</p>
                    </div>
                    
                    <div class="mt-16 ">
                        <form id="signupForm" name="signupForm" action="" method="POST" enctype="multipart/form-data">
                            <!-- Step 1 - Sign up -->
                            <div id="step1" class="signup-step">
                                <div class="relative flex items-center mt-8">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                    
                                    <input type="text" name="username" id="username" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Username">
                                </div>
    
                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
    
                                    <input type="password" name="password" id="password" required class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Password">
                                    <span 
                                        id="togglePassword"
                                        class="absolute right-3 top-4 cursor-pointer text-gray-400 transition-colors duration-300 focus-within:text-orange-600 hover:text-orange-600">
                                        <!-- Tambahkan ikon di sini -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                    
                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                    
                                    <input type="password" name="confirmPw" id="confirmPw" required class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Confirm Password">
                                    <span 
                                        id="togglePassword2"
                                        class="absolute right-3 top-4 cursor-pointer text-gray-400 transition-colors duration-300 focus-within:text-orange-600 hover:text-orange-600">
                                        <!-- Tambahkan ikon di sini -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                    
                                <div class="mt-6">
                                    <button type="button" id="next" class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-orange-500 rounded-lg hover:bg-orange-400 focus:outline-none focus:ring focus:ring-orange-300 focus:ring-opacity-50">
                                        Selanjutnya
                                    </button>
                    
                                    <div class="mt-6 text-center ">
                                        <p class="mt-6 text-sm text-center text-gray-400">Sudah punya akun? <a href="login.php" class="cursor-pointer focus:outline-none focus:underline hover:underline text-orange-500">Masuk</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 2 - Additional Info -->
                            <div id="step2" class="signup-step hidden">
                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                          </svg>                                          
                                    </span>
                    
                                    <input type="text" name="nim" id="nim" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Nomor Induk Mahasiswa">
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                    
                                    <input type="text" name="nama" id="nama" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Nama Lengkap">
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>
                                    </span>
                    
                                    <select name="jurusan" id="jurusan" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                        <option value="">Pilih Jurusan</option>
                                        <option value="1">Administrasi Niaga</option>
                                        <option value="2">Akuntansi</option>
                                        <option value="3">Teknik Elektro</option>
                                        <option value="4">Teknik Kimia</option>
                                        <option value="5">Teknik Mesin</option>
                                        <option value="6">Teknik Sipil</option>
                                        <option value="7">Teknologi Informasi</option>
                                    </select>
                                </div>
                                
                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                        </svg>
                                    </span>
                    
                                    <select name="prodi" id="prodi" required class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                        <option value="">Pilih Program Studi</option>
                                    </select>
                                </div>

                                <div class="relative">
                                    <label for="dropzone-file" class="flex items-center px-3 py-3 mx-auto mt-6 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                        
                                        <h2 class="mx-3 text-gray-400">Profile Photo</h2>
                        
                                        <button type="button" id="tooltipButton" class="focus:outline-none ml-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 hover:text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                        <span id="tooltip" class="absolute hidden bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 rounded bg-gray-900 p-2 text-xs text-white">
                                            Pastikan foto berukuran 1:1 dengan format .jpg/.jpeg/.png dan maks: 2 MB
                                        </span>
                        
                                        <input id="dropzone-file" name="dropzone-file" type="file" class="hidden" accept=".jpg, .jpeg, .png" required />
                                    </label>
                                </div>

                                <div class="mt-6 flex space-x-4">
                                    <button type="button" class="w-1/2 px-6 py-3 text-sm font-medium tracking-wide text-orange-500 capitalize transition-colors duration-300 transform border border-orange-500 rounded-lg hover:bg-orange-100 focus:outline-none focus:ring focus:ring-orange-300 focus:ring-opacity-50">
                                        Kembali
                                    </button>
                                    <button type="submit" class="w-1/2 px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-orange-500 rounded-lg hover:bg-orange-400 focus:outline-none focus:ring focus:ring-orange-300 focus:ring-opacity-50">
                                        Daftar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Alert Kesalahan Input
        function createErrorOverlayPw() {
            // Create overlay container
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 backdrop-blur-sm';
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('role', 'dialog');

            // Create alert card
            const card = document.createElement('div');
            card.className = 'w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 transition-all duration-300 ease-in-out transform hover:scale-105';

            // Create alert content
            card.innerHTML = `
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Akun Gagal</h3>
                        <p class="text-sm text-gray-600">
                            Input Password dan Konfirmasi Password anda tidak cocok. 
                            <br>
                            Mohon coba lagi.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <button id="dismiss-error" class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Coba lagi
                        </button>
                    </div>
                </div>
            `;

            overlay.appendChild(card);

            // Add to body
            document.body.appendChild(overlay);

            // Function to dismiss overlay
            function dismissOverlay() {
                window.location.href = 'signup.php';
            }

            // Add click events to dismiss
            overlay.addEventListener('click', function(event) {
                // Dismiss if clicking outside the card
                if (event.target === overlay) {
                    dismissOverlay();
                }
            });

            // Add click event to the button
            const dismissButton = card.querySelector('#dismiss-error');
            dismissButton.addEventListener('click', dismissOverlay);

            // Prevent card click from closing the overlay
            card.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        function createErrorOverlayProfile() {
            // Create overlay container
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 backdrop-blur-sm';
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('role', 'dialog');

            // Create alert card
            const card = document.createElement('div');
            card.className = 'w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 transition-all duration-300 ease-in-out transform hover:scale-105';

            // Create alert content
            card.innerHTML = `
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Akun Gagal</h3>
                        <p class="text-sm text-gray-600">
                            Terdapat kesalahan pada tipe ataupun ukuran file foto profil yang anda unggah. 
                            <br><br>
                            Mohon untuk mengunggah file .jpg/.jpeg/.png berukuran maksimal 2 MB.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <button id="dismiss-error" class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Coba lagi
                        </button>
                    </div>
                </div>
            `;

            overlay.appendChild(card);

            // Add to body
            document.body.appendChild(overlay);

            // Function to dismiss overlay
            function dismissOverlay() {
                window.location.href = 'signup.php';
            }

            // Add click events to dismiss
            overlay.addEventListener('click', function(event) {
                // Dismiss if clicking outside the card
                if (event.target === overlay) {
                    dismissOverlay();
                }
            });

            // Add click event to the button
            const dismissButton = card.querySelector('#dismiss-error');
            dismissButton.addEventListener('click', dismissOverlay);

            // Prevent card click from closing the overlay
            card.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        function createErrorOverlayValidDatabase() {
            // Create overlay container
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 backdrop-blur-sm';
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('role', 'dialog');

            // Create alert card
            const card = document.createElement('div');
            card.className = 'w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 transition-all duration-300 ease-in-out transform hover:scale-105';

            // Create alert content
            card.innerHTML = `
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Akun Gagal</h3>
                        <p class="text-sm text-gray-600">
                            Username atau NIM yang anda inputkan sudah dipakai. 
                            <br><br>
                            Mohon untuk menginputkan NIM milik anda sendiri. Jika anda sudah memiliki akun, silahkan menuju ke halaman Masuk.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <button id="dismiss-error" class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Coba lagi
                        </button>
                    </div>
                </div>
            `;

            overlay.appendChild(card);

            // Add to body
            document.body.appendChild(overlay);

            // Function to dismiss overlay
            function dismissOverlay() {
                window.location.href = 'signup.php';
            }

            // Add click events to dismiss
            overlay.addEventListener('click', function(event) {
                // Dismiss if clicking outside the card
                if (event.target === overlay) {
                    dismissOverlay();
                }
            });

            // Add click event to the button
            const dismissButton = card.querySelector('#dismiss-error');
            dismissButton.addEventListener('click', dismissOverlay);

            // Prevent card click from closing the overlay
            card.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        function createAlertSuccess() {
            // Create overlay container
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 backdrop-blur-sm';
            overlay.setAttribute('aria-modal', 'true');
            overlay.setAttribute('role', 'dialog');

            // Create alert card
            const card = document.createElement('div');
            card.className = 'w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 transition-all duration-300 ease-in-out transform hover:scale-105';

            // Create alert content
            card.innerHTML = `
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h3>
                        <p class="text-sm text-gray-600">
                            Silahkan menuju ke halaman Masuk untuk melanjutkan.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <button id="dismiss-error" class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            `;

            overlay.appendChild(card);

            // Add to body
            document.body.appendChild(overlay);

            // Function to dismiss overlay
            function dismissOverlay() {
                window.location.href = 'login.php';
            }

            // Add click events to dismiss
            overlay.addEventListener('click', function(event) {
                // Dismiss if clicking outside the card
                if (event.target === overlay) {
                    dismissOverlay();
                }
            });

            // Add click event to the button
            const dismissButton = card.querySelector('#dismiss-error');
            dismissButton.addEventListener('click', dismissOverlay);

            // Prevent card click from closing the overlay
            card.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        // Cek jika session 'form_submitted' ada
        

        
        document.addEventListener('DOMContentLoaded', function() {
            const pw = document.getElementById('confirmPw');
            const next = document.getElementById('next');
            // Tambahkan event listener pada input
            pw.addEventListener('keydown', function (event) {
            // Periksa jika tombol yang ditekan adalah 'Enter'
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah aksi default jika diperlukan
                next.click(); // Panggil aksi tombol
            }
            });

            const form = document.getElementById('signupForm');
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Validate all inputs in step 2
                const additionalInfoInputs = step2.querySelectorAll('input:not([type="file"]), select');
                const fileInput = document.getElementById('dropzone-file');
                let isValid = true;

                // Validate additional info inputs
                additionalInfoInputs.forEach(input => {
                    if (input.value.trim() === '') {
                        isValid = false;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });

                // File upload validation
                if (!fileInput.files.length) {
                    isValid = false;
                    fileInput.closest('label').classList.add('border-red-500');
                } else {
                    fileInput.closest('label').classList.remove('border-red-500');

                    // Additional file validation
                    const file = fileInput.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!validTypes.includes(file.type)) {
                        isValid = false;
                        createErrorOverlayProfile();
                        fileInput.value = ''; // Clear the file input
                    }

                    if (file.size > maxSize) {
                        isValid = false;
                        createErrorOverlayProfile();
                        fileInput.value = ''; // Clear the file input
                    }
                }

                // If all validations pass, submit form
                if (isValid) {
                    // Here you would typically handle form submission
                    // For now, just show a success message
                    // alert('Form submitted successfully!');
                    // You can replace this with actual form submission logic
                    form.submit(); // Uncomment for actual submission
                    
                }
                
                // const formData = new FormData(form);
                // console.log(...formData); // Log form data to see what is being sent

                // try {
                //     const response = await fetch('signup.php', {
                //         method: 'POST',
                //         body: formData,
                //     });

                //     const result = await response.json();
                //     console.log(result); // Check the response from the server

                //     if (result.status === 'success') {
                //         createAlertSuccess(); // Panggil fungsi JS untuk sukses
                //     } else if (result.status === 'error') {
                //         createErrorOverlayValidDatabase(); // Panggil fungsi JS untuk error
                //     } else {
                //         alert(result.message);
                //     }
                // } catch(error) {
                //     console.error('Terjadi kesalahan saat menghubungi server:', error);
                // }
            });

            // Pagination --
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');

            // Step 1 Next Button
            const step1NextBtn = step1.querySelector('button');
            step1NextBtn.addEventListener('click', () => {
                // Validate Step 1 inputs
                const username = document.getElementById('username');
                const password = document.getElementById('password');
                const confirmPw = document.getElementById('confirmPw');

                // Basic validation
                let isValid = true;

                // Username validation
                if (username.value.trim() === '') {
                    isValid = false;
                    username.classList.add('border-red-500');
                } else {
                    username.classList.remove('border-red-500');
                }

                // Password validation
                if (password.value.trim() === '') {
                    isValid = false;
                    password.classList.add('border-red-500');
                } else {
                    password.classList.remove('border-red-500');
                }

                // Confirm password validation
                if (confirmPw.value.trim() === '') {
                    isValid = false;
                    confirmPw.classList.add('border-red-500');
                } else if (password.value !== confirmPw.value) {
                    isValid = false;
                    confirmPw.classList.add('border-red-500');
                    // Optional: Show error message
                    createErrorOverlayPw();
                } else {
                    confirmPw.classList.remove('border-red-500');
                }

                // If all validations pass, move to step 2
                if (isValid) {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                }
            });

            // Step 2 Buttons
            const step2BackBtn = step2.querySelector('button:first-child');
            const step2SubmitBtn = step2.querySelector('button[type="submit"]');

            // Back Button Functionality
            step2BackBtn.addEventListener('click', () => {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
            });

            

            // Tooltip functionality
            const tooltipButton = document.getElementById('tooltipButton');
            const tooltip = document.getElementById('tooltip');

            tooltipButton.addEventListener('mouseenter', () => {
                tooltip.classList.remove('hidden');
            });

            tooltipButton.addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });

            // Form Submission
            // signupForm.addEventListener('submit', (event) => {
            //     event.preventDefault();

            //     // Validate all inputs in step 2
            //     const additionalInfoInputs = step2.querySelectorAll('input:not([type="file"]), select');
            //     const fileInput = document.getElementById('dropzone-file');
            //     let isValid = true;

            //     // Validate additional info inputs
            //     additionalInfoInputs.forEach(input => {
            //         if (input.value.trim() === '') {
            //             isValid = false;
            //             input.classList.add('border-red-500');
            //         } else {
            //             input.classList.remove('border-red-500');
            //         }
            //     });

            //     // File upload validation
            //     if (!fileInput.files.length) {
            //         isValid = false;
            //         fileInput.closest('label').classList.add('border-red-500');
            //     } else {
            //         fileInput.closest('label').classList.remove('border-red-500');

            //         // Additional file validation
            //         const file = fileInput.files[0];
            //         const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            //         const maxSize = 2 * 1024 * 1024; // 2MB

            //         if (!validTypes.includes(file.type)) {
            //             isValid = false;
            //             createErrorOverlayProfile();
            //             fileInput.value = ''; // Clear the file input
            //         }

            //         if (file.size > maxSize) {
            //             isValid = false;
            //             createErrorOverlayProfile();
            //             fileInput.value = ''; // Clear the file input
            //         }
            //     }

            //     // // If all validations pass, submit form
            //     // if (isValid) {
            //     //     // Here you would typically handle form submission
            //     //     // For now, just show a success message
            //     //     alert('Form submitted successfully!');
            //     //     // You can replace this with actual form submission logic
            //     //     // signupForm.submit(); // Uncomment for actual submission
            //     // }
            // });

            // File input change event
            const dropzoneFile = document.getElementById('dropzone-file');
            dropzoneFile.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    // Optional: Add visual feedback for file selection
                    const fileLabel = event.target.closest('label');
                    fileLabel.querySelector('h2').textContent = file.name;
                }
            });

            // Define the program study options for each major
            const prodiOptions = {
                '1': [
                    { id: 28, name: 'D-III Administrasi Bisnis' },
                    { id: 25, name: 'D-IV Bahasa Inggris Untuk Industri Pariwisata' },
                    { id: 25, name: 'D-IV Bahasa Inggris untuk Komunikasi Bisnis dan Profesional' },
                    { id: 24, name: 'D-IV Manajemen Pemasaran' },
                    { id: 26, name: 'D-IV Pengelolaan Arsip dan Rekaman Informasi' },
                    { id: 27, name: 'D-IV Usaha Perjalanan Wisata' }
                ],
                '2': [
                    { id: 23, name: 'D-III Akuntansi' },
                    { id: 21, name: 'D-IV Akuntansi Manajeman' },
                    { id: 22, name: 'D-IV Keuangan' },
                ],
                '3': [
                    { id: 7, name: 'D-III Teknik Elektronika' },
                    { id: 8, name: 'D-III Teknik Listrik' },
                    { id: 9, name: 'D-III Teknik Telekomunikasi' },
                    { id: 6, name: 'D-IV Jaringan Telekomunikasi Digital' },
                    { id: 5, name: 'D-IV Sistem Kelistrikan' },
                    { id: 4, name: 'D-IV Teknik Elektronika' }
                ],
                '4': [
                    { id: 11, name: 'D-III Chemical Engineering Study Program' },
                    { id: 10, name: 'D-IV Chemical Engineering Study Program' }
                ],
                '5': [
                    { id: 14, name: 'D-III Teknik Mesin' },
                    { id: 15, name: 'D-III Teknologi Pemeliharaan Pesawat Udara' },
                    { id: 13, name: 'D-IV Teknik Mesin Produksi dan Perawatan' },
                    { id: 12, name: 'D-IV Teknik Otomotif Elektronik' }
                ],
                '6': [
                    { id: 18, name: 'D-III Teknik Sipil' },
                    { id: 19, name: 'D-III Teknologi Konstruksi Jalan, Jembatan, dan Bangunan Air' },
                    { id: 20, name: 'D-III Teknologi Pertambangan' },
                    { id: 16, name: 'D-IV Manajemen Rekayasa Konstruksi' },
                    { id: 17, name: 'D-IV Teknologi Rekayasa Konstruksi Jalan dan Jembatan' }
                ],
                '7': [
                    { id: 3, name: 'D-II Pengembangan Piranti Lunak Situs' },
                    { id: 2, name: 'D-IV Sistem Informasi Bisnis' },
                    { id: 1, name: 'D-IV Teknik Informatika' }
                ]
            };

            // Get references to the dropdowns
            const jurusanDropdown = document.getElementById('jurusan');
            const prodiDropdown = document.getElementById('prodi');

            // Add event listener to jurusan dropdown
            jurusanDropdown.addEventListener('change', function() {
                // Hapus opsi lama
                prodiDropdown.innerHTML = '<option value="">Pilih Program Studi</option>';
                
                // Ambil jurusan yang dipilih
                const selectedJurusan = this.value;

                // Jika ada jurusan yang dipilih, isi dropdown prodi
                if (selectedJurusan && prodiOptions[selectedJurusan]) {
                    prodiOptions[selectedJurusan].forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi.id; // Gunakan ID sebagai value
                        option.textContent = prodi.name; // Tampilkan nama program studi
                        prodiDropdown.appendChild(option);
                    });
                    prodiDropdown.disabled = false;
                } else {
                    prodiDropdown.disabled = true;
                }
            });
            
            // Function to create password toggle functionality
            function setupPasswordToggle(toggleSelector, passwordSelector) {
                const togglePassword = document.querySelector(toggleSelector);
                const password = document.querySelector(passwordSelector);

                if (togglePassword && password) {
                    togglePassword.addEventListener('click', function () {
                        // Toggle the type attribute
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);

                        // Toggle the eye icon (optional)
                        this.classList.toggle('text-orange-600');

                        // Optional: Focus back on the password input after toggling
                        password.focus();
                    });
                }
            }

            // Setup toggles for both password fields
            setupPasswordToggle('#togglePassword', '#password');
            setupPasswordToggle('#togglePassword2', '#confirmPw');

            const slides = document.querySelectorAll('.bg-slide');
            let currentSlide = 0;

            // Initially activate the first slide
            slides[0].classList.add('active');

            // Function to change slides
            function changeSlide() {
                // Remove active class from current slide
                slides[currentSlide].classList.remove('active');
                
                // Move to next slide, wrap around to start if at end
                currentSlide = (currentSlide + 1) % slides.length;
                
                // Add active class to new slide
                slides[currentSlide].classList.add('active');
            }

            // Change slide every 5 seconds
            setInterval(changeSlide, 5000);
        });
    </script>
</body>
</html>