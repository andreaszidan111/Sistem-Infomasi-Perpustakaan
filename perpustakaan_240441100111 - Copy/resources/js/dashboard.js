document.addEventListener('DOMContentLoaded', function () {

    // Menampilkan tanggal
    const dateElement = document.getElementById('live-date');

    if (dateElement) {
        const opsi = {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };

        dateElement.innerText = new Date().toLocaleDateString('id-ID', opsi);
    }

    // Mengambil elemen pagination peminjaman
    const tabel = document.getElementById('tabel-peminjaman');
    const info = document.getElementById('info-peminjaman');
    const halaman = document.getElementById('peminjaman-halaman');
    const tombolSebelumnya = document.getElementById('peminjaman-sebelumnya');
    const tombolSelanjutnya = document.getElementById('peminjaman-selanjutnya');

    // Jika bukan halaman yang memiliki tabel peminjaman, hentikan proses pagination
    if (!tabel || !info || !halaman || !tombolSebelumnya || !tombolSelanjutnya) {
        return;
    }

    let halamanAktif = 1;

    // Mengambil data peminjaman
    async function ambilDataPeminjaman(page = halamanAktif) {
        try {
            const response = await fetch(`/admin/dashboard/data-peminjaman?page=${page}`);

            if (!response.ok) {
                throw new Error('Gagal mengambil data peminjaman.');
            }

            const hasil = await response.json();

            halamanAktif = hasil.meta.current_page;

            tampilkanPeminjaman(hasil.data);
            tampilkanPagination(hasil.meta);

        } catch (error) {
            console.error(error);
        }
    }

    // Menampilkan data tabel
    function tampilkanPeminjaman(daftarPeminjaman) {
        tabel.innerHTML = '';

        if (daftarPeminjaman.length === 0) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="6" class="px-3 py-6 text-center">
                        Belum ada transaksi.
                    </td>
                </tr>
            `;
            return;
        }

        daftarPeminjaman.forEach(peminjaman => {
            tabel.innerHTML += `
                <tr class="hover:bg-slate-50">
                    <td class="px-3 py-3">
                        PJ-${String(peminjaman.id).padStart(4, '0')}
                    </td>
                    <td class="px-3 py-3">
                        ${peminjaman.anggota?.nama ?? '-'}
                    </td>
                    <td class="px-3 py-3">
                        ${peminjaman.buku?.judul ?? '-'}
                    </td>
                    <td class="px-3 py-3">
                        ${peminjaman.tanggal_pinjam ?? '-'}
                    </td>
                    <td class="px-3 py-3">
                        ${peminjaman.tanggal_kembali ?? '-'}
                    </td>
                    <td class="px-3 py-3">
                        ${
                            peminjaman.tanggal_kembali
                                ? `<span style="background-color: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600;">Dikembalikan</span>`
                                : `<span style="background-color: #fef9c3; color: #a16207; padding: 5px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600;">Dipinjam</span>`
                        }
                    </td>
                </tr>
            `;
        });
    }

    // Menampilkan pagination
    function tampilkanPagination(meta) {
        info.textContent = `Total ${meta.total} transaksi`;
        halaman.textContent = `${meta.current_page} / ${meta.last_page}`;

        tombolSebelumnya.disabled = meta.current_page <= 1;
        tombolSelanjutnya.disabled = meta.current_page >= meta.last_page;
    }

    // Tombol sebelumnya
    tombolSebelumnya.addEventListener('click', function () {
        if (halamanAktif > 1) {
            ambilDataPeminjaman(halamanAktif - 1);
        }
    });

    // Tombol selanjutnya
    tombolSelanjutnya.addEventListener('click', function () {
        ambilDataPeminjaman(halamanAktif + 1);
    });

    // Mengambil data pertama kali
    ambilDataPeminjaman();
});