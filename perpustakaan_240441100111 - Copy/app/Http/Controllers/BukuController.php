<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{

protected array $daftarBuku = [
    [
        'id'        => 1,
        'judul'     => 'Laskar Pelangi',
        'penulis'   => 'Andrea Hirata',
        'tahun'     => 2005,
        'kategori'  => 'Novel',
        'deskripsi' => 'Kisah perjuangan sepuluh anak Belitung mengejar pendidikan di tengah keterbatasan.',
        'sinopsis'  => 'Laskar Pelangi bercerita tentang sepuluh anak dari keluarga miskin di Belitung yang bersekolah di SD Muhammadiyah, sebuah sekolah reyot yang nyaris ditutup karena kekurangan murid. Di bawah bimbingan Bu Muslimah dan Pak Harfan, kesepuluh anak ini—yang menjuluki diri mereka Laskar Pelangi—tumbuh dengan mimpi dan semangat belajar yang luar biasa meski hidup dalam kemiskinan dan keterbatasan fasilitas. Novel ini mengikuti perjalanan mereka, terutama Ikal dan sahabatnya Lintang yang jenius namun harus berjuang keras hanya untuk sampai ke sekolah, dalam menghadapi rintangan sosial dan ekonomi. Melalui persahabatan, guru-guru yang berdedikasi, dan tekad yang tak pernah padam, Laskar Pelangi menjadi kisah inspiratif tentang bagaimana pendidikan dan mimpi bisa mengubah nasib, sekaligus potret nyata ketimpangan sosial di daerah tambang timah pada masa itu.',
    ],
    [
        'id'        => 2,
        'judul'     => 'Bumi Manusia',
        'penulis'   => 'Pramoedya Ananta Toer',
        'tahun'     => 1980,
        'kategori'  => 'Fiksi Sejarah',
        'deskripsi' => 'Novel yang mengisahkan kehidupan Minke pada masa kolonial Hindia Belanda.',
        'sinopsis'  => 'Bumi Manusia adalah novel pertama dari tetralogi Buru karya Pramoedya Ananta Toer, berlatar Hindia Belanda pada akhir abad ke-19. Tokoh utamanya, Minke, seorang pribumi muda terpelajar yang bersekolah di HBS, mulai menyadari ketidakadilan sistem kolonial yang membeda-bedakan manusia berdasarkan ras dan status sosial. Ia jatuh cinta pada Annelies, putri Nyai Ontosoroh—seorang perempuan pribumi cerdas namun berstatus gundik—dan melalui hubungan ini Minke semakin terseret ke dalam pergulatan hukum, adat, dan kekuasaan kolonial yang timpang. Novel ini menggambarkan dengan tajam bagaimana sistem kolonial merampas hak-hak pribumi bahkan dalam institusi keluarga dan hukum, sekaligus menampilkan kebangkitan kesadaran Minke sebagai cikal bakal semangat nasionalisme. Bumi Manusia dikenal sebagai salah satu karya sastra Indonesia paling berpengaruh yang mengangkat isu kolonialisme, gender, dan identitas.',
    ],
    [
        'id'        => 3,
        'judul'     => 'Filosofi Teras',
        'penulis'   => 'Henry Manampiring',
        'tahun'     => 2018,
        'kategori'  => 'Pengembangan Diri',
        'deskripsi' => 'Mengenalkan filsafat Stoisisme untuk mengelola emosi di kehidupan modern.',
        'sinopsis'  => 'Filosofi Teras mengenalkan pembaca Indonesia pada Stoisisme, sebuah aliran filsafat Yunani-Romawi kuno yang diajarkan oleh tokoh seperti Zeno, Epictetus, Seneca, dan Marcus Aurelius, dan menerjemahkannya ke dalam konteks kehidupan sehari-hari yang relevan dengan masyarakat modern, khususnya di Indonesia. Buku ini membahas bagaimana Stoisisme mengajarkan manusia untuk membedakan antara hal-hal yang bisa dikendalikan (pikiran, tindakan, respons diri) dan yang tidak bisa dikendalikan (pendapat orang lain, kejadian di luar diri), sehingga seseorang bisa lebih tenang menghadapi kecemasan, amarah, dan tekanan hidup. Henry Manampiring memadukan teori filsafat dengan pengalaman pribadinya mengatasi gangguan kecemasan, ditambah riset psikologi modern seperti CBT (Cognitive Behavioral Therapy) yang ternyata banyak berakar dari pemikiran Stoa. Buku ini menjadi panduan praktis untuk hidup lebih tenang, rasional, dan tangguh secara emosional di tengah hiruk-pikuk kehidupan modern.',
    ],
    [
        'id'        => 4,
        'judul'     => 'Clean Code',
        'penulis'   => 'Robert C. Martin',
        'tahun'     => 2008,
        'kategori'  => 'Teknologi',
        'deskripsi' => 'Panduan menulis kode program yang rapi, mudah dibaca, dan mudah dirawat.',
        'sinopsis'  => 'Clean Code karya Robert C. Martin (dikenal juga sebagai "Uncle Bob") adalah buku wajib bagi para software engineer yang membahas prinsip dan praktik menulis kode program berkualitas tinggi. Buku ini tidak hanya membahas sintaks pemrograman, tetapi lebih menekankan pada bagaimana menulis kode yang mudah dibaca, dipahami, dan dirawat oleh developer lain—atau bahkan oleh diri sendiri di masa depan. Martin membahas berbagai topik seperti penamaan variabel dan fungsi yang bermakna, cara menulis fungsi yang kecil dan fokus pada satu tugas, penanganan error yang tepat, penulisan unit test yang efektif, hingga bagaimana melakukan refactoring kode yang berantakan menjadi lebih bersih. Melalui studi kasus nyata dan contoh kode sebelum-sesudah, buku ini mengajarkan bahwa kode yang bersih bukan sekadar soal estetika, melainkan investasi jangka panjang yang mengurangi bug, mempercepat pengembangan, dan membuat kerja tim menjadi lebih efisien.',
    ],
    [
        'id'        => 5,
        'judul'     => 'Sapiens',
        'penulis'   => 'Yuval Noah Harari',
        'tahun'     => 2011,
        'kategori'  => 'Sains Populer',
        'deskripsi' => 'Menelusuri sejarah panjang manusia dari zaman batu hingga era modern.',
        'sinopsis'  => 'Sapiens: A Brief History of Humankind karya Yuval Noah Harari mengajak pembaca menjelajahi perjalanan panjang spesies manusia, Homo sapiens, sejak pertama kali muncul di Afrika sekitar 70.000 tahun lalu hingga menjadi spesies dominan yang menguasai planet Bumi. Harari membagi sejarah manusia ke dalam beberapa revolusi besar: Revolusi Kognitif yang memungkinkan manusia menciptakan bahasa dan mitos bersama seperti agama, uang, dan negara; Revolusi Pertanian yang mengubah cara hidup manusia dari berburu-meramu menjadi menetap bercocok tanam; hingga Revolusi Ilmiah dan Industri yang membawa manusia ke era modern dengan teknologi canggih. Buku ini menawarkan perspektif unik bahwa kemampuan manusia untuk memercayai "fiksi bersama"—seperti hukum, agama, dan ekonomi—adalah kunci yang membedakan Sapiens dari spesies lain dan memungkinkan kerja sama dalam skala besar. Sapiens juga mengajak pembaca merenungkan arah masa depan manusia di tengah perkembangan bioteknologi dan kecerdasan buatan.',
    ],
    [
        'id'        => 6,
        'judul'     => 'Negeri 5 Menara',
        'penulis'   => 'Ahmad Fuadi',
        'tahun'     => 2009,
        'kategori'  => 'Novel',
        'deskripsi' => 'Perjalanan enam santri meraih mimpi lewat mantra "man jadda wajada".',
        'sinopsis'  => 'Negeri 5 Menara mengisahkan perjalanan Alif, seorang remaja asal Maninjau, Sumatera Barat, yang awalnya bercita-cita masuk SMA umum namun akhirnya dikirim orang tuanya untuk belajar di Pondok Madani, sebuah pesantren di Jawa Timur. Di sana, Alif bertemu lima sahabat dari berbagai daerah di Indonesia—Raja, Said, Dulmajid, Atang, dan Baso—yang bersama-sama menjalani kehidupan pesantren yang penuh disiplin namun juga kaya akan pengalaman dan persahabatan. Mereka sering berkumpul di bawah menara masjid sambil menatap awan yang membentuk peta benua impian, sambil menghayati mantra "man jadda wajada" (siapa yang bersungguh-sungguh, akan berhasil) yang diajarkan oleh Kiai Rais. Novel ini menggambarkan bagaimana keenam sahabat ini, meski berasal dari latar belakang sederhana, akhirnya berhasil mewujudkan mimpi masing-masing untuk menjelajahi dunia—dari Amerika hingga Eropa—berkat kerja keras, keyakinan, dan kekuatan persahabatan yang mereka bangun sejak di pesantren.',
    ],
];

    public function index()
    {
        return view('buku.index', [
            'daftarBuku' => $this->daftarBuku,
        ]);
    }

    public function show($id)
    {
        $buku = collect($this->daftarBuku)->firstWhere('id', (int) $id);

        return view('buku.show', [
            'buku' => $buku, 
            'id'   => $id,
        ]);
    }

    public function beranda()
    {
        $bukuRekomendasi = array_slice($this->daftarBuku, 0, 4);

        return view('home', [
            'bukuRekomendasi' => $bukuRekomendasi,
        ]);
    }
}
?>