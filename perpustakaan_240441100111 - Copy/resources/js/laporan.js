
document.addEventListener('DOMContentLoaded', function () {
    const tanggalMulai = document.getElementById('tanggal-mulai');
    const tanggalSelesai = document.getElementById('tanggal-selesai');
    const tombolFilter = document.getElementById('tombol-filter');
    const tombolReset = document.getElementById('tombol-reset');
    const tombolCetak = document.getElementById('tombol-cetak');

    const pesan = document.getElementById('pesan-laporan');
    const daftarBuku = document.getElementById('daftar-rekap-buku');
    const daftarTransaksi = document.getElementById('daftar-transaksi');

    let dataLaporan = null;

    function rupiah(nilai) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(nilai || 0);
    }

    function tanggal(value) {
        if (!value) return '-';
        const [tahun, bulan, hari] = value.split('-');
        return `${hari}-${bulan}-${tahun}`;
    }

    function aman(value) {
        return String(value ?? '-').replace(/[&<>"']/g, function (karakter) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[karakter];
        });
    }

    function tampilkanStatistik(statistik) {
        document.getElementById('total-peminjaman').textContent = statistik.total_peminjaman;
        document.getElementById('total-pengembalian').textContent = statistik.total_pengembalian;
        document.getElementById('peminjaman-aktif').textContent = statistik.peminjaman_aktif;
        document.getElementById('peminjaman-terlambat').textContent = statistik.peminjaman_terlambat;
        document.getElementById('denda-keterlambatan').textContent = rupiah(statistik.total_denda_keterlambatan);
        document.getElementById('total-denda').textContent = rupiah(statistik.total_denda);
    }

    function tampilkanRekapBuku(data) {
        daftarBuku.innerHTML = '';

        const bukuDenganPeminjaman = data.filter(item => item.total_dipinjam > 0);

        document.getElementById('jumlah-buku').textContent =
            `${bukuDenganPeminjaman.length} buku dipinjam`;

        if (bukuDenganPeminjaman.length === 0) {
            daftarBuku.innerHTML = '<tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">Tidak ada peminjaman buku pada periode ini.</td></tr>';
            return;
        }

        bukuDenganPeminjaman.forEach(item => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50';
            tr.innerHTML = `
                <td class="px-4 py-3 font-semibold">${aman(item.judul)}</td>
                <td class="px-4 py-3">${aman(item.kategori?.nama)}</td>
                <td class="px-4 py-3 font-bold">${item.total_dipinjam}</td>
                <td class="px-4 py-3">${item.total_dikembalikan}</td>
                <td class="px-4 py-3 text-red-600">${item.total_terlambat}</td>
            `;
            daftarBuku.appendChild(tr);
        });
    }

    function tampilkanTransaksi(data) {
        daftarTransaksi.innerHTML = '';
        document.getElementById('jumlah-transaksi').textContent =
            `${data.length} transaksi`;

        if (data.length === 0) {
            daftarTransaksi.innerHTML = '<tr><td colspan="8" class="px-3 py-6 text-center text-slate-500">Tidak ada transaksi pada periode ini.</td></tr>';
            return;
        }

        data.forEach(item => {
            const totalDenda =
                Number(item.denda_keterlambatan || 0) +
                Number(item.denda_kondisi || 0);

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50';
            tr.innerHTML = `
                <td class="px-3 py-3">#${item.id}</td>
                <td class="px-3 py-3">${aman(item.anggota?.nama)}</td>
                <td class="px-3 py-3">${aman(item.buku?.judul)}</td>
                <td class="px-3 py-3">${tanggal(item.tanggal_pinjam)}</td>
                <td class="px-3 py-3">${tanggal(item.tanggal_kembali)}</td>
                <td class="px-3 py-3">${tanggal(item.tanggal_dikembalikan)}</td>
                <td class="px-3 py-3">${aman(item.kondisi_buku)}</td>
                <td class="px-3 py-3 font-semibold">${rupiah(totalDenda)}</td>
            `;
            daftarTransaksi.appendChild(tr);
        });
    }

    async function ambilLaporan() {
        if (tanggalMulai.value && tanggalSelesai.value &&
            tanggalMulai.value > tanggalSelesai.value) {
            pesan.textContent = 'Tanggal mulai tidak boleh melebihi tanggal selesai.';
            pesan.className = 'text-xs text-red-600';
            return;
        }

        pesan.textContent = 'Memuat laporan...';
        pesan.className = 'text-xs text-slate-500';

        const parameter = new URLSearchParams();

        if (tanggalMulai.value) parameter.append('tanggal_mulai', tanggalMulai.value);
        if (tanggalSelesai.value) parameter.append('tanggal_selesai', tanggalSelesai.value);

        try {
            const response = await fetch(`/api/laporan?${parameter.toString()}`, {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal mengambil laporan.');
            }

            dataLaporan = hasil;
            tampilkanStatistik(hasil.statistik);
            tampilkanRekapBuku(hasil.rekap_buku);
            tampilkanTransaksi(hasil.transaksi);

            pesan.textContent =
                `Periode laporan: ${tanggal(hasil.periode.tanggal_mulai)} sampai ${tanggal(hasil.periode.tanggal_selesai)}`;
            pesan.className = 'text-xs text-emerald-600';
        } catch (error) {
            console.error(error);
            pesan.textContent = error.message;
            pesan.className = 'text-xs text-red-600';
        }
    }

    tombolFilter.addEventListener('click', ambilLaporan);

    tombolReset.addEventListener('click', function () {
        tanggalMulai.value = '';
        tanggalSelesai.value = '';
        ambilLaporan();
    });

    tombolCetak.addEventListener('click', function () {
        if (!dataLaporan) {
            alert('Data laporan belum tersedia.');
            return;
        }
        window.print();
    });

    ambilLaporan();
});
