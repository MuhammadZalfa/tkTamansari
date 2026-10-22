<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::put('profil', [
            'sambutan' => [
                'nama' => 'Ibu Sri Rahayu, S.Pd',
                'nip' => '19780412 200801 2 006',
                'masa_jabatan' => '2018 - Sekarang (Periode II)',
                'headline' => 'Setiap Anak Adalah Bintang Unik yang Membutuhkan Langit Penuh Kasih untuk Bersinar Terang',
                'isi' => implode("\n\n", [
                    'Sampurasun, Salam Hangat dan Sejahtera bagi Ayah dan Bunda Tercinta,',
                    'Puji dan syukur senantiasa kita panjatkan ke hadirat Tuhan Yang Maha Esa. Atas limpahan rahmat, taufik, dan hidayah-Nya, TK PGRI Tamansari dapat terus tegak berdiri sebagai rumah kedua yang nyaman, aman, dan penuh inspirasi bagi putra-putri generasi tunas bangsa di Kota Tasikmalaya.',
                    'Masa usia dini (Golden Age) adalah fase pondasi emas yang tidak akan pernah terulang. Di TK PGRI Tamansari, kami meyakini filosofi "Bermain adalah Belajar yang Sebenarnya" melalui pendekatan Pembelajaran Berbasis Sentra (Sentra Balok, Sentra Ibadah, Sentra Main Peran, Bahan Alam, dan Persiapan).',
                    'Selamat datang di portal informasi resmi kami. Mari bergandengan tangan bersama para dewan pendidik berdedikasi kami dalam mengiringi setiap langkah riang ananda meraih masa depan yang gemilang.',
                ]),
                'foto' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop',
            ],
            'sejarah' => [
                'berdiri' => '1998',
                'judul' => 'Tumbuh bersama masyarakat Tamansari sejak 1998',
                'paragraf1' => 'TK PGRI Tamansari didirikan pada tanggal 12 Mei 1998 di bawah naungan Yayasan Pembina Lembaga Pendidikan Persatuan Guru Republik Indonesia (YPLP PGRI). Lahir dari inisiatif para tokoh pendidik senior di Kecamatan Tamansari yang melihat pentingnya pondasi pendidikan karakter yang kokoh dan berkeadilan bagi anak-anak usia emas.',
                'paragraf2' => 'Bermula dari dua ruang kelas sederhana dan kelompok anak usia dini pertama, sekolah ini terus berinovasi mengadaptasi kurikulum terkini tanpa meninggalkan akar kearifan lokal Sunda dan budi pekerti Islam. Kini, TK PGRI Tamansari menjadi rumah kedua yang aman, inklusif, dan menginspirasi bagi anak-anak di lingkungan sekitar.',
                'quote' => 'Tempat pertama di mana rasa ingin tahu anak mekar menjadi kecintaan belajar seumur hidup.',
                'quote_credit' => 'Filosofi pendidikan TK PGRI Tamansari',
                'foto' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA69SxQdqKCrNxwuVUlH4xz6mBhzS-ItLtmjWLOQNC6PCJ_P5MCDYsNmdsdJeEw4TBX2KS8MRhBFnEZYaE8Brpgu1UxyPkjfm7HWmSM_d_ySwRNA3OeRfgIhsTKSJTmKikLGomcXjL88GsE3a4HsOj24VIQaVbpriziR8x6GzCQy6-KvgSDLIWWiUicD1ebQTuWg3cmFpZyDHfncZ2gYJqLf3BnNbsNL2TxIa61YUWDt6jG8CAs4Zc2',
            ],
            'visi' => [
                'utama' => 'Mewujudkan Generasi Anak Usia Dini yang Beriman, Cerdas, Kreatif, Ceria, dan Berakhlak Mulia Menuju Jenjang Pendidikan Dasar.',
                'deskripsi' => 'Menjadi acuan PAUD percontohan ramah anak di Kota Tasikmalaya yang mengutamakan pembentukan budi pekerti luhur dan kecerdasan majemuk (multiple intelligences).',
            ],
            'misi' => [
                [
                    'icon' => 'volunteer_activism',
                    'title' => '1. Penanaman Nilai Religius dan Budi Pekerti',
                    'body' => 'Menanamkan nilai religius dan budi pekerti luhur sejak dini melalui pembiasaan doa harian, hafalan surat pendek, serta pengenalan adab sopan santun setiap hari.',
                ],
                [
                    'icon' => 'psychology',
                    'title' => '2. Pengembangan Potensi Holistik',
                    'body' => 'Mengembangkan motorik kasar dan halus, kognitif, bahasa, serta kemandirian sosio-emosional secara seimbang melalui metode belajar sambil bermain.',
                ],
                [
                    'icon' => 'park',
                    'title' => '3. Lingkungan Aman, Hijau, dan Penuh Kasih',
                    'body' => 'Menciptakan lingkungan fisik dan psikologis yang higienis, ramah anak, bebas perundungan, dan kaya interaksi positif antar teman sebaya serta pendidik.',
                ],
                [
                    'icon' => 'handshake',
                    'title' => '4. Kemitraan Sinergis Orang Tua dan Sekolah',
                    'body' => 'Membangun komunikasi aktif dan transparan serta program parenting berkala demi menyelaraskan pola asuh positif di rumah dan di sekolah.',
                ],
            ],
            'fakta' => [
                ['label' => 'Berdiri sejak', 'value' => '1998'],
                ['label' => 'Kurikulum', 'value' => 'Merdeka PAUD'],
                ['label' => 'Rasio guru', 'value' => '1 : 12 anak'],
                ['label' => 'Kelompok belajar', 'value' => 'KB, TK-A, TK-B'],
            ],
            'fasilitas' => [
                [
                    'title' => 'Ruang Kelas Tematik Ber-AC',
                    'body' => 'Meja dan kursi ergonomis ramah anak dengan display karya seni serta sirkulasi udara bersih untuk kenyamanan belajar.',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAF7XFU2hqWvE04xeq4Ne3u3U8pE9ceYHyeLsyU15KGy_EXwsS6-tRRBgnTl5EYRPvkL6XDN7ttTQFUb8RuAo8j0BzSf9f1btonng9eJHB9nllwxn1Xfv7mXiVsSFgJ-2B1lZh1R6Y',
                ],
                [
                    'title' => 'Taman Bermain Luar Ruangan',
                    'body' => 'Ayunan, jungkat-jungkit, prosotan, dan lintasan rumput sintetis lembut untuk stimulasi motorik kasar dalam suasana aman.',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA69SxQdqKCrNxwuVUlH4xz6mBhzS-ItLtmjWLOQNC6PCJ_P5MCDYsNmdsdJeEw4TBX2KS8MRhBFnEZYaE8Brpgu1UxyPkjfm7HWmSM_d_ySwRNA3OeRfgIhsTKSJTmKikLGomcXjL88GsE3a4HsOj24VIQaVbpriziR8x6GzCQy6-KvgSDLIWWiUicD1ebQTuWg3cmFpZyDHfncZ2gYJqLf3BnNbsNL2TxIa61YUWDt6jG8CAs4Zc2',
                ],
                [
                    'title' => 'Pojok Literasi dan Perpustakaan Mini',
                    'body' => 'Buku dongeng bergambar, boneka jari, dan karpet empuk yang merangsang imajinasi dan kecintaan membaca sejak dini.',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAouNo3LNUeNbjmi_D471pwROpMDl1SzrJTUZzAPWr9YcuDBmu16_b68l-b3acT6eTEoHZgXJO76D6qFjVPYNsIjOeMpEveMiaqpeSi6vVKWOmFACGgPyyi1oEod8hKgzYwSKtA7MzsZec580ao5GPg_Rtxur87QDP38W8K-FBIlRjqoXe44sVFJ5OXtO4BHmo45Sw8UtVn29hLQ31FVbo86B9vKrRVapPSflIvNY9E7pc6Doe1plc1',
                ],
            ],
        ]);

        SiteSetting::put('kontak', [
            'telepon' => '(0265) 345-6789',
            'telepon_link' => 'tel:02653456789',
            'whatsapp' => '+62 812-2345-6789',
            'whatsapp_link' => 'https://wa.me/6281223456789',
            'email' => 'tkpgri.tamansari@gmail.com',
            'alamat' => 'Jl. Tamansari No. 12',
            'kota' => 'Kecamatan Tamansari, Kota Tasikmalaya, Jawa Barat 46196.',
            'maps' => 'https://maps.google.com/?q=TK+PGRI+Tamansari+Tasikmalaya',
            'jam' => [
                ['label' => 'Senin - Kamis', 'value' => '07.30 - 11.30 WIB', 'note' => 'Kelas dan konsultasi humas', 'closed' => false],
                ['label' => 'Jumat', 'value' => '07.30 - 10.30 WIB', 'note' => 'Kelas ringkas dan evaluasi', 'closed' => false],
                ['label' => 'Sabtu (ekstra)', 'value' => '08.00 - 10.00 WIB', 'note' => 'Sesi kunjungan dan parenting', 'closed' => false],
                ['label' => 'Minggu dan libur', 'value' => 'Tutup', 'note' => 'Layanan di luar jam kerja', 'closed' => true],
            ],
        ]);
    }
}
