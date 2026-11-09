
document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. MENGAMBIL ELEMEN HTML
    // ==========================================

    const inputCari = document.getElementById('cari-peminjaman');
    const daftarPeminjaman = document.getElementById('daftar-peminjaman');
    const infoPeminjaman = document.getElementById('info-peminjaman');
    const tombolSebelumnya = document.getElementById('tombol-sebelumnya');
    const tombolSelanjutnya = document.getElementById('tombol-selanjutnya');
    const nomorHalaman = document.getElementById('nomor-halaman');

    const totalTransaksi = document.getElementById('total-transaksi');
    const peminjamanHariIni = document.getElementById('peminjaman-hari-ini');
    const jatuhTempoHariIni = document.getElementById('jatuh-tempo-hari-ini');
    const lewatJatuhTempo = document.getElementById('lewat-jatuh-tempo');

    // Elemen form
    const formContainer = document.getElementById('form-container');
    const formPeminjaman = document.getElementById('form-peminjaman');
    const judulForm = document.getElementById('judul-form');
    const tombolTambah = document.getElementById('tombol-tambah');
    const tombolTutupForm = document.getElementById('tombol-tutup-form');
    const tombolBatal = document.getElementById('tombol-batal');
    const tombolSubmit = document.getElementById('tombol-submit');
    const pesanPeminjaman = document.getElementById('pesan-peminjaman');

    const selectAnggota = document.getElementById('anggota_id');
    const selectBuku = document.getElementById('buku_id');
    const inputTanggalPinjam = document.getElementById('tanggal_pinjam');
    const inputTanggalKembali = document.getElementById('tanggal_kembali');

    // Memastikan elemen tersedia
    if (
        !inputCari || !daftarPeminjaman || !infoPeminjaman ||
        !tombolSebelumnya || !tombolSelanjutnya || !nomorHalaman ||
        !totalTransaksi || !peminjamanHariIni ||
        !jatuhTempoHariIni || !lewatJatuhTempo ||
        !formContainer || !formPeminjaman || !judulForm ||
        !tombolTambah || !tombolTutupForm || !tombolBatal ||
        !tombolSubmit || !pesanPeminjaman ||
        !selectAnggota || !selectBuku ||
        !inputTanggalPinjam || !inputTanggalKembali
    ) {
        console.error('Ada elemen halaman peminjaman yang tidak ditemukan.');
        return;
    }

    // ==========================================
    // 2. VARIABEL DATA
    // ==========================================

    let seluruhPeminjaman = [];
    let dataTampil = [];
    let halamanAktif = 1;

    const dataPerHalaman = 10;

    let modeForm = 'tambah';
    let idPeminjamanEdit = null;
    let pilihanSudahDimuat = false;

    // ==========================================
    // 3. FUNGSI BANTUAN
    // ==========================================

    // Mengambil cookie CSRF
    function ambilCookie(nama) {
        const cookie = document.cookie
            .split('; ')
            .find(row => row.startsWith(nama + '='));

        return cookie
            ? decodeURIComponent(cookie.split('=')[1])
            : null;
    }

    // Menghindari HTML injection
    function escapeHTML(teks) {
        return String(teks ?? '').replace(/[&<>"']/g, function (karakter) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[karakter];
        });
    }

    // Format tanggal tanpa menggeser tanggal karena timezone
    function formatTanggal(tanggal) {
        if (!tanggal) return '-';

        const bagian = String(tanggal).split('-');

        if (bagian.length !== 3) {
            return escapeHTML(tanggal);
        }

        return `${bagian[2]}-${bagian[1]}-${bagian[0]}`;
    }

    // Mengambil CSRF token
    async function ambilTokenCSRF() {
        await fetch('/sanctum/csrf-cookie', {
            credentials: 'same-origin'
        });

        const token = ambilCookie('XSRF-TOKEN');

        if (!token) {
            throw new Error('Token CSRF tidak ditemukan.');
        }

        return token;
    }

    // Menampilkan pesan pada form
    function tampilkanPesan(pesan, jenis = 'error') {
        pesanPeminjaman.textContent = pesan;

        pesanPeminjaman.className = jenis === 'success'
            ? 'mt-4 text-xs text-green-600'
            : 'mt-4 text-xs text-red-600';
    }

    // Mengubah format error validasi Laravel
    function tampilkanErrorValidasi(errors) {
        const daftarError = Object.values(errors).flat();

        tampilkanPesan(daftarError.join(' '));
    }

    // ==========================================
    // 4. MEMUAT DROPDOWN ANGGOTA DAN BUKU
    // ==========================================

    async function muatPilihanForm() {
        if (pilihanSudahDimuat) return;

        try {
            const [responseAnggota, responseBuku] = await Promise.all([
                fetch('/api/anggota', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                }),

                fetch('/api/buku?per_page=100', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
            ]);

            if (!responseAnggota.ok) {
                throw new Error('Gagal mengambil data anggota.');
            }

            if (!responseBuku.ok) {
                throw new Error('Gagal mengambil data buku.');
            }

            const hasilAnggota = await responseAnggota.json();
            const hasilBuku = await responseBuku.json();

            const daftarAnggota = hasilAnggota.data || [];
            const daftarBuku = hasilBuku.data || [];

            // Mengisi dropdown anggota
            selectAnggota.innerHTML = '<option value="">Pilih Anggota</option>';

            daftarAnggota.forEach(anggota => {
                selectAnggota.innerHTML += `
                    <option value="${escapeHTML(anggota.id)}">
                        ${escapeHTML(anggota.nama)}
                    </option>
                `;
            });

            // Mengisi dropdown buku
            selectBuku.innerHTML = '<option value="">Pilih Buku</option>';

            daftarBuku.forEach(buku => {
                selectBuku.innerHTML += `
                    <option value="${escapeHTML(buku.id)}">
                        ${escapeHTML(buku.judul)}
                    </option>
                `;
            });

            pilihanSudahDimuat = true;

        } catch (error) {
            console.error(error);
            tampilkanPesan('Gagal memuat pilihan anggota atau buku.');
            throw error;
        }
    }

    // ==========================================
    // 5. MENGATUR FORM TAMBAH DAN EDIT
    // ==========================================

    // Membuka form tambah
    async function bukaFormTambah() {
        try {
            await muatPilihanForm();

            modeForm = 'tambah';
            idPeminjamanEdit = null;

            formPeminjaman.reset();

            judulForm.textContent = 'Tambah Peminjaman';
            tombolSubmit.textContent = 'Tambah Peminjaman';

            pesanPeminjaman.textContent = '';

            formContainer.classList.remove('hidden');
            formContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {
            console.error(error);
        }
    }

    // Membuka form edit
    async function bukaFormEdit(id) {
        try {
            await muatPilihanForm();

            const peminjaman = seluruhPeminjaman.find(item => {
                return String(item.id) === String(id);
            });

            if (!peminjaman) {
                throw new Error('Data peminjaman tidak ditemukan.');
            }

            modeForm = 'edit';
            idPeminjamanEdit = id;

            // Mengisi form dengan data lama
            selectAnggota.value = peminjaman.anggota_id;
            selectBuku.value = peminjaman.buku_id;

            inputTanggalPinjam.value = peminjaman.tanggal_pinjam
                ? String(peminjaman.tanggal_pinjam).substring(0, 10)
                : '';

            inputTanggalKembali.value = peminjaman.tanggal_kembali
                ? String(peminjaman.tanggal_kembali).substring(0, 10)
                : '';

            judulForm.textContent = 'Edit Peminjaman';
            tombolSubmit.textContent = 'Simpan Perubahan';

            pesanPeminjaman.textContent = '';

            formContainer.classList.remove('hidden');
            formContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {
            console.error(error);
            alert(error.message);
        }
    }

    // Menutup form
    function tutupForm() {
        formContainer.classList.add('hidden');

        formPeminjaman.reset();

        modeForm = 'tambah';
        idPeminjamanEdit = null;

        judulForm.textContent = 'Tambah Peminjaman';
        tombolSubmit.textContent = 'Tambah Peminjaman';

        pesanPeminjaman.textContent = '';
    }

    // Event tombol tambah
    tombolTambah.addEventListener('click', bukaFormTambah);

    // Event tombol tutup dan batal
    tombolTutupForm.addEventListener('click', tutupForm);
    tombolBatal.addEventListener('click', tutupForm);

    // ==========================================
    // 6. MENYIMPAN DATA TAMBAH DAN EDIT
    // ==========================================

    formPeminjaman.addEventListener('submit', async function (event) {
        event.preventDefault();

        const dataPeminjaman = {
            anggota_id: selectAnggota.value,
            buku_id: selectBuku.value,
            tanggal_pinjam: inputTanggalPinjam.value,
            tanggal_kembali: inputTanggalKembali.value || null
        };

        try {
            tombolSubmit.disabled = true;
            tombolSubmit.textContent = 'Menyimpan...';

            const token = await ambilTokenCSRF();

            let url = '/api/peminjaman';
            let method = 'POST';

            // Jika mode edit, gunakan PUT
            if (modeForm === 'edit') {
                url = `/api/peminjaman/${idPeminjamanEdit}`;
                method = 'PUT';
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-XSRF-TOKEN': token
                },
                credentials: 'same-origin',
                body: JSON.stringify(dataPeminjaman)
            });

            const hasil = await response.json();

            // Menangani error validasi Laravel
            if (response.status === 422) {
                tampilkanErrorValidasi(hasil.errors || {
                    umum: [hasil.message || 'Data tidak valid.']
                });
                return;
            }

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal menyimpan data peminjaman.');
            }

            alert(
                modeForm === 'tambah'
                    ? 'Peminjaman berhasil ditambahkan.'
                    : 'Peminjaman berhasil diperbarui.'
            );

            tutupForm();

            // Memperbarui tabel dan statistik
            await ambilDataPeminjaman();

        } catch (error) {
            console.error(error);
            tampilkanPesan(error.message || 'Terjadi kesalahan saat menyimpan data.');

        } finally {
            tombolSubmit.disabled = false;

            tombolSubmit.textContent = modeForm === 'edit'
                ? 'Simpan Perubahan'
                : 'Tambah Peminjaman';
        }
    });

    // ==========================================
    // 7. MENAMPILKAN STATISTIK
    // ==========================================

    function tampilkanStatistik(statistik) {
        totalTransaksi.textContent = statistik.total_transaksi ?? 0;
        peminjamanHariIni.textContent = statistik.peminjaman_hari_ini ?? 0;
        jatuhTempoHariIni.textContent = statistik.jatuh_tempo_hari_ini ?? 0;
        lewatJatuhTempo.textContent = statistik.lewat_jatuh_tempo ?? 0;
    }

    // ==========================================
    // 8. MENGAMBIL DATA PEMINJAMAN
    // ==========================================

    async function ambilDataPeminjaman() {
        try {
            daftarPeminjaman.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-6">
                        Memuat data peminjaman...
                    </td>
                </tr>
            `;

            const response = await fetch('/api/peminjaman', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data peminjaman.');
            }

            const hasil = await response.json();

            tampilkanStatistik(hasil.statistik || {});

            seluruhPeminjaman = hasil.data || [];
            dataTampil = [...seluruhPeminjaman];

            halamanAktif = 1;

            tampilkanPeminjaman();

        } catch (error) {
            console.error(error);

            daftarPeminjaman.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-6 text-red-500">
                        Gagal memuat data peminjaman.
                    </td>
                </tr>
            `;

            infoPeminjaman.textContent = 'Data gagal dimuat.';
        }
    }

    // ==========================================
    // 9. MENAMPILKAN DATA PEMINJAMAN
    // ==========================================

    function tampilkanPeminjaman() {
        const totalData = dataTampil.length;
        const totalHalaman = Math.max(1, Math.ceil(totalData / dataPerHalaman));

        halamanAktif = Math.min(halamanAktif, totalHalaman);

        const indeksAwal = (halamanAktif - 1) * dataPerHalaman;
        const dataHalaman = dataTampil.slice(indeksAwal, indeksAwal + dataPerHalaman);

        if (dataHalaman.length === 0) {
            daftarPeminjaman.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Tidak ada data peminjaman.
                    </td>
                </tr>
            `;
        } else {
            daftarPeminjaman.innerHTML = dataHalaman.map(item => {
                const status = item.status || 'menunggu';

                const badgeStatus = {
                    menunggu: 'bg-amber-100 text-amber-700',
                    disetujui: 'bg-green-100 text-green-700',
                    ditolak: 'bg-red-100 text-red-700'
                };

                const statusLabel = {
                    menunggu: 'Menunggu',
                    disetujui: 'Disetujui',
                    ditolak: 'Ditolak'
                };

                return `
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3">${escapeHTML(item.id)}</td>
                        <td class="px-4 py-3">${escapeHTML(item.anggota?.nama || '-')}</td>
                        <td class="px-4 py-3">${escapeHTML(item.buku?.judul || '-')}</td>
                        <td class="px-4 py-3">${formatTanggal(item.tanggal_pinjam)}</td>
                        <td class="px-4 py-3">${formatTanggal(item.tanggal_kembali)}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold ${badgeStatus[status] || 'bg-slate-100 text-slate-600'}">
                                ${escapeHTML(statusLabel[status] || status)}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 flex-wrap">
                                ${status === 'menunggu' ? `
                                    <button type="button" data-id="${escapeHTML(item.id)}" class="tombol-setujui text-xs font-semibold text-green-600 hover:text-green-800">
                                        Setujui
                                    </button>
                                    <button type="button" data-id="${escapeHTML(item.id)}" class="tombol-tolak text-xs font-semibold text-red-600 hover:text-red-800">
                                        Tolak
                                    </button>
                                ` : ''}
                                <button type="button" data-id="${escapeHTML(item.id)}" class="tombol-edit text-blue-600 hover:text-blue-800">
                                    Edit
                                </button>
                                <button type="button" data-id="${escapeHTML(item.id)}" class="tombol-hapus text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        tampilkanPagination(totalData, totalHalaman);
    }

    // ==========================================
    // 10. PAGINATION
    // ==========================================

    function tampilkanPagination(totalData, totalHalaman) {
        infoPeminjaman.textContent = `Total ${totalData} transaksi`;

        nomorHalaman.textContent = `${halamanAktif} / ${totalHalaman}`;

        tombolSebelumnya.disabled = halamanAktif <= 1;
        tombolSelanjutnya.disabled = halamanAktif >= totalHalaman;
    }

    tombolSebelumnya.addEventListener('click', function () {
        if (halamanAktif > 1) {
            halamanAktif--;
            tampilkanPeminjaman();
        }
    });

    tombolSelanjutnya.addEventListener('click', function () {
        const totalHalaman = Math.ceil(dataTampil.length / dataPerHalaman);

        if (halamanAktif < totalHalaman) {
            halamanAktif++;
            tampilkanPeminjaman();
        }
    });

    // ==========================================
    // 11. PENCARIAN
    // ==========================================

    inputCari.addEventListener('input', function () {
        const kataKunci = inputCari.value.toLowerCase().trim();

        dataTampil = seluruhPeminjaman.filter(item => {
            const namaAnggota = item.anggota?.nama || '';
            const judulBuku = item.buku?.judul || '';
            const idPeminjaman = String(item.id);

            return namaAnggota.toLowerCase().includes(kataKunci) ||
                judulBuku.toLowerCase().includes(kataKunci) ||
                idPeminjaman.includes(kataKunci);
        });

        halamanAktif = 1;

        tampilkanPeminjaman();
    });

    // ==========================================
    // 12. EVENT EDIT DAN HAPUS
    // ==========================================

    daftarPeminjaman.addEventListener('click', async function (event) {
        // tombol setujui
        const tombolSetujui = event.target.closest('.tombol-setujui');

        if (tombolSetujui) {
            await prosesKeputusanPeminjaman(tombolSetujui.dataset.id, 'setujui');
            return;
        }

        const tombolTolak = event.target.closest('.tombol-tolak');

        if (tombolTolak) {
            await prosesKeputusanPeminjaman(tombolTolak.dataset.id, 'tolak');
            return;
        }
        // Tombol edit
        const tombolEdit = event.target.closest('.tombol-edit');

        if (tombolEdit) {
            const id = tombolEdit.dataset.id;

            await bukaFormEdit(id);
            return;
        }

        // Tombol hapus
        const tombolHapus = event.target.closest('.tombol-hapus');

        if (!tombolHapus) return;

        const id = tombolHapus.dataset.id;

        if (!confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
            return;
        }

        try {
            const token = await ambilTokenCSRF();

            const response = await fetch(`/api/peminjaman/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': token
                },
                credentials: 'same-origin'
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal menghapus peminjaman.');
            }

            alert('Data peminjaman berhasil dihapus.');

            await ambilDataPeminjaman();

        } catch (error) {
            console.error(error);
            alert(error.message || 'Terjadi kesalahan saat menghapus data.');
        }
    });

    // 13. persetujuan dan penolakan
    async function prosesKeputusanPeminjaman(id, keputusan) {
        const aksi = keputusan === 'setujui' ? 'menyetujui' : 'menolak';

        if (!confirm(`Apakah Anda yakin ingin ${aksi} peminjaman ini?`)) {
            return;
        }

        try {
            const token = await ambilTokenCSRF();

            const response = await fetch(`/api/peminjaman/${id}/${keputusan}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': token
                },
                credentials: 'same-origin'
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || `Gagal ${aksi} peminjaman.`);
            }

            alert(hasil.message);
            await ambilDataPeminjaman();

        } catch (error) {
            console.error(error);
            alert(error.message || 'Terjadi kesalahan.');
        }
    }

    // ==========================================
    // 14. MENJALANKAN SAAT HALAMAN DIBUKA
    // ==========================================
    ambilDataPeminjaman();
});