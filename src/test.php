<script>
    // Handle Pengajuan Button
    document.getElementById('btnPengajuan').addEventListener('click', function () {
        document.getElementById('tablePengajuan').classList.remove('hidden');
        document.getElementById('tableDilayani').classList.add('hidden');
    });

    // Handle Dilayani Button
    document.getElementById('btnDilayani').addEventListener('click', function () {
        document.getElementById('tablePengajuan').classList.add('hidden');
        document.getElementById('tableDilayani').classList.remove('hidden');
    });
</script>