const formPeminjaman = document.getElementById('form-peminjaman');
const pilihanBuku = document.getElementById('buku_id');
const tanggalKembali = document.getElementById('tanggal_kembali');
const tombolAjukan = document.getElementById('tombol-ajukan');
const pesanPeminjaman = document.getElementById('pesan-peminjaman');

// Menampilkan pesan
function tampilkanPesan(pesan, tipe = 'error') {
    pesanPeminjaman.classList.remove(
        'hidden',
        'bg-red-50',
        'text-red-700',
        'border-red-200',
        'bg-green-50',
        'text-green-700',
        'border-green-200'
    );

    pesanPeminjaman.classList.add(
        'border',
        'rounded-lg',
        'p-3'
    );

    if (tipe === 'success') {
        pesanPeminjaman.classList.add(
            'bg-green-50',
            'text-green-700',
            'border-green-200'
        );
    } else {
        pesanPeminjaman.classList.add(
            'bg-red-50',
            'text-red-700',
            'border-red-200'
        );
    }

    pesanPeminjaman.textContent = pesan;
}

// Mengambil daftar buku
async function muatPilihanBuku() {
    try {
        const response = await fetch('/api/buku?per_page=100', {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil daftar buku.');
        }

        const hasil = await response.json();

        pilihanBuku.innerHTML = '<option value="">-- Pilih Buku --</option>';

        hasil.data.forEach(buku => {
            const option = document.createElement('option');

            option.value = buku.id;
            option.textContent =
                `${buku.judul} - ${buku.penulis}`;

            pilihanBuku.appendChild(option);
        });

        // Mengambil buku yang dipilih dari katalog
        const parameter = new URLSearchParams(window.location.search);
        const bukuId = parameter.get('buku_id');

        if (bukuId) {
            pilihanBuku.value = bukuId;
        }

    } catch (error) {
        console.error(error);

        pilihanBuku.innerHTML =
            '<option value="">Gagal memuat daftar buku</option>';

        tampilkanPesan(error.message);
    }
}

// Mengambil CSRF token untuk request SPA
async function ambilCsrfToken() {
    await fetch('/sanctum/csrf-cookie', {
        credentials: 'same-origin'
    });

    const cookie = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='));

    if (!cookie) {
        throw new Error('Token keamanan tidak ditemukan. Muat ulang halaman.');
    }

    return decodeURIComponent(cookie.split('=').slice(1).join('='));
}

// Mengirim pengajuan
formPeminjaman.addEventListener('submit', async function (event) {
    event.preventDefault();

    if (!pilihanBuku.value) {
        tampilkanPesan('Silakan pilih buku terlebih dahulu.');
        return;
    }

    tombolAjukan.disabled = true;
    tombolAjukan.textContent = 'Mengirim...';

    try {
        const csrfToken = await ambilCsrfToken();

        const data = {
            buku_id: pilihanBuku.value,
            tanggal_kembali: tanggalKembali.value || null
        };

        const response = await fetch('/api/siswa/peminjaman', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-XSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const hasil = await response.json();

        if (!response.ok) {
            if (response.status === 422 && hasil.errors) {
                const daftarError = Object.values(hasil.errors)
                    .flat()
                    .join(' ');

                throw new Error(daftarError);
            }

            throw new Error(
                hasil.message || 'Pengajuan peminjaman gagal.'
            );
        }

        tampilkanPesan(
            hasil.message,
            'success'
        );

        formPeminjaman.reset();

        // Tanggal pengembalian tetap kosong setelah pengajuan
        pilihanBuku.value = '';

        const tombolRiwayat = document.createElement('a');
        tombolRiwayat.href = '/siswa/status-peminjaman';
        tombolRiwayat.textContent = 'Lihat Status Pengajuan';
        tombolRiwayat.className =
            'inline-block mt-3 text-xs font-semibold underline';

        pesanPeminjaman.appendChild(document.createElement('br'));
        pesanPeminjaman.appendChild(tombolRiwayat);

    } catch (error) {
        console.error(error);
        tampilkanPesan(error.message);

    } finally {
        tombolAjukan.disabled = false;
        tombolAjukan.textContent = 'Kirim Pengajuan';
    }
});

// Muat pilihan buku ketika halaman dibuka
muatPilihanBuku();