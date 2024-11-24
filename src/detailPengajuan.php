<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prestasi Pending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Detail Prestasi Pending</h1>
        <?php
        include_once 'classes/User.php';
        include_once 'classes/Admin.php';
        include_once 'config/Database.php';

        $db = new Database();
        $validasiAdmin = new Admin($db);

        $id_pending = $_GET['id_pending'] ?? null;
        if ($id_pending) {
            $detail = $validasiAdmin->getPrestasiPendingDetail($id_pending);
        ?>
        

        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>Nama Kompetisi:</strong> <?php echo htmlspecialchars($detail['nama_kompetisi']); ?></p>
            <p><strong>Penyelenggara:</strong> <?php echo htmlspecialchars($detail['penyelenggara']); ?></p>
            <p><strong>Event:</strong> <?php echo htmlspecialchars($detail['event']); ?></p>
            <p><strong>Kategori:</strong> <?php echo htmlspecialchars($detail['nama_kategori']); ?></p>
            <p><strong>Juara:</strong> <?php echo htmlspecialchars($detail['jenis_juara']); ?></p>
            <p><strong>Dosen Pembimbing 1:</strong> <?php echo !empty($detail['dosen_pembimbing_1']) ? htmlspecialchars($detail['dosen_pembimbing_1']) : '-'; ?></p>
            <p><strong>Dosen Pembimbing 2:</strong> <?php echo !empty($detail['dosen_pembimbing_2']) ? htmlspecialchars($detail['dosen_pembimbing_2']) : '-'; ?></p>
            <p><strong>Tanggal Mulai:</strong> <?php echo htmlspecialchars($detail['tanggal_mulai']->format('Y-m-d')); ?></p>
            <p><strong>Tanggal Selesai:</strong> <?php echo htmlspecialchars($detail['tanggal_selesai']->format('Y-m-d')); ?></p>
            <p><strong>Foto Kompetisi:</strong></p>
            <img src="<?php echo htmlspecialchars($detail['foto_kompetisi']); ?>" alt="Foto Kompetisi" class="max-w-md mt-4">
            <p><strong>Poster Kompetisi:</strong></p>
            <?php if (strtolower(pathinfo($detail['flyer'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                <a href="<?php echo htmlspecialchars($detail['flyer']); ?>" target="_blank" class="text-blue-600">Lihat Poster (PDF)</a>
            <?php else: ?>
                <img src="<?php echo htmlspecialchars($detail['flyer']); ?>" alt="Poster Kompetisi" class="max-w-md mt-4">
            <?php endif; ?>

            <p><strong>Karya Kompetisi:</strong></p>
            <p>
                <?php if (!empty($detail['karya_kompetisi'])): ?>
                    <a href="<?php echo htmlspecialchars($detail['karya_kompetisi']); ?>" target="_blank" class="text-blue-600">Lihat Karya</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </p>
            <p><strong>Sertifikat Kompetisi:</strong></p>
            <a href="<?php echo htmlspecialchars($detail['sertifikat']); ?>" target="_blank" class="text-blue-600">Lihat Sertifikat (PDF)</a>
            <p><strong>Surat Tugas:</strong></p>
            <a href="<?php echo htmlspecialchars($detail['surat_tugas']); ?>" target="_blank" class="text-blue-600">Lihat Surat Tugas (PDF)</a>
        </div>

        <div class="mt-4">
            <form action="validate.php" method="POST" id="validationForm">
                <input type="hidden" name="id_pending" value="<?php echo $id_pending; ?>">
                <input type="hidden" id="statusInput" name="status" value="">
                <textarea name="deskripsi" rows="4" class="w-full border rounded-md p-2 mb-4" placeholder="Tambahkan deskripsi..."></textarea>
                <div class="flex space-x-2">
                    <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-md" id="validBtn">Validasi</button>
                    <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md" id="rejectBtn">Tolak</button>
                </div>
            </form>
        </div>

        <?php } else { ?>
        <p class="text-red-600">ID tidak ditemukan!</p>
        <?php } ?>
    </div>
    

    <!-- Script jQuery untuk AJAX -->
    <script>
    $(document).ready(function () {
        // Fungsi untuk menangani klik tombol Validasi atau Tolak
        $('#validBtn, #rejectBtn').on('click', function () {
            const statusValue = $(this).attr('id') === 'validBtn' ? 'valid' : 'tolak';
            $('#statusInput').val(statusValue); // Set nilai status sesuai tombol
            submitForm(); // Panggil fungsi untuk kirim data
        });

        // Fungsi untuk mengirim form dengan AJAX
        function submitForm() {
            const formData = $('#validationForm').serialize(); // Serialisasi data form
            $.ajax({
                type: 'POST',
                url: 'validate.php', // Endpoint tujuan
                data: formData,
                dataType: 'json',
                success: function (response) {
                    // Menampilkan pesan berdasarkan respons
                    if (response.status === 'success') {
                        alert(response.message); // Pesan sukses
                        window.location.href = 'daftarPengajuanAdmin.php'; // Redirect jika sukses
                    } else {
                        alert(response.message); // Pesan error
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error response:', xhr.responseText); // Debugging error
                    alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
                }
            });
        }
    });
    </script>
</body>
</html>


