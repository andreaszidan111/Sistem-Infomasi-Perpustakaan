let halamanAktif = 1;
let jumlahPerHalaman = 10;
let pencarian = '';
let kategoriAktif = '';
let timerPencarian = null;
let nomorRequest = 0;

const tabelBuku = document.getElementById('tabel-buku');
const inputCari = document.getElementById('cari-buku');
const filterKategori = document.getElementById('filter-kategori');

const modalDetail = document.getElementById('modal-detail-buku');

// Mengambil data katalog dari API
async function ambilDataBuku(page = 1) {
    const requestSaatIni = ++nomorRequest;

    tabelBuku.innerHTML = `
        <tr>
            <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                Memuat data buku...
            </td>
        </tr>
    `;

    const params = new URLSearchParams({
        page,
        per_page: jumlahPerHalaman
    });

    if (pencarian) {
        params.set('cari', pencarian);
    }

    if (kategoriAktif) {
        params.set('kategori', kategoriAktif);
    }

    try {
        const response = await fetch(`/api/buku?${params.toString()}`, {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                throw new Error('Kamu tidak memiliki akses untuk melihat katalog buku.');
            }

            throw new Error('Gagal mengambil data katalog buku.');
        }

        const hasil = await response.json();

        // Abaikan respons lama jika ada pencarian baru
        if (requestSaatIni !== nomorRequest) return;

        halamanAktif = hasil.meta.current_page;

        tampilkanBuku(hasil.data, hasil.meta);
        tampilkanPagination(hasil.meta);

        document.getElementById('jumlah-buku').textContent =
            `Menampilkan ${hasil.data.length} dari ${hasil.meta.total} buku`;

    } catch (error) {
        if (requestSaatIni !== nomorRequest) return;

        console.error(error);

        tabelBuku.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-red-600">
                    ${error.message}
                </td>
            </tr>
        `;

        document.getElementById('jumlah-buku').textContent =
            'Gagal memuat katalog';
    }
}


// Menampilkan data buku
function tampilkanBuku(daftarBuku, meta) {
    tabelBuku.innerHTML = '';

    if (daftarBuku.length === 0) {
        tabelBuku.innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                    Buku tidak ditemukan.
                </td>
            </tr>
        `;
        return;
    }

    daftarBuku.forEach((buku, index) => {
        const baris = document.createElement('tr');

        baris.className = 'hover:bg-slate-50 transition';

        const data = [
            (meta.current_page - 1) * meta.per_page + index + 1,
            buku.kategori ?? '-',
            buku.judul ?? '-',
            buku.penulis ?? '-',
            buku.tahun ?? '-'
        ];

        data.forEach((nilai, posisi) => {
            const kolom = document.createElement('td');

            kolom.className = 'px-4 py-4';

            if (posisi === 2) {
                kolom.classList.add('font-semibold', 'text-slate-800');
            }

            kolom.textContent = nilai;

            baris.appendChild(kolom);
        });

        const kolomAksi = document.createElement('td');
        kolomAksi.className = 'px-4 py-4 text-center';

        const tombolDetail = document.createElement('button');

        tombolDetail.type = 'button';
        tombolDetail.textContent = 'Detail';
        tombolDetail.className =
            'px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition';

        tombolDetail.addEventListener('click', () => {
            tampilkanDetailBuku(buku.id);
        });

        kolomAksi.appendChild(tombolDetail);
        baris.appendChild(kolomAksi);

        tabelBuku.appendChild(baris);
    });
}


// Mengambil detail buku
async function tampilkanDetailBuku(id) {
    try {
        const response = await fetch(`/api/buku/${id}`, {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil detail buku.');
        }

        const hasil = await response.json();
        const buku = hasil.data;

        document.getElementById('detail-judul').textContent =
            buku.judul ?? '-';

        document.getElementById('detail-kategori').textContent =
            buku.kategori ?? '-';

        document.getElementById('detail-penulis').textContent =
            buku.penulis ?? '-';

        document.getElementById('detail-tahun').textContent =
            buku.tahun ?? '-';

        // Sertakan ID buku saat berpindah ke halaman pengajuan
        const urlPeminjaman = new URL(
            document.getElementById('tombol-ajukan-dari-detail').href
        );

        urlPeminjaman.searchParams.set('buku_id', buku.id);

        document.getElementById('tombol-ajukan-dari-detail').href =
            urlPeminjaman.toString();

        modalDetail.classList.remove('hidden');
        modalDetail.classList.add('flex');

    } catch (error) {
        console.error(error);
        alert(error.message);
    }
}


// Menutup modal detail
function tutupModalDetail() {
    modalDetail.classList.add('hidden');
    modalDetail.classList.remove('flex');
}

document.getElementById('tutup-detail-buku')
    .addEventListener('click', tutupModalDetail);

document.getElementById('tutup-detail-bawah')
    .addEventListener('click', tutupModalDetail);

// Menutup modal ketika area luar diklik
modalDetail.addEventListener('click', (event) => {
    if (event.target === modalDetail) {
        tutupModalDetail();
    }
});


// Pencarian berdasarkan judul dan penulis
inputCari.addEventListener('input', () => {
    clearTimeout(timerPencarian);

    timerPencarian = setTimeout(() => {
        pencarian = inputCari.value.trim();
        halamanAktif = 1;

        ambilDataBuku(1);
    }, 350);
});


// Filter kategori
filterKategori.addEventListener('change', () => {
    kategoriAktif = filterKategori.value;
    halamanAktif = 1;

    ambilDataBuku(1);
});


// Reset pencarian dan filter
document.getElementById('reset-filter')
    .addEventListener('click', () => {
        inputCari.value = '';
        filterKategori.value = '';

        pencarian = '';
        kategoriAktif = '';
        halamanAktif = 1;

        ambilDataBuku(1);
    });


// Mengatur pagination
function tampilkanPagination(meta) {
    const sebelumnya = document.getElementById('halaman-sebelumnya');
    const selanjutnya = document.getElementById('halaman-selanjutnya');

    document.getElementById('info-halaman').textContent =
        `${meta.current_page} / ${meta.last_page}`;

    sebelumnya.disabled = meta.current_page <= 1;
    selanjutnya.disabled = meta.current_page >= meta.last_page;
}

document.getElementById('halaman-sebelumnya')
    .addEventListener('click', () => {
        if (halamanAktif > 1) {
            ambilDataBuku(halamanAktif - 1);
        }
    });

document.getElementById('halaman-selanjutnya')
    .addEventListener('click', () => {
        ambilDataBuku(halamanAktif + 1);
    });


// Mengubah jumlah baris per halaman
document.getElementById('jumlah-per-halaman')
    .addEventListener('change', (event) => {
        jumlahPerHalaman = Number(event.target.value);
        halamanAktif = 1;

        ambilDataBuku(1);
    });


// Muat katalog pertama kali
ambilDataBuku();