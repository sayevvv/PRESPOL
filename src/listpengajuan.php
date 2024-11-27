<?php
session_start();

include_once 'classes/User.php';
include_once 'classes/Mahasiswa.php';

if($_SESSION['role'] != '3'){
    header('Location: home.php');
}

$user = new Mahasiswa();
?>

<html>
  <head>
    <title>Pengajuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-gradient-to-r from-white to-orange-100 min-h-screen flex flex-col lg:flex-row">
      <!-- Sidebar -->
      <aside class="bg-white p-6 lg:w-1/5 w-full border-b lg:border-b-0 lg:border-r">
      <?php 
        echo $user->sidebar();
      ?>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-6 pt-8">
        <div class="flex justify-between items-center bg-white p-6 rounded shadow-md">
          <h1 class="text-3xl font-bold text-gray-800">Pengajuan</h1>
          <div class="flex items-center">
            <span class="mr-4 text-gray-700 font-medium">Abdullah Shamil Basayev</span>
            <img
              alt="User profile picture"
              class="rounded-full border w-12 h-12"
              src="https://storage.googleapis.com/a1aa/image/1omPrB4FXfzRY6txh7LYvFaAdkpef5eBcUPobczTGMy9gmNPB.jpg"
            />
          </div>
        </div>
        <div class="mt-8">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Selesai</h2>
          <table class="w-full bg-white rounded shadow-md">
            <thead>
              <tr class="bg-orange-500 text-white">
                <th class="py-3 px-6 border">No</th>
                <th class="py-3 px-6 border">Ajuan Prestasi</th>
                <th class="py-3 px-6 border">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center hover:bg-gray-100 transition">
                <td class="py-3 px-6 border">1</td>
                <td class="py-3 px-6 border">Juara 1 Lomba Catur</td>
                <td class="py-3 px-6 border text-green-500">Disetujui</td>
              </tr>
              <tr class="text-center hover:bg-gray-100 transition">
                <td class="py-3 px-6 border">2</td>
                <td class="py-3 px-6 border">Finalis Hackathon</td>
                <td class="py-3 px-6 border text-yellow-500">Menunggu</td>
              </tr>
              <tr class="text-center hover:bg-gray-100 transition">
                <td class="py-3 px-6 border">3</td>
                <td class="py-3 px-6 border">Juara Harapan Lomba Desain</td>
                <td class="py-3 px-6 border text-red-500">Ditolak</td>
              </tr>
            </tbody>
          </table>
      </main>
    </div>
  </body>
</html>