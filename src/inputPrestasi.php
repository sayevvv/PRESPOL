<?php
session_start();
include_once 'classes/User.php';
include_once 'classes/Auth.php';
Auth::checkLogin();

if ($_SESSION['role'] == '2') {
    header('Location: home.php');
}

$no_induk= $_SESSION['no_induk'];
$user = null;

if ($_SESSION['role'] == '1') {
    include_once 'classes/Admin.php';
    $user = new Admin($no_induk);
} else if ($_SESSION['role'] == '3') {
    include_once 'classes/Mahasiswa.php';
    $user = new Mahasiswa($no_induk);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Prestasi</title>
    <!-- tambah kode -->
    <link rel="icon" href="img/pres.png" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- jQuery and jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url('img/homepageGradient.png') no-repeat center center fixed;
            /* Fixed background */
            background-size: cover;
            /* Ensures the image covers the entire area */
        }

        .border-red-500 {
            border-color: red !important;
        }
        
        #tooltip {
            transition: opacity 0.3s ease, transform 0.3s ease;
}
    </style>
</head>

<body class="min-h-screen flex flex-col md:flex-row [&::-webkit-scrollbar]:w-2
            [&::-webkit-scrollbar-track]:rounded-full
            [&::-webkit-scrollbar-track]:bg-neutral-100
            [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-thumb]:bg-neutral-300
            md:[&::-webkit-scrollbar]:block
            [&::-webkit-scrollbar]:hidden">
        <!-- Sidebar -->
        <aside class="flex-1">
            <?php
            echo $user->sidebar();
            ?>
        </aside>
        <!-- Main Content -->
        <main class="mb-16 md:mb-0 flex-2 lg:overflow-y-auto md:w-[calc(100%-5rem)] lg:w-[calc(100%-16rem)] p-4 md:p-6 pt-8 bg-white/80 md:bg-transparent">
            <div class="container mx-auto max-w-full space-y-6 justify-center md:justify-between ">
            <!-- Header -->
            <header class="flex items-center mb-10">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold">Tambah Prestasi</h1>
            </header>
            <!-- Note Mobile -->
            <div class="block lg:hidden bg-white p-6 border border-gray-300 rounded-lg">
                <h2 class="text-xl font-bold text-orange-500">Note!</h2>
                    <p class="mt-4 text-gray-700">(1) Semua kolom yang <b>tidak</b> berlabel opsional, <b>WAJIB DIISI</b></p>
                    <p class="mt-4 text-gray-700">(2) Lampiran File : </p>
                    <p class="mt-1 text-gray-700">- Format file yang didukung : <i>JPG, JPEG, PNG, SVG, MP4</i> dan <i>PDF</i></p>
                    <p class="mt-1 text-gray-700">- Ukuran file tidak boleh melebihi batas maksimum</p>
                    <p class="mt-4 text-gray-700">(3) Pasikan sebelum klik tombol <b>SIMPAN</b>, cek terlebih dahulu datanya</p>
            </div>
            <!-- Form -->
            <form id="prestasiForm" class="space-y-4" action="inputProses.php" method="POST" enctype="multipart/form-data">

                <?php
                if ($user instanceof Mahasiswa) {
                    echo <<<HTML
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                            <input type="text" id="nim" name="nim" value="$no_induk" readonly class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            <p class="text-red-500 text-sm hidden" id="error-nim">NIM tidak boleh kosong!</p>
                        </div>
                    HTML;
                } else {
                    echo <<<HTML
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                            <input type="text" id="nim" name="nim" placeholder="2341720056" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                            <p class="text-red-500 text-sm hidden" id="error-nim">NIM tidak boleh kosong!</p>
                        </div>
                    HTML;
                }
                ?>

                <div>
                    <label for="nama_kompetisi" class="block text-sm font-medium text-gray-700">Nama Kompetisi</label>
                    <input type="text" id="nama_kompetisi" name="nama_kompetisi" placeholder="UI / UX Design" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                    <p class="text-red-500 text-sm hidden" id="error-nama_kompetisi">Nama Kompetisi tidak boleh kosong!</p>
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori Juara</label>
                    <div class="group focus-within:ring-2 focus-within:ring-slate-900 flex items-center w-full lg:w-3/4 border border-gray-300 rounded-lg p-3 bg-white cursor-pointer">
                        <select id="kategori" name="id_juara" class="w-full appearance-none bg-transparent outline-none cursor-pointer">
                            <option class="placeholder text-gray-700" value="">Pilih Juara</option>
                            <option value="1">Juara 1</option>
                            <option value="2">Juara 2</option>
                            <option value="3">Juara 3</option>
                            <option value="4">Harapan 1</option>
                            <option value="5">Harapan 2</option>
                            <option value="6">Harapan 3</option>
                            <option value="7">Best Of</option>
                            <option value="8">Finalis</option>
                        </select>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                    <p class="text-red-500 text-sm hidden" id="error-kategori">Kategori Juara tidak boleh kosong!</p>
                </div>

                <div>
                    <label for="penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                    <input type="text" id="penyelenggara" name="penyelenggara" placeholder="Universitas Negeri Malang" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                    <p class="text-red-500 text-sm hidden" id="error-penyelenggara">Penyelenggara tidak boleh kosong!</p>
                </div>

                <div>
                    <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                    <input type="text" id="event" name="event" placeholder="Creative UI/UX Designer Competition" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                    <p class="text-red-500 text-sm hidden" id="error-event">Event tidak boleh kosong!</p>
                </div>

                <div>
                    <label for="dospem1" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 1 <i>(Opsional)</i></label>
                    <input type="text" id="dospem1" name="dosen_pembimbing_1" placeholder="Wafiqah Azzahra Na'imah S.Kom., M.Kom." class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label for="dospem2" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 2 <i>(Opsional)</i></label>
                    <input type="text" id="dospem2" name="dosen_pembimbing_2" placeholder="Ahmad Thaha Al - Junaedi S.ST., M.Sc" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label for="peserta" class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                    <input type="text" id="peserta" name="jumlah_peserta" placeholder="3" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg">
                    <p class="text-red-500 text-sm hidden" id="error-peserta">Jumlah Peserta tidak boleh kosong!</p>
                </div>
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700">Tingkat Kompetisi</label>
                    <div class="group focus-within:ring-2 focus-within:ring-slate-900 flex items-center w-full lg:w-3/4 border border-gray-300 rounded-lg p-3 bg-white cursor-pointer">
                        <select id="tingkat" name="id_kategori" class="w-full appearance-none bg-transparent outline-none cursor-pointer">
                            <option value="" class="placeholder">Pilih kategori kompetisi</option>
                            <option value="1">Internasional</option>
                            <option value="2">Nasional</option>
                            <option value="3">Regional</option>
                            <option value="4">Lokal</option>
                        </select>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                    <p class="text-red-500 text-sm hidden" id="error-tingkat">Kategori Kompetisi tidak boleh kosong!</p>
                </div>

                <div>
                    <h2 class="text-xl font-bold mt-6 mb-3">Waktu Pelaksanaan</h2>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="text" id="tanggal_mulai" name="tanggal_mulai" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg" placeholder="08-10-2024">
                    <p class="text-red-500 text-sm hidden" id="error-tanggal_mulai">Tanggal Mulai tidak boleh kosong!</p>
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="text" id="tanggal_selesai" name="tanggal_selesai" class="w-full lg:w-3/4 p-3 border border-gray-300 rounded-lg" placeholder="23-11-2024">
                    <p class="text-red-500 text-sm hidden" id="error-tanggal_selesai">Tanggal Selesai tidak boleh kosong!</p>
                </div>

                <!-- Lampiran -->
                <section>
                    <h2 class="text-xl font-bold mt-6 mb-3">Lampiran</h2>
                    <div class="space-y-4">
                        <div class="foto_kompetisi">
                            <!-- Label untuk file -->
                            <label for="foto_kompetisi" class="block text-sm font-medium text-gray-700">Foto Kompetisi (maks 5MB)</label>

                            <!-- Container input dengan label -->
                            <label for="foto_kompetisi" class="flex items-center px-3 py-3 w-full lg:w-3/4 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h2 id="file-foto" class="mx-3 text-gray-400 truncate">xxx.jpeg</h2>
                                
                                <!-- Input file -->
                                <input id="foto_kompetisi" type="file" name="foto_kompetisi" class="hidden" accept="image/*">
                            </label>

                            <!-- Pesan kesalahan -->
                            <p class="text-red-500 text-sm hidden" id="error-foto_kompetisi">Foto Kompetisi tidak boleh kosong!</p>
                        </div>

                        <div class="poster_kompetisi">
                            <!-- Label untuk file -->
                            <label for="poster_kompetisi" class="block text-sm font-medium text-gray-700">Poster Kompetisi (maks 5MB)</label>

                            <!-- Container input dengan label -->
                            <label for="poster_kompetisi" class="flex items-center px-3 py-3 w-full lg:w-3/4 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h2 id="file-poster" class="mx-3 text-gray-400 truncate">xxx.png</h2>
            
                                <!-- Input file -->
                                <input id="poster_kompetisi" type="file" name="flyer" class="hidden" accept=".pdf,image/*">
                            </label>

                            <!-- Pesan kesalahan -->
                            <p class="text-red-500 text-sm hidden" id="error-poster_kompetisi">Poster Kompetisi tidak boleh kosong!</p>
                        </div>
                        <div class="sertifikat_kompetisi">
                            <!-- Label untuk file -->
                            <label for="sertifikat" class="block text-sm font-medium text-gray-700">Sertifikat (maks 5MB)</label>

                            <!-- Container input dengan label -->
                            <label for="sertifikat" class="flex items-center px-3 py-3 w-full lg:w-3/4 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h2 id="file-sertifikat" class="mx-3 text-gray-400 truncate">xxx.pdf</h2>
                                
                                <!-- Input file -->
                                <input id="sertifikat" type="file" name="sertifikat" class="hidden" accept=".pdf">
                            </label>

                            <!-- Pesan kesalahan -->
                            <p class="text-red-500 text-sm hidden" id="error-sertifikat">Sertifikat Kompetisi tidak boleh kosong!</p>
                        </div>
                        <div class="surat_tugas">
                            <!-- Label untuk file -->
                            <label for="surat_tugas" class="block text-sm font-medium text-gray-700">Surat Tugas (maks 5MB)</label>

                            <!-- Container input dengan label -->
                            <label for="surat_tugas" class="flex items-center px-3 py-3 w-full lg:w-3/4 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h2 id="file-surat_tugas" class="mx-3 text-gray-400 truncate">xxx.pdf</h2>
                                
                                <!-- Input file -->
                                <input id="surat_tugas" type="file" name="surat_tugas" class="hidden" accept=".pdf">
                            </label>

                            <!-- Pesan kesalahan -->
                            <p class="text-red-500 text-sm hidden" id="error-surat_tugas">Surat Tugas tidak boleh kosong!</p>
                        </div>
                        <div class="upload_karya">
                            <!-- Label untuk file -->
                            <label for="upload_karya" class="block text-sm font-medium text-gray-700">Karya (maks 75MB) <i>Opsional</i></label>

                            <!-- Container input dengan label -->
                            <label for="upload_karya" class="flex items-center px-3 py-3 w-full lg:w-3/4 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <h2 id="file-karya" class="mx-3 text-gray-400 truncate">xxx.png</h2>
                                
                                <!-- Input file -->
                                <input id="upload_karya" type="file" name="karya_kompetisi" class="hidden">
                            </label>
                        </div>
                    </div>
                </section>
                <!-- Submit Button -->
                <button type="submit" class="w-full lg:w-3/4 p-3 bg-black text-white rounded-lg">Submit</button>
            </form>
        </main>
        <!-- Note Section -->
        <aside class="hidden lg:block w-1/5 p-10 py-25 fixed right-0">
            <div class="bg-white p-6 border border-gray-300 rounded-lg">
                <h2 class="text-xl font-bold text-orange-500">Note!</h2>
                    <p class="mt-4 text-gray-700">(1) Semua kolom yang <b>tidak</b> berlabel opsional, <b>WAJIB DIISI</b></p>
                    <p class="mt-4 text-gray-700">(2) Lampiran File : </p>
                    <p class="mt-1 text-gray-700">- Format file yang didukung : <i>JPG, JPEG, PNG, SVG, MP4</i> dan <i>PDF</i></p>
                    <p class="mt-1 text-gray-700">- Ukuran file tidak boleh melebihi batas maksimum</p>
                    <p class="mt-4 text-gray-700">(3) Pasikan sebelum klik tombol <b>SIMPAN</b>, cek terlebih dahulu datanya</p>
            </div>
        </aside>
    <script>
        $(function() {
            $("#tanggal_mulai").datepicker({
                dateFormat: "dd-mm-yy", // Adjust date format as needed
                showAnim: "slideDown", // Animation for opening the calendar
                changeMonth: true, // Enable month dropdown
                changeYear: true, // Enable year dropdown
                showButtonPanel: true, // Optional: Add "Today" and "Done" buttons
                closeText: "Done", // Text for the Done button
                currentText: "Today", // Text for the Today button
                beforeShow: function(input, inst) {
                    setTimeout(function() {
                        // Add custom functionality to the "Today" button
                        $(inst.dpDiv)
                            .find(".ui-datepicker-current")
                            .off("click")
                            .on("click", function() {
                                const today = new Date();
                                $("#tanggal_mulai").datepicker("setDate", today);
                            });
                    }, 1);
                }
            });
            $("#tanggal_selesai").datepicker({
                dateFormat: "dd-mm-yy", // Adjust date format as needed
                showAnim: "slideDown", // Animation for opening the calendar
                changeMonth: true, // Enable month dropdown
                changeYear: true, // Enable year dropdown
                showButtonPanel: true, // Optional: Add "Today" and "Done" buttons
                closeText: "Done", // Text for the Done button
                currentText: "Today", // Text for the Today button
                beforeShow: function(input, inst) {
                    setTimeout(function() {
                        // Add custom functionality to the "Today" button
                        $(inst.dpDiv)
                            .find(".ui-datepicker-current")
                            .off("click")
                            .on("click", function() {
                                const today = new Date();
                                $("#tanggal_selesai").datepicker("setDate", today);
                            });
                    }, 1);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Placeholder handling for dropdown "tingkat"
            const $tingkatSelect = $("#tingkat");
            const $tingkatPlaceholder = $tingkatSelect.find("option.placeholder");

            $tingkatSelect.css("color", "gray");
            $tingkatSelect.on("focus", function() {
                $tingkatPlaceholder.hide();
                $tingkatSelect.css("color", "black");
            });

            $tingkatSelect.on("blur", function() {
                if (!$tingkatSelect.val()) {
                    $tingkatPlaceholder.show();
                    $tingkatSelect.css("color", "gray");
                }
            });

            $tingkatSelect.on("change", function() {
                if ($tingkatSelect.val()) {
                    $tingkatSelect.css("color", "black");
                }
            });

            // Placeholder handling for dropdown "kategori"
            const $kategoriSelect = $("#kategori");
            const $kategoriPlaceholder = $kategoriSelect.find("option.placeholder");

            $kategoriSelect.css("color", "gray");

            $kategoriSelect.on("focus", function() {
                $kategoriPlaceholder.hide();
                $kategoriSelect.css("color", "black");
            });

            $kategoriSelect.on("blur", function() {
                if (!$kategoriSelect.val()) {
                    $kategoriPlaceholder.show();
                    $kategoriSelect.css("color", "gray");
                }
            });

            $kategoriSelect.on("change", function() {
                if ($kategoriSelect.val()) {
                    $kategoriSelect.css("color", "black");
                }
            });

            // Form validation on submit
            $("#prestasiForm").on("submit", function(e) {
                e.preventDefault(); // Prevent default form submission

                let isValid = true;
                let firstErrorField = null; // Variable to store the first error field

                // List of input fields to validate
                const inputs = [{
                        id: "#nim",
                        errorId: "#error-nim",
                        labelSelector: "label[for='nim']"
                    },
                    {
                        id: "#nama_kompetisi",
                        errorId: "#error-nama_kompetisi",
                        labelSelector: "label[for='nama_kompetisi']"
                    },
                    {
                        id: "#kategori",
                        errorId: "#error-kategori",
                        labelSelector: "label[for='kategori']"
                    },
                    {
                        id: "#penyelenggara",
                        errorId: "#error-penyelenggara",
                        labelSelector: "label[for='penyelenggara']"
                    },
                    {
                        id: "#event",
                        errorId: "#error-event",
                        labelSelector: "label[for='event']"
                    },
                    {
                        id: "#peserta",
                        errorId: "#error-peserta",
                        labelSelector: "label[for='peserta']"
                    },
                    {
                        id: "#tingkat",
                        errorId: "#error-tingkat",
                        labelSelector: "label[for='tingkat']"
                    },
                    {
                        id: "#tanggal_mulai",
                        errorId: "#error-tanggal_mulai",
                        labelSelector: "label[for='tanggal_mulai']"
                    },
                    {
                        id: "#tanggal_selesai",
                        errorId: "#error-tanggal_selesai",
                        labelSelector: "label[for='tanggal_selesai']"
                    },
                    {
                        id: "#foto_kompetisi",
                        errorId: "#error-foto_kompetisi",
                        labelSelector: "label[for='foto_kompetisi']"
                    },
                    {
                        id: "#poster_kompetisi",
                        errorId: "#error-poster_kompetisi",
                        labelSelector: "label[for='poster_kompetisi']"
                    },
                    {
                        id: "#sertifikat",
                        errorId: "#error-sertifikat",
                        labelSelector: "label[for='sertifikat']"
                    },
                    {
                        id: "#surat_tugas",
                        errorId: "#error-surat_tugas",
                        labelSelector: "label[for='surat_tugas']"
                    }
                ];

                // Reset error states
                inputs.forEach(input => {
                    $(input.id).removeClass("border-red-500");
                    $(input.errorId).addClass("hidden");
                    $(input.labelSelector).removeClass("text-red-500");
                    $(input.labelSelector).addClass("text-gray-700");
                });

                // Validation for each input field
                inputs.forEach(input => {
                    const value = $(input.id).val().trim();
                    if (!value) {
                        isValid = false;
                        $(input.id).addClass("border-red-500");
                        $(input.errorId).removeClass("hidden");
                        $(input.labelSelector).removeClass("text-gray-700");
                        $(input.labelSelector).addClass("text-red-500");

                        // Set the first error field
                        if (!firstErrorField) {
                            firstErrorField = $(input.id);
                        }
                    }
                });

                // If all inputs are valid, proceed with form submission
                if (isValid) {
                    Swal.fire({
                        title: "Apakah anda sudah yakin?",
                        text: "Pastikan semua data yang diinput sudah benar.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "YES",
                        cancelButtonText: "NO",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData($("#prestasiForm")[0]);

                            $.ajax({
                                url: "inputProses.php",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    try {
                                        var jsonResponse = JSON.parse(response);
                                        if (jsonResponse.status === "success") {
                                            Swal.fire("Berhasil!", "Data berhasil disimpan.", "success");
                                            $("#prestasiForm")[0].reset();
                                        } else {
                                            Swal.fire("Kesalahan!", jsonResponse.message, "error");
                                        }
                                    } catch (error) {
                                        Swal.fire("Kesalahan!", "Gagal memproses respons dari server.", "error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire("Kesalahan!", "Terjadi kesalahan saat mengirim data: " + error, "error");
                                }
                            });
                        } else {
                            Swal.fire("Dibatalkan", "Silakan periksa inputan anda kembali.", "info");
                        }
                    });
                } else {
                    // Scroll to the first error field if validation fails
                    $('html, body').animate({
                        scrollTop: firstErrorField.offset().top - 100 // Scroll with some offset
                    }, 500); // Scroll duration
                }
            });
        });
    </script>
    <!-- JavaScript -->
    <script>
        // Fungsi untuk menangani perubahan input file
        function handleFileChange(fileInputId, fileNameDisplayId, defaultText) {
            // Elemen yang diperlukan
            const fileInput = document.getElementById(fileInputId);
            const fileNameDisplay = document.getElementById(fileNameDisplayId);
            // const errorMessage = document.getElementById(errorMessageId);

            // Event listener untuk menampilkan nama file
            fileInput.addEventListener("change", () => {
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name; // Ambil nama file
                    fileNameDisplay.textContent = fileName; // Tampilkan di UI
                    fileNameDisplay.classList.remove("text-gray-400"); // Ganti warna teks
                    fileNameDisplay.classList.add("text-black"); // Tambahkan warna hitam
                    // errorMessage.classList.add("hidden"); // Sembunyikan pesan error
                } else {
                    fileNameDisplay.textContent = defaultText; // Default teks jika file dihapus
                    fileNameDisplay.classList.remove("text-black"); // Hapus warna hitam
                    fileNameDisplay.classList.add("text-gray-400"); // Tambahkan warna abu-abu
                    // errorMessage.classList.remove("hidden"); // Tampilkan pesan error
                }
            });
        }

        // Menjalankan fungsi untuk setiap elemen unggahan file
        handleFileChange("foto_kompetisi", "file-foto", "Upload Foto Kompetisi");
        handleFileChange("poster_kompetisi", "file-poster", "Upload Poster Kompetisi");
        handleFileChange("sertifikat", "file-sertifikat", "Upload Sertifikat Kompetisi");
        handleFileChange("surat_tugas", "file-surat_tugas", "Upload Surat Tugas");
        handleFileChange("upload_karya", "file-karya", "Upload Karya");
    </script>
</body>

</html>