// --- LOGIKA OTOMATIS CETAK STRUK
if (window.downloadStrukUrl) {
    window.open(window.downloadStrukUrl, "_blank");
}

// --- LIVE SEARCH ---
const searchInput = document.getElementById('search-input');
const tableBody = document.getElementById('table-body');
const searchIcon = document.getElementById('search-icon-wrapper');
const searchSpinner = document.getElementById('search-spinner');
const searchStatus = document.getElementById('search-status');

let timeout = null;

if (searchInput) {
    searchInput.addEventListener('input', function () {
        searchIcon.classList.add('hidden');
        searchSpinner.classList.remove('hidden');

        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const keyword = searchInput.value;
            // Pastikan variabel 'indexRoute' didefinisikan di Blade
            fetch(`${window.indexRoute}?search=${keyword}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    tableBody.innerHTML = html;
                    searchStatus.innerHTML = keyword ?
                        `Hasil pencarian: <span class="text-blue-600 font-bold">"${keyword}"</span>` :
                        `Menampilkan seluruh kendaraan yang berstatus <span class="text-blue-600 font-bold">'masuk'</span>`;

                    searchIcon.classList.remove('hidden');
                    searchSpinner.classList.add('hidden');
                });
        }, 400);
    });
}

// --- KONFIRMASI CHECKOUT ---
window.konfirmasiCheckout = function (id, plat, waktuMasukStr, tarifPerJam) {
    const sekarang = new Date();
    const masuk = new Date(waktuMasukStr);
    const selisih = sekarang - masuk;

    let durasiJam = Math.ceil(selisih / (1000 * 60 * 60));
    if (durasiJam <= 0) durasiJam = 1;

    const totalBiaya = durasiJam * tarifPerJam;
    const formatBiaya = new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', maximumFractionDigits: 0
    }).format(totalBiaya);

    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: `
            <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">Total Biaya <span class="text-black font-extrabold"> "${plat}"</span></p>
                <p class="text-4xl font-black text-emerald-600 mb-4">${formatBiaya}</p>
                <div class="grid grid-cols-2 gap-2 pt-4 border-t border-dashed border-slate-200">
                    <div class="text-left">
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Durasi</p>
                        <p class="text-sm font-black text-slate-700">${durasiJam} Jam</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Tarif/Jam</p>
                        <p class="text-sm font-black text-slate-700">Rp ${tarifPerJam.toLocaleString('id-ID')}</p>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'CHECKOUT',
        confirmButtonColor: '#10b981',
        cancelButtonText: 'KEMBALI',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-[2.5rem] p-6',
            confirmButton: 'rounded-2xl px-6 py-4 font-black text-[11px]',
            cancelButton: 'rounded-2xl px-6 py-4 font-bold text-[11px]'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-checkout-' + id).submit();
        }
    });
}