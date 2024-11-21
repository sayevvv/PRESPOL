<?php 
session_start();
include_once 'classes/User.php';
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

if($_SESSION['role'] == '2'){
    header('Location: home.php');
}

$user = null;
    
    if($_SESSION['role'] == '1'){
        include_once 'classes/Admin.php';
        $user = new Admin();
    } else if($_SESSION['role'] == '3'){
        include_once 'classes/Mahasiswa.php';
        $user = new Mahasiswa();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Prestasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- jQuery and jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <style>
        body {
        background: url('img/homepageGradient.png') no-repeat center center fixed; /* Fixed background */
        background-size: cover; /* Ensures the image covers the entire area */
        flex: 1; /* Makes the main content expand to fill the space */
        }

        main {
            margin-left: 280px;
        }
        input, #kategori, #tingkat {
            background: none;
        }
        select, select option {
            color: black; /* Ensures all text in dropdown stays black */
        }
        select:invalid {
             color: gray; /* Placeholder remains gray */
        }
</style>
</head>
<body class="bg-white font-sans min-h-screen flex">
    <div class="flex w-4/5">
        <!-- Sidebar -->
        <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r min-h-screen fixed">
        <?php 
            echo $user->sidebar();
        ?>
        </aside>
        <!-- Main Content -->
        <main class="w-4/5 p-10">
            <!-- Header -->
            <header class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold">Tambah Prestasi</h1>
            </header>
            <!-- Form -->
            <form id="prestasiForm" class="space-y-4" action="InputProses.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" placeholder="NIM" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="nama_kompetisi" class="block text-sm font-medium text-gray-700">Nama Kompetisi</label>
                    <input type="text" id="nama_kompetisi" name="nama_kompetisi" placeholder="Nama Kompetisi" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori Juara</label>
                    <div class="relative">
                        <select id="kategori" name="id_juara" class="w-full p-3 border border-gray-300 rounded-lg appearance-none text-gray-400">
                            <option value="" disabled selected hidden>Pilih Kategori</option>
                            <option value="1">Juara 1</option>
                            <option value="2">Juara 2</option>
                            <option value="3">Juara 3</option>
                            <option value="4">Harapan 1</option>
                            <option value="5">Harapan 2</option>
                            <option value="6">Harapan 3</option>
                            <option value="7">Lainnya</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>
            
                <div>
                    <label for="penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                    <input type="text" id="penyelenggara" name="penyelenggara" placeholder="Penyelenggara" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                    <input type="text" id="event" name="event" placeholder="Event" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="dospem1" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 1</label>
                    <input type="text" id="dospem1" name="dosen_pembimbing_1" placeholder="Dosen Pembimbing" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="dospem2" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 2</label>
                    <input type="text" id="dospem2" name="dosen_pembimbing_2" placeholder="Dosen Pembimbing" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="peserta" class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                    <input type="text" id="peserta" name="jumlah_peserta" placeholder="Jumlah Peserta" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700">Tingkat Kompetisi</label>
                    <div class="relative">
                        <select id="tingkat" name="id_kategori" class="w-full p-3 border border-gray-300 rounded-lg appearance-none text-gray-400">
                            <option value="" disabled selected hidden>Pilih Kategori</option>
                            <option value="1">Internasional</option>
                            <option value="2">Nasional</option>
                            <option value="3">Regional</option>
                            <option value="4">Lokal</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                
            
                <div>
                    <h2 class="text-xl font-bold mt-6 mb-3">Waktu Pelaksanaan</h2>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="text" id="tanggal_mulai" name="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Select a date">
                </div>
            
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="text" id="tanggal_selesai" name="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Select a date">
                </div>
                <!-- Attachments Section -->
                <section>
                    <h2 class="text-xl font-bold mt-6 mb-3">Lampiran</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="foto_lomba" class="block text-sm font-medium text-gray-700">Foto Lomba</label>
                            <input type="file" id="foto_lomba" name="foto_kompetisi" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="flyer_lomba" class="block text-sm font-medium text-gray-700">Poster Lomba</label>
                            <input type="file" id="flyer_lomba" name="flyer" accept=".pdf,image/*"  class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="sertifikat" class="block text-sm font-medium text-gray-700">Sertifikat</label>
                            <input type="file" id="sertifikat" name="sertifikat" accept=".pdf" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="surat_tugas" class="block text-sm font-medium text-gray-700">Surat Tugas</label>
                            <input type="file" id="surat_tugas" name="surat_tugas" accept=".pdf" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="upload_karya" class="block text-sm font-medium text-gray-700">Upload Karya</label>
                            <input type="file" id="upload_karya" name="karya_kompetisi" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </section>
                <!-- Submit Button -->
                <button type="submit" class="w-full p-3 bg-black text-white rounded-lg">Submit</button>
            </form>
        </main>
        <!-- Note Section -->
        <aside class="w-1/5 p-10 py-32 fixed right-0">
            <div class="bg-white p-6 border border-gray-300 rounded-lg">
                <h2 class="text-xl font-bold text-orange-500">Note!</h2>
                <p class="mt-4 text-gray-700">Lorem Ipsum dolor Lorem Ipsum dolorLorem Ipsum dolorLorem Ipsum dolor</p>
                <p class="mt-4 text-gray-700">Lorem Ipsum dolorLorem Ipsum dolorLorem Ipsum dolorLorem Ipsum dolor</p>
            </div>
        </aside>
    </div>
    <script>
        $(function () {
            $("#tanggal_mulai").datepicker({
                dateFormat: "dd-mm-yy", // Adjust date format as needed
                showAnim: "slideDown", // Animation for opening the calendar
                changeMonth: true,    // Enable month dropdown
                changeYear: true,     // Enable year dropdown
                showButtonPanel: true, // Optional: Add "Today" and "Done" buttons
                closeText: "Done",         // Text for the Done button
                currentText: "Today",      // Text for the Today button
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        // Add custom functionality to the "Today" button
                        $(inst.dpDiv)
                            .find(".ui-datepicker-current")
                            .off("click")
                            .on("click", function () {
                                const today = new Date();
                                $("#tanggal_mulai").datepicker("setDate", today);
                            });
                    }, 1);
                }
            });
            $("#tanggal_selesai").datepicker({
                dateFormat: "dd-mm-yy", // Adjust date format as needed
                showAnim: "slideDown", // Animation for opening the calendar
                changeMonth: true,    // Enable month dropdown
                changeYear: true,     // Enable year dropdown
                showButtonPanel: true, // Optional: Add "Today" and "Done" buttons
                closeText: "Done",         // Text for the Done button
                currentText: "Today",      // Text for the Today button
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        // Add custom functionality to the "Today" button
                        $(inst.dpDiv)
                            .find(".ui-datepicker-current")
                            .off("click")
                            .on("click", function () {
                                const today = new Date();
                                $("#tanggal_selesai").datepicker("setDate", today);
                            });
                    }, 1);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#prestasiForm").on("submit", function (e) {
                e.preventDefault(); // Mencegah form submit secara default

                // Ambil data dari form
                var formData = new FormData(this);

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: "InputProses.php", // URL tujuan pengiriman
                    type: "POST", // Metode pengiriman
                    data: formData, // Data dari form
                    processData: false, // Jangan proses data (karena menggunakan FormData)
                    contentType: false, // Jangan tetapkan jenis konten (otomatis dengan FormData)
                    success: function (response) {
                        // Tampilkan notifikasi sukses atau error berdasarkan respons server
                        try {
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === "success") {
                                alert("Data berhasil disimpan!");
                                console.log(jsonResponse.message); // Log respons sukses
                                // Reset form setelah berhasil
                                $("#prestasiForm")[0].reset();
                            } else {
                                alert("Terjadi kesalahan: " + jsonResponse.message);
                                console.error(jsonResponse.message); // Log respons error
                            }
                        } catch (error) {
                            alert("Gagal memproses respons dari server.");
                            console.error("Parsing error:", error);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Tangani error pada proses AJAX
                        alert("Terjadi kesalahan saat mengirim data: " + error);
                        console.error("Error details:", xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Change text color of select inputs when an option is chosen
        $('#kategori, #tingkat').on('change', function () {
            if ($(this).val()) {
                $(this).css('color', '#000'); // Set text color to black
            } else {
                $(this).css('color', '#9CA3AF'); // Reset to default gray
            }
        });

        // Initial check for default color
        $('#kategori, #tingkat').each(function () {
            if ($(this).val()) {
                $(this).css('color', '#000'); // Set text color to black if value is preselected
            } else {
                $(this).css('color', '#9CA3AF'); // Default gray for placeholder
            }
        });
    });
</script>

</body>
</html>