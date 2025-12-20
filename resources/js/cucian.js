document.addEventListener('DOMContentLoaded', () => {
    const hargaMap = {4:5000, 7:8000, 9:11000, 12:14000, 15:18000, 20:25000};
    const beratSelect = document.getElementById('berat');
    const hargaInput = document.getElementById('harga');
    const btnSimpan = document.getElementById('btnSimpan');
    const alertSuccess = document.getElementById('alertSuccess');

    if(beratSelect && hargaInput && btnSimpan && alertSuccess) {
        beratSelect.addEventListener('change', function() {
            const berat = this.value;
            hargaInput.value = hargaMap[berat] ? hargaMap[berat] : '';
        });

        btnSimpan.addEventListener('click', function() {
            if(!document.getElementById('namaPelanggan').value || !document.getElementById('tanggalMasuk').value || !beratSelect.value) {
                alert('Silakan lengkapi semua field!');
                return;
            }
            alertSuccess.style.display = 'block';
            setTimeout(() => {
                alertSuccess.style.display = 'none';
                document.getElementById('cucianForm').reset();
                hargaInput.value = '';
                document.getElementById('status').value = 'Belum Selesai';
            }, 2000);
        });
    }
});
