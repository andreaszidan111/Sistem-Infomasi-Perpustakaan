
const daftarRiwayat = document.getElementById('daftar-riwayat');
const pesanRiwayat = document.getElementById('pesan-riwayat');

const tombolSebelumnya = document.getElementById('riwayat-sebelumnya');
const tombolSelanjutnya = document.getElementById('riwayat-selanjutnya');
const infoHalaman = document.getElementById('info-halaman-riwayat');

let halamanSekarang = 1;

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
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

function tampilkanStatus(status, tanggalDikembalikan) {
    if (status === 'ditolak') {
        return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>';
    }

    if (tanggalDikembalikan) {
        return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Dikembalikan</span>';
    }

    return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Selesai</span>';
}

function tampilkanPesan(pesan) {
    pesanRiwayat.className = 'p-4 text-sm bg-red-50 text-red-600';
    pesanRiwayat.textContent = pesan;
}

async function ambilRiwayat(halaman = 1) {
    daftarRiwayat.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-8 text-slate-400">
                Memuat data...
            </td>
        </tr>
    `;

    pesanRiwayat.classList.add('hidden');

    try {
        const response = await fetch(
            `/api/siswa/riwayat?page=${halaman}`,
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
            throw new Error(result.message || 'Gagal mengambil riwayat.');
        }

        const data = result.data || [];

        if (data.length === 0) {
            daftarRiwayat.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-10 text-slate-400">
                        Belum ada riwayat peminjaman.
                    </td>
                </tr>
            `;
        } else {
            daftarRiwayat.innerHTML = data.map((item, index) => `
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

                    <td class="px-5 py-4 text-slate-600">
                        ${formatTanggal(item.tanggal_dikembalikan)}
                    </td>

                    <td class="px-5 py-4">
                        ${tampilkanStatus(item.status, item.tanggal_dikembalikan)}
                    </td>
                </tr>
            `).join('');
        }

        halamanSekarang = result.current_page || 1;

        infoHalaman.textContent =
            `Halaman ${result.current_page || 1} dari ${result.last_page || 1}`;

        tombolSebelumnya.disabled = !result.prev_page_url;
        tombolSelanjutnya.disabled = !result.next_page_url;

    } catch (error) {
        daftarRiwayat.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-8 text-red-500">
                    Gagal memuat riwayat peminjaman.
                </td>
            </tr>
        `;

        tampilkanPesan(error.message);
    }
}

tombolSebelumnya.addEventListener('click', () => {
    if (halamanSekarang > 1) {
        ambilRiwayat(halamanSekarang - 1);
    }
});

tombolSelanjutnya.addEventListener('click', () => {
    ambilRiwayat(halamanSekarang + 1);
});

ambilRiwayat();