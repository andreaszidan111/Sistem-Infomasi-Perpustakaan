
document.addEventListener('DOMContentLoaded', function () {
    // Mengambil elemen HTML
    const daftarPengembalian = document.getElementById('daftar-pengembalian');
    const jumlahData = document.getElementById('jumlah-data');
    const tombolRefresh = document.getElementById('tombol-refresh');

    const formPengembalian = document.getElementById('form-pengembalian');
    const peminjamanId = document.getElementById('peminjaman_id');
    const namaAnggota = document.getElementById('nama-anggota');
    const emailAnggota = document.getElementById('email-anggota');
    const judulBuku = document.getElementById('judul-buku');
    const batasKembali = document.getElementById('batas-kembali');
    const kondisiBuku = document.getElementById('kondisi-buku');
    const tombolSubmit = document.getElementById('tombol-submit');

    const hariTerlambat = document.getElementById('hari-terlambat');
    const dendaTerlambat = document.getElementById('denda-terlambat');
    const dendaKondisi = document.getElementById('denda-kondisi');
    const totalDenda = document.getElementById('total-denda');
    const pesanPengembalian = document.getElementById('pesan-pengembalian');
    const pesanTabel = document.getElementById('pesan-tabel');

    // Menyimpan seluruh data transaksi
    let seluruhPeminjaman = [];
    let transaksiDipilih = null;

    // Tarif denda
    const DENDA_PER_HARI = 5000;

    // Mengambil CSRF token dari cookie
    function ambilCookie(nama) {
        const cookie = document.cookie
            .split('; ')
            .find(row => row.startsWith(nama + '='));

        return cookie ? decodeURIComponent(cookie.split('=')[1]) : null;
    }

    // Format rupiah
    function formatRupiah(nilai) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(nilai);
    }

    // Format tanggal
    function formatTanggal(tanggal) {
        if (!tanggal) return '-';

        const [tahun, bulan, hari] = tanggal.split('-');

        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        return `${hari} ${namaBulan[parseInt(bulan) - 1]} ${tahun}`;
    }

    // Menghitung keterlambatan
    function hitungKeterlambatan(tanggalBatas) {
        if (!tanggalBatas) {
            return 0;
        }

        const sekarang = new Date();
        const batas = new Date(tanggalBatas + 'T00:00:00');

        sekarang.setHours(0, 0, 0, 0);

        const selisih = sekarang.getTime() - batas.getTime();

        return Math.max(0, Math.floor(selisih / (1000 * 60 * 60 * 24)));
    }

    // Menghitung denda berdasarkan kondisi buku
    function hitungDendaKondisi(kondisi) {
        const tarif = {
            'Baik': 0,
            'Rusak Ringan': 5000,
            'Rusak Berat': 15000,
            'Hilang': 50000
        };

        return tarif[kondisi] ?? 0;
    }

    // Menghitung seluruh rincian denda
    function hitungTotalDenda() {
        if (!transaksiDipilih) return;

        const terlambat = hitungKeterlambatan(
            transaksiDipilih.tanggal_kembali
        );

        const dendaTelat = terlambat * DENDA_PER_HARI;
        const dendaRusak = hitungDendaKondisi(kondisiBuku.value);

        const total = dendaTelat + dendaRusak;

        hariTerlambat.textContent = terlambat;
        dendaTerlambat.textContent = formatRupiah(dendaTelat);
        dendaKondisi.textContent = formatRupiah(dendaRusak);
        totalDenda.textContent = formatRupiah(total);
    }

    // Mengosongkan form
    function resetForm() {
        transaksiDipilih = null;

        formPengembalian.reset();

        peminjamanId.value = '';
        namaAnggota.value = '';
        emailAnggota.value = '';
        judulBuku.value = '';
        batasKembali.value = '';

        kondisiBuku.disabled = true;
        tombolSubmit.disabled = true;

        hariTerlambat.textContent = '0';
        dendaTerlambat.textContent = formatRupiah(0);
        dendaKondisi.textContent = formatRupiah(0);
        totalDenda.textContent = formatRupiah(0);

        pesanPengembalian.textContent = '';
        pesanPengembalian.className = 'text-xs';
    }

    // Menampilkan daftar transaksi ke tabel
    function tampilkanPengembalian(data) {
        daftarPengembalian.innerHTML = '';

        if (data.length === 0) {
            daftarPengembalian.innerHTML = `
                <tr>
                    <td colspan="6" class="px-3 py-6 text-center text-slate-500">
                        Tidak ada transaksi yang menunggu pengembalian.
                    </td>
                </tr>
            `;

            return;
        }

        data.forEach(peminjaman => {
            const tr = document.createElement('tr');

            tr.className = 'hover:bg-slate-50';

            const anggota = peminjaman.anggota?.nama ?? '-';
            const email = peminjaman.anggota?.email ?? '-';
            const buku = peminjaman.buku?.judul ?? '-';

            tr.innerHTML = `
                <td class="px-3 py-3 font-mono font-medium text-slate-700">
                    #${peminjaman.id}
                </td>
                <td class="px-3 py-3">
                    <div class="font-bold text-slate-900">${anggota}</div>
                    <div class="text-[10px] text-slate-500">${email}</div>
                </td>
                <td class="px-3 py-3 font-medium text-slate-800">
                    ${buku}
                </td>
                <td class="px-3 py-3 text-slate-600">
                    ${formatTanggal(peminjaman.tanggal_pinjam)}
                </td>
                <td class="px-3 py-3 text-slate-600">
                    ${formatTanggal(peminjaman.tanggal_kembali)}
                </td>
                <td class="px-3 py-3">
                    <button type="button" data-id="${peminjaman.id}"
                        class="pilih-pengembalian bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-md text-[10px] font-semibold">
                        Pilih
                    </button>
                </td>
            `;

            daftarPengembalian.appendChild(tr);
        });
    }

    // Mengambil data pengembalian dari API
    async function ambilDataPengembalian() {
        daftarPengembalian.innerHTML = `
            <tr>
                <td colspan="6" class="px-3 py-6 text-center text-slate-500">
                    Memuat data transaksi...
                </td>
            </tr>
        `;

        try {
            const response = await fetch('/api/pengembalian', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Gagal mengambil data. Status: ${response.status}`);
            }

            const hasil = await response.json();

            seluruhPeminjaman = hasil.data ?? [];

            jumlahData.textContent = `${hasil.total ?? seluruhPeminjaman.length} transaksi`;

            tampilkanPengembalian(seluruhPeminjaman);

            resetForm();

            pesanTabel.textContent = '';
        } catch (error) {
            console.error('Error mengambil data:', error);

            daftarPengembalian.innerHTML = `
                <tr>
                    <td colspan="6" class="px-3 py-6 text-center text-red-600">
                        Gagal memuat data pengembalian.
                    </td>
                </tr>
            `;

            jumlahData.textContent = 'Gagal memuat data';
            pesanTabel.textContent = error.message;
        }
    }

    // Memilih transaksi dari tabel
    daftarPengembalian.addEventListener('click', function (event) {
        const tombol = event.target.closest('.pilih-pengembalian');

        if (!tombol) return;

        const id = tombol.dataset.id;

        transaksiDipilih = seluruhPeminjaman.find(
            item => item.id == id
        );

        if (!transaksiDipilih) return;

        peminjamanId.value = transaksiDipilih.id;
        namaAnggota.value = transaksiDipilih.anggota?.nama ?? '-';
        emailAnggota.value = transaksiDipilih.anggota?.email ?? '-';
        judulBuku.value = transaksiDipilih.buku?.judul ?? '-';
        batasKembali.value = formatTanggal(
            transaksiDipilih.tanggal_kembali
        );

        kondisiBuku.disabled = false;
        kondisiBuku.value = 'Baik';

        tombolSubmit.disabled = false;

        pesanPengembalian.textContent = '';

        hitungTotalDenda();
    });

    // Menghitung ulang denda ketika kondisi buku berubah
    kondisiBuku.addEventListener('change', function () {
        hitungTotalDenda();
    });

    // Memproses pengembalian
    formPengembalian.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!transaksiDipilih) {
            pesanPengembalian.textContent = 'Pilih transaksi terlebih dahulu.';
            pesanPengembalian.className = 'text-xs text-red-600';
            return;
        }

        const konfirmasi = confirm(
            `Proses pengembalian buku "${transaksiDipilih.buku?.judul}"?`
        );

        if (!konfirmasi) return;

        tombolSubmit.disabled = true;
        tombolSubmit.textContent = 'Memproses...';

        try {
            const response = await fetch(
                `/api/peminjaman/${transaksiDipilih.id}/pengembalian`,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-XSRF-TOKEN': ambilCookie('XSRF-TOKEN') ?? ''
                    },
                    body: JSON.stringify({
                        kondisi_buku: kondisiBuku.value
                    })
                }
            );

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(
                    hasil.message ?? 'Pengembalian gagal diproses.'
                );
            }

            alert(
                `Pengembalian berhasil!\n` +
                `Denda keterlambatan: ${formatRupiah(hasil.data.denda_keterlambatan)}\n` +
                `Denda kondisi: ${formatRupiah(hasil.data.denda_kondisi)}\n` +
                `Total denda: ${formatRupiah(hasil.data.total_denda)}`
            );

            resetForm();

            await ambilDataPengembalian();

        } catch (error) {
            console.error('Error pengembalian:', error);

            pesanPengembalian.textContent = error.message;
            pesanPengembalian.className = 'text-xs text-red-600';

        } finally {
            tombolSubmit.disabled = !transaksiDipilih;
            tombolSubmit.textContent = 'Konfirmasi Pengembalian';
        }
    });

    // Tombol refresh
    tombolRefresh.addEventListener('click', function () {
        ambilDataPengembalian();
    });

    // Jalankan saat halaman dibuka
    ambilDataPengembalian();
});
