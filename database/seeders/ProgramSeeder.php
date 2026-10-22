<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $jenjang = [
            [
                'name' => 'Kelompok Bermain (KB)',
                'short_name' => 'KB',
                'age_range' => 'Usia 3 - 4 tahun',
                'summary' => 'Fase eksplorasi awal, kemandirian dasar, dan pelepasan cemas perpisahan secara bertahap.',
                'points' => [
                    'Bermain sensorik dan stimulasi motorik kasar serta halus',
                    'Pembiasaan toilet dan makan mandiri',
                    'Sosialisasi berpasangan dan berbagi mainan',
                ],
                'schedule' => 'Senin, Rabu, Jumat',
                'time' => '08.00 - 10.30 WIB',
                'ratio' => '1 guru : 8 anak',
                'icon' => 'toys',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA21mhGENbGKVxVIJTgtRpW0CaxMtrygq5tSnnOd8aoI25IzQsvu0SrXERNyIAmFBCbJiYZLBxawkOohjFQ81h5FELvEbb4HkWcPlb3LrDT1xV-Sy_XmJiphLk-0qlyDDLlCzr_EjjCjIXwTjPe1m7lkZ75ziJhsPOfDTiqBnnKvu2ibsnIpIonUHbZg7bVjl5LLLzdU7NiL8ZGr0zv-2G2D0ZdXKX0WbWUhh6KYITZ-D-QIq3vYRbi',
            ],
            [
                'name' => 'TK Kelompok A',
                'short_name' => 'TK-A',
                'age_range' => 'Usia 4 - 5 tahun',
                'summary' => 'Fase eksplorasi rasa ingin tahu tinggi, pra-literasi ceria, dan pengembangan nalar kritis.',
                'points' => [
                    'Fonik menyenangkan, pra-membaca, dan menulis suku kata',
                    'Sains mini: eksperimen air, warna, magnet, dan tanaman',
                    'Kemandirian dalam tugas kelompok dan etika mendengarkan',
                ],
                'schedule' => 'Senin - Kamis',
                'time' => '07.30 - 11.00 WIB',
                'ratio' => '1 guru : 12 anak',
                'icon' => 'brush',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAouNo3LNUeNbjmi_D471pwROpMDl1SzrJTUZzAPWr9YcuDBmu16_b68l-b3acT6eTEoHZgXJO76D6qFjVPYNsIjOeMpEveMiaqpeSi6vVKWOmFACGgPyyi1oEod8hKgzYwSKtA7MzsZec580ao5GPg_Rtxur87QDP38W8K-FBIlRjqoXe44sVFJ5OXtO4BHmo45Sw8UtVn29hLQ31FVbo86B9vKrRVapPSflIvNY9E7pc6Doe1plc1',
            ],
            [
                'name' => 'TK Kelompok B (Kesiapan SD)',
                'short_name' => 'TK-B',
                'age_range' => 'Usia 5 - 6 tahun',
                'summary' => 'Penguatan fondasi calistung kontekstual, kematangan mental, dan kepemimpinan cilik.',
                'points' => [
                    'Transisi menyenangkan menuju jenjang sekolah dasar',
                    'Logika numerasi dengan benda nyata dan pemecahan masalah',
                    'Regulasi emosi, fokus durasi panjang, dan tanggung jawab',
                ],
                'schedule' => 'Senin - Jumat',
                'time' => '07.30 - 11.30 WIB',
                'ratio' => '1 guru : 12 anak',
                'icon' => 'auto_stories',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPIhzsAUfF6-7xxNuaADjzjDUPOR64UdZXz03f-crZQ_aZ9pmTetSxwXGHvD3wTLyFdG-9XMGhuqyNj-8LvM98gPNiaIO4ffJJSEAKibfghSyZ_UZvfsjtZpI_owaXHBCwYleX54beCDBJsH5tUFNlO_KxIiLAet84JZqZlt1Cn55UhK5fyncseRqCkqQlRuwfX_VFt6cvaNKsmHAfu-OJGYRo6SGEhSvPQ-UKlqDCD2CjefM2t6f6',
            ],
        ];

        foreach ($jenjang as $index => $program) {
            $this->seedProgram('jenjang', $program, $index + 1);
        }

        $pilar = [
            [
                'name' => 'Tahfidz Cilik dan Adab Harian',
                'category' => 'Spiritual dan adab',
                'summary' => 'Menghafal surat pendek Juz Amma dengan metode talaqqi ceria, doa harian praktis, serta internalisasi budaya 5S: senyum, salam, sapa, sopan, dan santun.',
                'points' => ['Target 10 surat pendek dan doa'],
                'icon' => 'menu_book',
            ],
            [
                'name' => 'Sains Cilik dan Kebun Hijau',
                'category' => 'Sains dan lingkungan',
                'summary' => 'Mendidik kecintaan ananda pada ciptaan Ilahi melalui bercocok tanam sayur, memberi makan kelinci di mini zoo sekolah, dan mengamati siklus alam.',
                'points' => ['Panen sayur tiap semester'],
                'icon' => 'yard',
            ],
            [
                'name' => 'Gerak Irama dan Budaya Sunda',
                'category' => 'Seni dan tradisi',
                'summary' => 'Melestarikan kearifan lokal Tasikmalaya sejak dini lewat ansambel angklung mini yang harmonis, tari tradisi anak yang lincah, serta lantunan kawih Sunda yang riang.',
                'points' => ['Pentas seni budaya berkala'],
                'icon' => 'music_note',
            ],
            [
                'name' => 'Pojok Literasi dan Dongeng',
                'category' => 'Imajinasi dan kosakata',
                'summary' => 'Sesi mendongeng nyaring dengan boneka tangan, perpustakaan ramah balita dengan koleksi buku bergambar, serta kehadiran orang tua sebagai guru tamu.',
                'points' => ['Peminjaman buku mingguan'],
                'icon' => 'auto_stories',
            ],
        ];

        foreach ($pilar as $index => $program) {
            $this->seedProgram('pilar', $program, $index + 1);
        }

        $sentra = [
            [
                'name' => 'Sentra Balok & Rancang Bangun',
                'summary' => 'Melatih kemampuan spasial, visual, geometri dasar, dan kecerdasan matematika sejak dini lewat kreasi balok kayu presisi.',
                'points' => ['1.200+ balok kayu, aksesoris miniatur, playmat kota'],
                'icon' => 'architecture',
            ],
            [
                'name' => 'Sentra Bahan Alam & Sains Eksploratif',
                'summary' => 'Pengenalan konsep tekstur, air, pasir, pewarna alami, eksperimen sains sederhana, dan cinta lingkungan hidup sekitar.',
                'points' => ['Tabel sensorik air dan pasir, kaca pembesar, bahan daur ulang'],
                'icon' => 'science',
            ],
            [
                'name' => 'Sentra Main Peran & Sosiodrama',
                'summary' => 'Membangun empati, kosakata, komunikasi sosial, dan kemampuan merefleksikan peran orang dewasa dalam kehidupan nyata.',
                'points' => ['Pojok pasar Pasundan, kostum profesi, perlengkapan medis mini'],
                'icon' => 'theater_comedy',
            ],
            [
                'name' => 'Sentra Ibadah, Adab & Persiapan Calistung',
                'summary' => 'Latihan wudhu, sholat dhuha berjamaah, hafalan juz amma dan doa harian, serta pengenalan huruf dan angka secara fonik riang.',
                'points' => ['Kartu huruf timbul, sajadah anak, buku cerita bergambar'],
                'icon' => 'menu_book',
            ],
        ];

        foreach ($sentra as $index => $program) {
            $this->seedProgram('sentra', $program, $index + 1);
        }

        $ekskul = [
            ['name' => 'Angklung Pasundan Cilik', 'schedule' => 'Rabu (11.00 - 12.00)', 'coach' => 'Kang Asep Sudrajat', 'participants' => 28],
            ['name' => 'Menggambar & Seni Kriya', 'schedule' => 'Selasa (11.00 - 12.00)', 'coach' => 'Ibu Maya Astuti, S.Pd', 'participants' => 32],
            ['name' => 'Tahfidz Juz Amma Riang', 'schedule' => 'Kamis (11.00 - 12.00)', 'coach' => 'Ust. Farhan Zaki', 'participants' => 24],
            ['name' => 'Tari Kreasi & Jaipong Cilik', 'schedule' => 'Jumat (10.30 - 11.30)', 'coach' => 'Teh Nining Ratnasari', 'participants' => 22],
            ['name' => 'Mini Futsal & Olahraga Ceria', 'schedule' => 'Sabtu (08.00 - 09.30)', 'coach' => 'Bpk. Ridwan Fauzi', 'participants' => 20],
            ['name' => 'Drum Band Gita Irama Tamansari', 'schedule' => 'Senin (11.00 - 12.00)', 'coach' => 'Bpk. Hendra Wijaya', 'participants' => 16],
        ];

        foreach ($ekskul as $index => $club) {
            $this->seedProgram('ekskul', [
                'name' => $club['name'],
                'summary' => 'Pelatih: '.$club['coach'].'.',
                'schedule' => $club['schedule'],
                'points' => [$club['participants'].' anak terdaftar'],
                'icon' => 'sports_martial_arts',
            ], $index + 1);
        }
    }

    /**
     * @param  array<string, mixed>  $program
     */
    private function seedProgram(string $type, array $program, int $order): void
    {
        Program::updateOrCreate(
            ['slug' => str($type.'-'.$program['name'])->slug()->toString()],
            [
                ...$program,
                'type' => $type,
                'sort_order' => $order,
                'is_active' => true,
            ],
        );
    }
}
