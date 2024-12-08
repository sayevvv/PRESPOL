<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

$db = new Database();

if($_SESSION['role'] == '1'){
    include_once 'classes/Admin.php';
    $user = new Admin();
} else if($_SESSION['role'] == '2'){
    include_once 'classes/Kajur.php';
    $user = new Kajur();
} else if($_SESSION['role'] == '3'){
    include_once 'classes/Mahasiswa.php';
    $user = new Mahasiswa();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prestasi Pending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
        body {
        background: url('img/homepageGradient.png') no-repeat center center fixed; /* Fixed background */
        background-size: cover; /* Ensures the image covers the entire area */
        flex: 1; /* Makes the main content expand to fill the space */
        }
    </style>
<body class="bg-gray-100 min-h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="bg-white p-6 lg:w-1/5 h-screen fixed top-0 left-0 border-r">
    <?php 
        echo $user->sidebar();
    ?>
    </aside>
    
    <!-- Main Content -->
    <main class="ml-[20%] w-[80%] p-8"> <!-- Added pt-8 for top padding -->
        <!-- Top Navigation Section -->
        <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Detail Prestasi</h1>
        <?php
        $id_prestasi = $_GET['id_prestasi'] ?? null;
        if ($id_prestasi) {
            $detail = $user->getPrestasiDetail($id_prestasi);
        ?>
        <!-- CARD Detail Prestasi -->
        <section class="flex justify-between items-center bg-gradient-to-r from-orange-500 to-orange-400 text-white px-6 py-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 mb-6">
            <p class="text-2xl font-bold tracking-wide"> <?php echo htmlspecialchars($detail['juara']);?>
                                                    <?php echo htmlspecialchars($detail['nama_kompetisi']);?>
                                                    <?php echo htmlspecialchars($detail['kategori']);?></p>
            <div>
                <p class="text-lg"><?php echo htmlspecialchars($detail['event']);?></p>
                <p class="text-md opacity-80"><?php echo htmlspecialchars($detail['penyelenggara'])?></p>
            </div>
        </section>
            
        <div id="detailView" class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
            <!-- Detail Kompetisi -->
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Nama Mahasiswa</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['nama mahasiswa']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Nama Kompetisi</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['nama_kompetisi']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Penyelenggara</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['penyelenggara']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Event</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['event']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Kategori</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['kategori']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Juara</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['juara']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Jumlah Peserta</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['jumlah_peserta']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Dosen Pembimbing 1</strong></p>
                <p class="text-gray-700"><?php echo !empty($detail['dosen_pembimbing_1']) ? htmlspecialchars($detail['dosen_pembimbing_1']) : '-'; ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Dosen Pembimbing 2</strong></p>
                <p class="text-gray-700"><?php echo !empty($detail['dosen_pembimbing_2']) ? htmlspecialchars($detail['dosen_pembimbing_2']) : '-'; ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Tanggal Mulai</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['tanggal_mulai']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Tanggal Selesai</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['tanggal_selesai']); ?></p>
            </div>
            <div class="mb-6 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Foto Kompetisi</strong></p>
                <img src="<?php echo htmlspecialchars($detail['foto_kompetisi']); ?>" alt="Foto Kompetisi" class="max-w-full mt-4 rounded-lg shadow-md">
            </div>
            <div class="mb-6 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Poster Kompetisi</strong></p>
                <?php if (strtolower(pathinfo($detail['flyer'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                    <a href="<?php echo htmlspecialchars($detail['flyer']); ?>" target="_blank" class="text-blue-500 hover:underline">Lihat Poster (PDF)</a>
                <?php else: ?>
                    <img src="<?php echo htmlspecialchars($detail['flyer']); ?>" alt="Poster Kompetisi" class="max-w-full mt-4 rounded-lg shadow-md">
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <p class="text-lg font-semibold text-gray-800"><strong>Karya Kompetisi</strong></p>
                <?php if (!empty($detail['karya_kompetisi'])): ?>
                    <a href="<?php echo htmlspecialchars($detail['karya_kompetisi']); ?>" target="_blank" class="text-blue-500 hover:underline">Lihat Karya</a>
                <?php else: ?>
                    <p class="text-gray-700">-</p>
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <p class="text-lg font-semibold text-gray-800"><strong>Sertifikat Kompetisi</strong></p>
                <a href="<?php echo htmlspecialchars($detail['sertifikat']); ?>" target="_blank" class="text-blue-500 hover:underline">Lihat Sertifikat (PDF)</a>
            </div>
            <div class="mb-6">
                <p class="text-lg font-semibold text-gray-800"><strong>Surat Tugas</strong></p>
                <a href="<?php echo htmlspecialchars($detail['surat_tugas']); ?>" target="_blank" class="text-blue-500 hover:underline">Lihat Surat Tugas (PDF)</a>
            </div>
            <?php 
                if ($user instanceof Admin): ?>
                    <button id="editBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md mt-4">Edit</button>
            <?php endif; ?>
        </div>

            <?php if ($user instanceof Admin): ?>
                <!-- Edit Form -->
            <div id="editForm" class="bg-white p-6 rounded-lg shadow-lg border border-gray-300 hidden">
                <form action="UpdatePrestasi.php" method="POST" id="editPrestasiForm" enctype="multipart/form-data">
                    <input type="hidden" name="id_prestasi" value="<?php echo $id_prestasi; ?>">
                    <div class="mb-4">
                        <label for="nim_mahasiswa" class="block font-semibold">NIM Mahasiswa</label>
                        <input type="text" id="nim_mahasiswa" name="nim" value="<?php echo htmlspecialchars($detail['nim']); ?>" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="nama_kompetisi" class="block font-semibold">Nama Kompetisi</label>
                        <input type="text" id="nama_kompetisi" name="nama_kompetisi" value="<?php echo htmlspecialchars($detail['nama_kompetisi']); ?>" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="penyelenggara" class="block font-semibold">Penyelenggara</label>
                        <input type="text" id="penyelenggara" name="penyelenggara" value="<?php echo htmlspecialchars($detail['penyelenggara']); ?>" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="event" class="block font-semibold">Event</label>
                        <input type="text" id="event" name="event" value="<?php echo htmlspecialchars($detail['event']); ?>" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="kategori" class="block font-semibold">Kategori</label>
                        <select id="kategori" name="id_kategori" class="w-full border rounded-md p-2">
                            <option value="1" <?php echo ($detail['kategori'] == 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
                            <option value="2" <?php echo ($detail['kategori'] == 'Nasional') ? 'selected' : ''; ?>>Nasional</option>
                            <option value="3" <?php echo ($detail['kategori'] == 'Regional') ? 'selected' : ''; ?>>Regional</option>
                            <option value="4" <?php echo ($detail['kategori'] == 'Lokal') ? 'selected' : ''; ?>>Lokal</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="juara" class="block font-semibold">Juara</label>
                        <select id="juara" name="id_juara" class="w-full border rounded-md p-2">
                            <option value="1" <?php echo ($detail['juara'] == 'Juara 1') ? 'selected' : ''; ?>>Juara 1</option>
                            <option value="2" <?php echo ($detail['juara'] == 'Juara 2') ? 'selected' : ''; ?>>Juara 2</option>
                            <option value="3" <?php echo ($detail['juara'] == 'Juara 3') ? 'selected' : ''; ?>>Juara 3</option>
                            <option value="4" <?php echo ($detail['juara'] == 'Harapan 1') ? 'selected' : ''; ?>>Harapan 1</option>
                            <option value="5" <?php echo ($detail['juara'] == 'Harapan 2') ? 'selected' : ''; ?>>Harapan 2</option>
                            <option value="6" <?php echo ($detail['juara'] == 'Harapan 3') ? 'selected' : ''; ?>>Harapan 3</option>
                            <option value="7" <?php echo ($detail['juara'] == 'Best Of') ? 'selected' : ''; ?>>Best Of</option>
                            <option value="8" <?php echo ($detail['juara'] == 'Finalis') ? 'selected' : ''; ?>>Finalis</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="jumlah_peserta" class="block font-semibold">Jumlah Peserta</label>
                        <input type="text" id="jumlah_peserta" name="jumlah_peserta" value="<?php echo htmlspecialchars($detail['jumlah_peserta']); ?>" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="dosen_pembimbing_2" class="block font-semibold">Dosen Pembimbing 1</label>
                        <?php if($detail['dosen_pembimbing_1'] != NULL): ?>
                            <input type="text" id="dosen_pembimbing_1" name="dosen_pembimbing_1" 
                                value="<?php echo htmlspecialchars($detail['dosen_pembimbing_1']); ?>" 
                                class="w-full border rounded-md p-2">
                        <?php else: ?>
                            <input type="text" id="dosen_pembimbing_1" name="dosen_pembimbing_1" class="w-full border rounded-md p-2">
                        <?php endif ?>
                    </div>
                    <div class="mb-4">
                        <label for="dosen_pembimbing_2" class="block font-semibold">Dosen Pembimbing 2</label>
                        <?php if($detail['dosen_pembimbing_2'] != NULL): ?>
                            <input type="text" id="dosen_pembimbing_2" name="dosen_pembimbing_2" 
                                value="<?php echo htmlspecialchars($detail['dosen_pembimbing_2']); ?>" 
                                class="w-full border rounded-md p-2">
                        <?php else: ?>
                            <input type="text" id="dosen_pembimbing_2" name="dosen_pembimbing_2" class="w-full border rounded-md p-2">
                        <?php endif ?>
                    </div>
                    <div class="mb-4">
                        <label for="foto_lomba" class="block font-semibold">Foto Lomba</label>
                        <input type="file" id="foto_lomba" name="foto_kompetisi" accept="image/*" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="flyer_lomba" class="block font-semibold">Poster Lomba</label>
                        <input type="file" id="flyer_lomba" name="flyer" accept=".pdf,image/*" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="sertifikat" class="block font-semibold">Sertifikat</label>
                        <input type="file" id="sertifikat" name="sertifikat" accept=".pdf" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="surat_tugas" class="block font-semibold">Surat Tugas</label>
                        <input type="file" id="surat_tugas" name="surat_tugas" accept=".pdf" class="w-full border rounded-md p-2">
                    </div>
                    <div class="mb-4">
                        <label for="surat_tugas" class="block font-semibold">Karya Kompetisi</label>
                        <input type="file" id="karya_kompetisi" name="karya_kompetisi" class="w-full border rounded-md p-2">
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Simpan</button>
                        <button type="button" id="cancelEdit" class="bg-gray-600 text-white px-4 py-2 rounded-md">Batal</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        <?php } else { ?>
        <p class="text-red-600">ID tidak ditemukan!</p>
        <?php } ?>
    </div>

    </main>
    <!-- Script jQuery untuk AJAX -->
    <script>
    $(document).ready(function () {
        // Handle Edit Button Click
        $('#editBtn').on('click', function () {
            $('#detailView').hide();
            $('#editForm').removeClass('hidden');
        });

        // Handle Cancel Button Click
        $('#cancelEdit').on('click', function () {
            $('#editForm').addClass('hidden');
            $('#detailView').show();
        });
    });
    </script>
</body>
</html>


