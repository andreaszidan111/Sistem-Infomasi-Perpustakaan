
const daftarPeminjaman = document.getElementById('daftar-peminjaman');
const pesanStatus = document.getElementById('pesan-status');

const jumlahMenunggu = document.getElementById('jumlah-menunggu');
const jumlahDisetujui = document.getElementById('jumlah-disetujui');
const jumlahDitolak = document.getElementById('jumlah-ditolak');

const tombolSebelumnya = document.getElementById('halaman-sebelumnya');
const tombolSelanjutnya = document.getElementById('halaman-selanjutnya');
const infoHalaman = document.getElementById('info-halaman');

let halamanSekarang = 1;

function tampilkanPesan(pesan, tipe = 'error') {
    pesanStatus.classList.remove('hidden');
    pesanStatus.className = 'p-4 text-sm';

    if (tipe === 'error') {
        pesanStatus.classList.add('bg-red-50', 'text-red-600');
    } else {
        pesanStatus.classList.add('bg-blue-50', 'text-blue-600');
    }

    pesanStatus.textContent = pesan;
}

function formatTanggal(tanggal) {
    if (!tanggal) return '-';

    const date = new Date(tanggal + 'T00:00:00');

    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
}

function badgeStatus(status) {
    const statusMap = {
        menunggu: {
            label: 'Menunggu',
            class: 'bg-amber-100 text-amber-700'
        },
        disetujui: {
            label: 'Disetujui',
            class: 'bg-emerald-100 text-emerald-700'
        },
        ditolak: {
            label: 'Ditolak',
            class: 'bg-red-100 text-red-700'
        }
    };

    const data = statusMap[status] || {
        label: status || 'Belum ditentukan',
        class: 'bg-slate-100 text-slate-600'
    };

    return `<span class="px-3 py-1 rounded-full text-xs font-semibold ${data.class}">
        ${data.label}
    </span>`;
}

async function ambilPeminjaman(halaman = 1) {
    daftarPeminjaman.innerHTML = `
        <tr>
            <td colspan="5" class="text-center py-8 text-slate-400">
                Memuat data...
            </td>
        </tr>
    `;

    pesanStatus.classList.add('hidden');

    try {
        const response = await fetch(
            `/api/siswa/peminjaman?page=${halaman}`,
            {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Gagal mengambil data peminjaman.');
        }

        const data = result.data || [];

        // Statistik dihitung dari seluruh data milik siswa.
        // Endpoint paginasi hanya mengembalikan 10 data per halaman,
        // sehingga statistik lengkap perlu endpoint agregasi tersendiri.
        if (data.length === 0 && halaman === 1) {
            daftarPeminjaman.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-400">
                        Belum ada pengajuan peminjaman.
                    </td>
                </tr>
            `;
        } else {
            daftarPeminjaman.innerHTML = data.map((item, index) => `
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-4 text-slate-500">
                        ${(result.from || 1) + index}
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-700">
                        ${escapeHTML(item.buku?.judul || 'Buku tidak ditemukan')}
                    </td>

                    <td class="px-5 py-4 text-slate-600">
                        ${formatTanggal(item.tanggal_pinjam)}
                    </td>

                    <td class="px-5 py-4 text-slate-600">
                        ${formatTanggal(item.tanggal_kembali)}
                    </td>

                    <td class="px-5 py-4">
                        ${badgeStatus(item.status)}
                    </td>
                </tr>
            `).join('');
        }

        halamanSekarang = result.current_page || 1;

        infoHalaman.textContent =
            `Halaman ${result.current_page || 1} dari ${result.last_page || 1}`;

        tombolSebelumnya.disabled = !result.prev_page_url;
        tombolSelanjutnya.disabled = !result.next_page_url;

        // Tampilkan statistik seluruh pengajuan siswa
        jumlahMenunggu.textContent = result.statistik.menunggu;
        jumlahDisetujui.textContent = result.statistik.disetujui;
        jumlahDitolak.textContent = result.statistik.ditolak;

    } catch (error) {
        daftarPeminjaman.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-8 text-red-500">
                    Gagal memuat data peminjaman.
                </td>
            </tr>
        `;

        tampilkanPesan(error.message);
    }
}

function escapeHTML(value) {
    return String(value).replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}

tombolSebelumnya.addEventListener('click', () => {
    if (halamanSekarang > 1) {
        ambilPeminjaman(halamanSekarang - 1);
    }
});

tombolSelanjutnya.addEventListener('click', () => {
    ambilPeminjaman(halamanSekarang + 1);
});

ambilPeminjaman();