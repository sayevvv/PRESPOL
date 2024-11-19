<?php 
session_start();
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
    
</head>
<body class="bg-white font-sans min-h-screen flex">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-2/6 bg-white h-full border-r border-r border-gray-200">
            <div class="flex items-center justify-center py-6">
                <i class="fas fa-trophy text-orange-500 text-4xl"></i>
                <span class="ml-2 text-xl font-bold ">prespol</span>
            </div>
            <nav class="mt-10">
                <ul>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-home"></i>
                            <span class="ml-4">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 bg-gray-200">
                            <i class="fas fa-trophy"></i>
                            <span class="ml-4">Tambah prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-list"></i>
                            <span class="ml-4">List Prestasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-user"></i>
                            <span class="ml-4">Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-file-alt"></i>
                            <span class="ml-4">Pengajuan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-2 px-8 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-cog"></i>
                            <span class="ml-4">Setelan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="w-4/5 p-10">
            <!-- Header -->
            <header class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold">Tambah Prestasi</h1>
            </header>
            <!-- Form -->
            <form class="space-y-4" action="" method="post" enctype="multipart/form-data">
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
                        <select id="kategori" name="juara" class="w-full p-3 border border-gray-300 rounded-lg appearance-none">
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
                    <label for="dospem" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 1</label>
                    <input type="text" id="dospem" name="dospem1" placeholder="Dospem" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="dospem" class="block text-sm font-medium text-gray-700">Dosen Pembimbing 2</label>
                    <input type="text" id="dospem" name="dospem2" placeholder="Dospem" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
            
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700">Tingkat Kompetisi</label>
                    <div class="relative">
                        <select id="tingkat" name="kategori" class="w-full p-3 border border-gray-300 rounded-lg appearance-none">
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
                    <input type="text" id="tanggal_mulai" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Select a date">
                </div>
            
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="text" id="tanggal_selesai" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Select a date">
                </div>
                <!-- Attachments Section -->
                <section>
                    <h2 class="text-xl font-bold mt-6 mb-3">Lampiran</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="foto_lomba" class="block text-sm font-medium text-gray-700">Foto Lomba</label>
                            <input type="file" id="foto_lomba" name="foto_lomba" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="flyer_lomba" class="block text-sm font-medium text-gray-700">Poster Lomba</label>
                            <input type="file" id="flyer_lomba" name="flyer_lomba" accept=".pdf,image/*"  class="w-full p-3 border border-gray-300 rounded-lg">
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
                            <input type="file" id="upload_karya" name="upload_karya" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </section>
                <!-- Submit Button -->
                <button type="submit" class="w-full p-3 bg-black text-white rounded-lg">Submit</button>
            </form>
        </main>
        <!-- Note Section -->
        <aside class="w-2/5 p-10 py-32">
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
    
</body>
</html>