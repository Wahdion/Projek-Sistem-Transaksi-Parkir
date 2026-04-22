<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk_{{ str_replace(' ', '', $transaksi->kendaraan->plat_nomor) }}_{{ date('YmdHi') }}</title>
    <style>
        /* Pengaturan Kertas Thermal/A5 */
        @page { 
            margin: 0; 
            size: auto; 
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 140mm;
            margin: 20px auto;
            padding: 30px;
            color: #000;
            line-height: 1.5;
            font-size: 14px;
            background-color: #fff;
            border: 1px solid #eee;
            box-sizing: border-box;
        }

        .brand-section { text-align: center; margin-bottom: 25px; }
        .brand-name { font-size: 2.2rem; font-weight: 800; letter-spacing: 3px; margin: 0; line-height: 1.1; }
        .brand-sub { font-size: 13px; font-weight: bold; letter-spacing: 1px; margin-top: 5px; text-transform: uppercase; }
        .location { font-size: 11px; margin-top: 2px; }

        .divider { border-top: 2px solid #000; margin: 15px 0; position: relative; }
        .divider::after { content: "• • •"; position: absolute; top: -11px; left: 50%; transform: translateX(-50%); background: #fff; padding: 0 15px; font-size: 12px; }

        .line { border-top: 1px dashed #000; margin: 12px 0; }
        .flex { display: flex; justify-content: space-between; align-items: baseline; }
        .bold { font-weight: bold; }

        .plat-container { text-align: center; margin: 20px 0; }
        .plat-label { font-size: 11px; letter-spacing: 2px; margin-bottom: 8px; }
        .plat-box { font-size: 32px; font-weight: bold; border: 3px solid #000; display: inline-block; padding: 10px 25px; margin-bottom: 10px; line-height: 1; }
        .vehicle-details { font-size: 15px; text-transform: uppercase; }

        .total-row { font-size: 22px; margin: 15px 0; padding: 5px 0; border-top: 1px solid #000; border-bottom: 1px solid #000; }
        .status-badge { text-align: center; border: 2px solid #000; padding: 12px; margin-top: 15px; font-weight: bold; font-size: 16px; letter-spacing: 3px; background-color: #f8f8f8; }

        .entry-ticket-box { text-align: center; border: 2px dashed #000; padding: 20px; margin-top: 10px; background-color: #fafafa; }

        @media print {
            body { width: 100%; border: none; margin: 0; padding: 10mm; }
            .no-print { display: none !important; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="brand-section">
        <h1 class="brand-name">YONPARKIR</h1>
        <div class="brand-sub">Sistem Parkir Digital & Efisien</div>
        <div class="location">Bali, Indonesia</div>
    </div>

    <div class="divider"></div>

    <div class="flex">
        <span>No. Tiket:</span>
        <span class="bold">#{{ str_pad($transaksi->id_parkir, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Nama Petugas hanya muncul jika sudah Checkout (Status Keluar) --}}
    @if($transaksi->status == 'keluar')
        <div class="flex">
            <span>Petugas:</span>
            <span class="bold">{{ strtoupper($transaksi->user->nama ?? 'Staff') }}</span>
        </div>
    @endif

    <div class="line"></div>

    <div class="plat-container">
        <div class="plat-label">PLAT NOMOR</div>
        <div class="plat-box">
            {{ strtoupper($transaksi->kendaraan->plat_nomor) }}
        </div>
        <div class="vehicle-details">
            <div class="bold">{{ $transaksi->tarif->jenis_kendaraan }}</div>
            <div style="font-size: 12px;">WARNA: {{ strtoupper($transaksi->kendaraan->warna) }}</div>
        </div>
    </div>

    <div class="line"></div>

    <div class="flex">
        <span>Waktu Masuk:</span>
        <span>{{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</span>
    </div>

    @if($transaksi->status == 'keluar')
        {{-- BAGIAN CHECK-OUT --}}
        <div class="flex">
            <span>Waktu Keluar:</span>
            <span>{{ $transaksi->waktu_keluar->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex">
            <span>Durasi:</span>
            <span>{{ $transaksi->durasi_jam }} JAM</span>
        </div>

        <div class="line"></div>

        <div class="flex bold total-row">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</span>
        </div>

        <div class="status-badge">
            LUNAS / PAID
        </div>

        <div class="line"></div>

        <div style="text-align: center; font-size: 12px; margin-top: 25px;">
            <div class="bold" style="letter-spacing: 1px; font-size: 14px;">TERIMA KASIH ATAS KUNJUNGAN ANDA</div>
            <div style="margin-top: 10px;">
                <span class="bold">- YonParkir -</span>
            </div>
        </div>
    @else
        {{-- BAGIAN CHECK-IN --}}
        <div class="line"></div>
        <div class="entry-ticket-box">
            <div class="bold" style="font-size: 16px; letter-spacing: 2px; margin-bottom: 5px;">*** TIKET MASUK ***</div>
            <div style="font-size: 13px;">
                Tarif: Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}/jam
            </div>
            <div style="font-size: 11px; margin-top: 10px; border-top: 1px solid #000; padding-top: 5px;">
                AREA PARKIR: <span class="bold">{{ strtoupper($transaksi->area->nama_area) }}</span>
            </div>
        </div>
        
        <div class="line"></div>

        <div style="text-align: center; font-size: 12px; margin-top: 20px;">
            <div class="bold" style="letter-spacing: 1px;">PEMBERITAHUAN</div>
            <div style="margin-top: 5px; line-height: 1.4;">
                Simpan karcis masuk anda untuk melakukan transaksi nanti.<br>
                Kehilangan karcis akan dikenakan denda!<br>
                <span class="bold">- YonParkir -</span>
            </div>
        </div>
    @endif

    <div style="height: 60px;"></div>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 500);
        }
    </script>
</body>
</html>