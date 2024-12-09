<?php
include 'config/Database.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $foto_profile = $_FILES['foto_profile']['name'];
    $foto_profile_tmp = $_FILES['foto_profile']['tmp_name'];
    $jurusan_id = $_POST['jurusan'];
    $prodi_id = $_POST['prodi'];
    $role_id = '3';
    $nim = $username;

    // Validasi file foto
    $uploadDir = 'upload/profile/mahasiswa/';
    $uploadFile = $uploadDir . basename($foto_profile);


    if (move_uploaded_file($foto_profile_tmp, $uploadFile)) {
        try {
            // Mulai transaksi
            sqlsrv_begin_transaction($conn);

            // Simpan data mahasiswa
            $insertMahasiswaQuery = "INSERT INTO mahasiswa (nama, foto_profile, id_jurusan, id_prodi, nim) 
                                     OUTPUT INSERTED.id_mahasiswa 
                                     VALUES (?, ?, ?, ?, ?)";
            $paramsMahasiswa = [$nama, $uploadFile, $jurusan_id, $prodi_id, $nim];
            $mahasiswa = $db->fetchOne($insertMahasiswaQuery, $paramsMahasiswa);

            if (!$mahasiswa) {
                throw new Exception("Gagal menyimpan data mahasiswa.");
            }

            $mahasiswa_id = $mahasiswa['id_mahasiswa'];

            // Simpan data user
            $insertUserquery = "INSERT INTO [user] (username, password, password_hash, role_id, id_mahasiswa) 
                                VALUES (?, ?, ?,? )";
            $paramsUser   = [$username, $password, $role_id, $mahasiswa_id];
            $db->executeProcedure($insertUserquery, $paramsUser);

            // Commit transaksi
            sqlsrv_commit($conn);

            //jadikan alert
            echo ("Akun berhasil dibuat!");
        } catch (Exception $e) {
            // Rollback jika ada kesalahan
            sqlsrv_rollback($conn);
            echo ("Terjadi kesalahan: ") . $e->getMessage();
        }
    } else {
        echo "Gagal mengupload foto profile.";
    }
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
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
    <script src="script.js"></script>
</head>

