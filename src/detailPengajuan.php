<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Admin.php';
include_once 'config/Database.php';
include_once 'classes/Auth.php';

Auth::checkLogin();

if($_SESSION['role'] != '1'){
    header('Location: home.php');
}

$user = new Admin();

$no_induk= $_SESSION['no_induk'];
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
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
        <h1 class="text-2xl font-bold mb-4">Detail Prestasi Pending</h1>
        <?php
        $id_pending = $_GET['id_pending'] ?? null;
        if ($id_pending) {
            $detail = $user->getPrestasiPendingDetail($id_pending);
        ?>
        
            
        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">
            <!-- Detail Kompetisi -->
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
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['nama_kategori']); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Juara</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['jenis_juara']); ?></p>
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
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['tanggal_mulai']->format('Y-m-d')); ?></p>
            </div>
            <div class="mb-4 border-b border-gray-200 pb-4">
                <p class="text-lg font-semibold text-gray-800"><strong>Tanggal Selesai</strong></p>
                <p class="text-gray-700"><?php echo htmlspecialchars($detail['tanggal_selesai']->format('Y-m-d')); ?></p>
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
        </div>

        <div class="mt-4">
            <form action="validate.php" method="POST" id="validationForm">
                <input type="hidden" name="id_pending" value="<?php echo $id_pending; ?>">
                <input type="hidden" name="no_induk" value="<?php echo $no_induk; ?>">
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

    </main>
    <!-- Script jQuery untuk AJAX -->
    <script>
    $(document).ready(function () {
        // Fungsi untuk menangani klik tombol Validasi atau Tolak
        $('#validBtn, #rejectBtn').on('click', function () {
            const isValidasi = $(this).attr('id') === 'validBtn';
            const statusValue = isValidasi ? 'valid' : 'tolak';
            const actionText = isValidasi ? 'Validasi' : 'Tolak';
            const confirmButtonColor = isValidasi ? '#28a745' : '#dc3545';

            // SweetAlert untuk konfirmasi
            Swal.fire({
                title: `Konfirmasi ${actionText}`,
                text: `Apakah Anda yakin ingin ${actionText.toLowerCase()} pengajuan ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, ${actionText}`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set nilai status dan kirim form jika dikonfirmasi
                    $('#statusInput').val(statusValue);
                    submitForm(); // Panggil fungsi untuk kirim data
                }
            });
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
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            window.location.href = 'daftarPengajuan.php'; // Redirect jika sukses
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error response:', xhr.responseText); // Debugging error
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
</script>
</body>
</html>


