const platInput = document.getElementById('plat_nomor');
const warnaInput = document.getElementById('warna');
const tarifSelect = document.getElementById('id_tarif');
const statusEl = document.getElementById('status_kendaraan');
let debounceTimer;

platInput.addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    // Menghapus spasi dan strip sesuai logika Controller getKendaraan
    let platClean = this.value.replace(/[\s-]/g, '');
    
    if (platClean.length < 3) { 
        statusEl.classList.add('hidden'); 
        return; 
    }

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        fetch(`/petugas/transaksi/get-kendaraan/${platClean}`)
            .then(response => response.json())
            .then(data => {
                statusEl.classList.remove('hidden');
                if (data && data.plat_nomor) {
                    // Jika kendaraan ditemukan
                    warnaInput.value = data.warna;
                    statusEl.innerHTML = "<i class='fas fa-check-circle mr-1'></i> Terdaftar";
                    statusEl.className = "text-[8px] font-bold uppercase mt-1 px-2.5 py-1 rounded-lg bg-green-50 text-green-600 inline-block border border-green-100";
                    
                    // Auto-select Jenis Kendaraan
                    const options = tarifSelect.options;
                    for (let i = 0; i < options.length; i++) {
                        const jenis = options[i].getAttribute('data-jenis');
                        if (jenis && jenis.toLowerCase() === data.jenis_kendaraan.toLowerCase()) {
                            tarifSelect.selectedIndex = i; 
                            break;
                        }
                    }
                } else {
                    // Jika kendaraan baru
                    statusEl.innerHTML = "<i class='fas fa-plus-circle mr-1'></i> Baru";
                    statusEl.className = "text-[8px] font-bold uppercase mt-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 inline-block border border-blue-100";
                }
            })
            .catch(err => console.error("Gagal mengambil data kendaraan:", err));
    }, 500); 
});