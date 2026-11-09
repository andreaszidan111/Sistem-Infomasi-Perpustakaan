
document.addEventListener('DOMContentLoaded', function () {

    // Mengambil elemen HTML
    const tombolTambah = document.getElementById('btnTambahPengguna');
    const formContainer = document.getElementById('form-container');
    const formPengguna = document.getElementById('form-pengguna');
    const tombolTutup = document.getElementById('tombol-tutup-form');
    const tombolBatal = document.getElementById('tombol-batal');
    const tombolSubmit = document.getElementById('tombol-submit');
    const judulForm = document.getElementById('judul-form');
    const pesanPengguna = document.getElementById('pesan-pengguna');

    // Pastikan elemen form tersedia
    if (!tombolTambah || !formContainer || !formPengguna ||
        !tombolTutup || !tombolBatal || !pesanPengguna) {
        return;
    }

    // Mengambil nilai cookie
    function ambilCookie(nama) {
        const cookie = document.cookie
            .split('; ')
            .find(baris => baris.startsWith(nama + '='));

        return cookie ? cookie.split('=').slice(1).join('=') : '';
    }

    // Membuka form tambah pengguna
    tombolTambah.addEventListener('click', function () {
        formContainer.classList.remove('hidden');

        formPengguna.reset();
        delete formPengguna.dataset.id;

        judulForm.textContent = 'Tambah Pengguna';
        tombolSubmit.textContent = 'Tambah Pengguna';

        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;

        pesanPengguna.innerHTML = '';
    });

    // Menutup form
    function tutupForm() {
        formContainer.classList.add('hidden');
    }

    tombolTutup.addEventListener('click', tutupForm);
    tombolBatal.addEventListener('click', tutupForm);

    // Mengambil data pengguna untuk diedit
    async function editPengguna(id) {
        try {
            const response = await fetch(`/api/pengguna/${id}`, {
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data pengguna.');
            }

            const hasil = await response.json();
            const pengguna = hasil.data;

            // Menampilkan form edit
            formContainer.classList.remove('hidden');

            // Mengisi form dengan data pengguna
            formPengguna.elements['name'].value = pengguna.name;
            formPengguna.elements['email'].value = pengguna.email;
            formPengguna.elements['role'].value = pengguna.role;

            // Password tidak wajib diisi ketika edit
            formPengguna.elements['password'].value = '';
            formPengguna.elements['password_confirmation'].value = '';

            document.getElementById('password').required = false;
            document.getElementById('password_confirmation').required = false;

            // Menyimpan ID pengguna yang sedang diedit
            formPengguna.dataset.id = pengguna.id;

            judulForm.textContent = 'Edit Pengguna';
            tombolSubmit.textContent = 'Simpan Perubahan';

            pesanPengguna.innerHTML = '';

        } catch (error) {
            console.error(error);
            pesanPengguna.innerHTML = `
                <p class="text-red-600">${error.message}</p>
            `;
        }
    }

    // Menghubungkan tombol Edit pada tabel
    document.querySelectorAll('.tombol-edit').forEach((tombol) => {
        tombol.addEventListener('click', function () {
            editPengguna(tombol.dataset.id);
        });
    });

    // Menyimpan data pengguna (Tambah dan Edit)
    async function simpanPengguna(event) {
        event.preventDefault();

        const id = formPengguna.dataset.id;

        // Mengambil data form
        const dataForm = {
            name: formPengguna.elements['name'].value,
            email: formPengguna.elements['email'].value,
            role: formPengguna.elements['role'].value,
            password: formPengguna.elements['password'].value,
            password_confirmation: formPengguna.elements['password_confirmation'].value
        };

        // Menentukan method dan URL
        const method = id ? 'PUT' : 'POST';
        const url = id
            ? `/api/pengguna/${id}`
            : '/api/pengguna';

        try {
            tombolSubmit.disabled = true;
            pesanPengguna.textContent = 'Sedang menyimpan data...';

            // Meminta CSRF cookie dari Laravel
            await fetch('/sanctum/csrf-cookie', {
                credentials: 'same-origin'
            });

            // Mengambil token CSRF
            const token = decodeURIComponent(ambilCookie('XSRF-TOKEN'));

            // Mengirim data ke API
            const response = await fetch(url, {
                method: method,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-XSRF-TOKEN': token
                },
                body: JSON.stringify(dataForm)
            });

            const hasil = await response.json();

            // Jika gagal
            if (!response.ok) {
                if (response.status === 422 && hasil.errors) {
                    const daftarError = Object.values(hasil.errors)
                        .flat()
                        .join('\n');

                    throw new Error(daftarError);
                }

                throw new Error(
                    hasil.message || `Gagal menyimpan data (${response.status}).`
                );
            }

            // Jika berhasil
            pesanPengguna.innerHTML = `
                <p class="text-green-600">
                    ${hasil.message}
                </p>
            `;

            formPengguna.reset();
            delete formPengguna.dataset.id;

            judulForm.textContent = 'Tambah Pengguna';
            tombolSubmit.textContent = 'Tambah Pengguna';

            // Mengembalikan aturan password untuk form tambah
            document.getElementById('password').required = true;
            document.getElementById('password_confirmation').required = true;

            // Memperbarui tabel dan jumlah pengguna
            setTimeout(() => {
                window.location.reload();
            }, 1500);

        } catch (error) {
            console.error(error);

            pesanPengguna.innerHTML = `
                <p class="text-red-600">${error.message}</p>
            `;

        } finally {
            tombolSubmit.disabled = false;
        }
    }

    // Menjalankan fungsi simpan saat form dikirim
    formPengguna.addEventListener('submit', simpanPengguna);

    // Menghapus pengguna
    async function hapusPengguna(id) {
        const konfirmasi = confirm(
            'Apakah Anda yakin ingin menghapus pengguna ini?'
        );

        if (!konfirmasi) {
            return;
        }

        try {
            // Meminta CSRF cookie dari Laravel
            await fetch('/sanctum/csrf-cookie', {
                credentials: 'same-origin'
            });

            // Mengambil token CSRF
            const token = decodeURIComponent(ambilCookie('XSRF-TOKEN'));

            // Mengirim permintaan DELETE
            const response = await fetch(`/api/pengguna/${id}`, {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': token
                }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(
                    hasil.message || 'Gagal menghapus pengguna.'
                );
            }

            alert(hasil.message);

            window.location.reload();

        } catch (error) {
            console.error(error);
            alert(error.message);
        }
    }

    // Menghubungkan tombol Hapus pada tabel
    document.querySelectorAll('.tombol-hapus').forEach((tombol) => {
        tombol.addEventListener('click', function () {
            hapusPengguna(tombol.dataset.id);
        });
    });
});