<body
    class="overflow-x-hidden m-0 p-0 font-helvetica text-stone-900 bg-cover bg-center bg-no-repeat bg-fixed max-h-[400px] overflow-y-auto"
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
                            <img onclick="navigateToPage('../index.html')" class="cursor-pointer h-7 sm:h-10"
                                src="img/logoBlack.svg" alt="logo">
                        </div>

                        <p class="text-l mt-3 text-gray-500">Daftarkan akunmu untuk mengakses website PRESPOL</p>
                    </div>

                    <div class="mt-16 ">
                        <form id="registrationForm" method="POST" action="" enctype="multipart/form-data">
                            <!-- Step 1 - Sign up -->
                            <div id="step1" class="signup-step">
                                <div class="relative flex items-center mt-8">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>

                                    <input type="text" name="username" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        placeholder="Username (NIM)">
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 5 9-5" />
                                        </svg>
                                    </span>

                                    <input type="password" id="password" name="password" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        placeholder="Password">

                                    <button type="button" id="togglePassword" class="absolute right-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 5 9-5" />
                                        </svg>
                                    </span>

                                    <input type="password" id="confirmPassword" name="confirmPassword" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        placeholder="Confirm Password">

                                    <button type="button" id="toggleConfirmPassword" class="absolute right-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between mt-6">
                                    <button type="button" id="nextButton"
                                        class="w-full px-4 py-2 text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring focus:ring-orange-300">
                                        Selanjutnya
                                    </button>
                                </div>

                                <div class="mt-6 text-center ">
                                    <p class="mt-6 text-sm text-center text-gray-400">Sudah punya akun? <a href="login.php" class="cursor-pointer focus:outline-none focus:underline hover:underline hover:text-orange-500">Masuk</a>.</p>
                                </div>
                            </div>

                            <!-- Step 2 - Additional Information -->
                            <div id="session2" class="hidden">
                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>
                                    </span>

                                    <input type="text" name="nama" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        placeholder="Nama Lengkap">
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                        </svg>
                                    </span>

                                    <select name="jurusan" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                        <option value="">Pilih Jurusan</option>
                                        <option value="1">Teknologi Informasi</option>
                                        <option value="2">Teknik Elektro</option>
                                        <option value="3">Teknik Kimia</option>
                                        <option value="4">Teknik Mesin</option>
                                        <option value="5">Teknik Sipil</option>
                                        <option value="6">Akuntansi</option>
                                        <option value="7">Administrasi Niaga</option>
                                    </select>
                                </div>

                                <div class="relative flex items-center mt-4">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                    </span>

                                    <select name="prodi" required
                                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-orange-400 focus:ring-orange-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                        <option value="">Pilih Program Studi</option>
                                        <option value="1">D-IV Teknik Informatika</option>
                                        <option value="2">D-IV Sistem Informasi Bisnis</option>
                                        <option value="3">D-II Pengembangan Piranti Lunak Situs</option>
                                        <option value="4">D-IV Teknik Elektronika</option>
                                        <option value="5">D-IV Sistem Kelistrikan</option>
                                        <option value="6">D-IV Jaringan Telekomunikasi Digital</option>
                                        <option value="7">D-III Teknik Elektronika</option>
                                        <option value="8">D-III Teknik Listrik</option>
                                        <option value="9">D-III Teknik Telekomunikasi</option>
                                        <option value="10">D-IV Chemical Engineering Study Program</option>
                                        <option value="11">D-III Chemical Engineering Study Program</option>
                                        <option value="12">D-IV Teknik Otomotif Elektronik</option>
                                        <option value="13">D-IV Teknik Mesin Produksi dan Perawatan</option>
                                        <option value="14">D-III Teknik Mesin</option>
                                        <option value="15">D-III Teknologi Pemeliharaan Pesawat Udara</option>
                                        <option value="16">D-IV Manajemen Rekayasa Konstruksi</option>
                                        <option value="17">D-IV Teknologi Rekayasa Konstruksi Jalan dan Jembatan</option>
                                        <option value="18">D-III Teknik Sipil</option>
                                        <option value="19">D-III Teknologi Konstruksi Jalan, Jembatan, dan Bangunan Air</option>
                                        <option value="20">D-III Teknologi Pertambangan</option>
                                        <option value="21">D-IV Akuntansi Manajeman</option>
                                        <option value="22">D-IV Keuangan</option>
                                        <option value="23">D-III Akuntansi</option>
                                        <option value="24">D-IV Manajemen Pemasaran</option>
                                        <option value="25">D-IV Bahasa Inggris untuk Komunikasi Bisnis dan Profesional</option>
                                        <option value="26">D-IV Pengelolaan Arsip dan Rekaman Informasi</option>
                                        <option value="27">D-IV Usaha Perjalanan Wisata</option>
                                        <option value="28">D-III Administrasi Bisnis</option>
                                    </select>
                                </div>

                                <div class="relative">
                                    <label for="foto_profile"
                                        class="flex items-center px-3 py-3 mx-auto mt-6 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 7v10a2 2 0 002 2h14a2 2                                                0 002-2V7M3 7l9 5 9-5" />
                                        </svg>
                                        <span class="ml-2 text-gray-600">Upload Foto Profil</span>
                                        <input type="file" name="foto_profile" id="foto_profile" class="hidden" accept="image/*" required>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between mt-6">
                                    <button type="button" id="prevButton"
                                        class="w-full px-4 py-2 text-orange-500 border border-orange-500 bg-transparent rounded-lg hover:bg-orange-500 hover:text-white focus:outline-none focus:ring focus:ring-orange-300">
                                        Kembali
                                    </button>
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring focus:ring-orange-300">
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye slash icon
            togglePassword.innerHTML = type === 'password' ?
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
            </svg>`;
        });
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        toggleConfirmPassword.addEventListener('click', () => {
            // Toggle the type attribute
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Toggle the eye slash icon
            toggleConfirmPassword.innerHTML = type === 'password' ?
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12s2-4 9-4 9 4 9 4-2 4-9 4-9-4-9-4z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
        </svg>`;
        });
        const nextButton = document.getElementById('nextButton');
        const prevButton = document.getElementById('prevButton');
        const step1 = document.getElementById('step1');
        const session2 = document.getElementById('session2');
        const inputs = step1.querySelectorAll('input[required]');

        nextButton.addEventListener('click', () => {
            let allFilled = true;

            inputs.forEach(input => {
                if (!input.value) {
                    allFilled = false;
                    input.classList.add('border-orange-400'); // Tambahkan border oranye
                } else {
                    input.classList.remove('border-orange-400'); // Hapus border oranye jika terisi
                }
            });

            // Memeriksa apakah password dan konfirmasi password cocok
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value; // Perbaiki ID di sini

            if (password !== confirmPassword) {
                alert("Password tidak cocok");
                allFilled = false;
                document.getElementById('password').classList.add('border-orange-400');
                document.getElementById('confirmPassword').classList.add('border-orange-400'); // Perbaiki ID di sini
            } else {
                document.getElementById('password').classList.remove('border-orange-400');
                document.getElementById('confirmPassword').classList.remove('border-orange-400'); // Perbaiki ID di sini
            }

            // Jika semua input terisi dan password cocok, lanjut ke sesi berikutnya
            if (allFilled) {
                step1.classList.add('hidden');
                session2.classList.remove('hidden');
            }
        });

        prevButton.addEventListener('click', () => {
            session2.classList.add('hidden');
            step1.classList.remove('hidden');
        });

        function showStep2() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }

        // Fungsi untuk menampilkan langkah 1
        function showStep1() {
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
        }

        // Efek Parallax
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const background = document.querySelector('body');
            background.style.backgroundPositionY = `${scrolled * 0.5}px`; // Ubah 0.5 untuk mengatur kecepatan parallax
        });
    </script>
</body>

</html>