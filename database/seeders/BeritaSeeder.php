<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $berita = Berita::updateOrCreate(
            ['slug' => 'hari-kartini-2024'],
            [
                'title' => 'Peringatan Hari Kartini 2024: Parade Pakaian Adat Ceria Siswa TK Tamansari',
                'category' => 'Kegiatan siswa',
                'excerpt' => 'Seluruh murid dari Kelompok Bermain hingga Kelas B mengenakan pakaian adat dari berbagai penjuru nusantara dalam parade mini di halaman sekolah.',
                'body' => implode("\n\n", [
                    'Suasana ceria dan penuh warna menyelimuti halaman utama TK PGRI Tamansari pada peringatan Hari Kartini tahun ini. Seluruh murid dari Kelompok Bermain (KB), Kelas A, dan Kelas B tampak begitu antusias mengenakan pakaian adat dari berbagai penjuru nusantara, mulai dari kebaya Jawa yang anggun, baju adat Minang dengan suntiang mini, hingga kain ulos khas Batak yang menawan.',
                    'Acara tahunan ini tak sekadar seremonial perlombaan kostum, melainkan sarana edukasi kontekstual agar anak mengenal kebinekaan Indonesia sejak usia emas. Anak-anak didorong memahami bahwa berbeda baju adat, bahasa, dan latar belakang suku, mereka tetap adalah sahabat satu nusa yang saling menyayangi.',
                    'Antusiasme luar biasa juga diperlihatkan oleh para orang tua murid dan Komite Sekolah. Sejak pukul 07.30 WIB, halaman sekolah sudah dipadati senyum manis anak-anak yang berbaris rapi mengikuti pawai mini mengelilingi area taman sekolah dengan iringan musik gamelan dan lagu anak bernuansa kebangsaan.',
                ]),
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDOHfquqDQyFu92U6G0lhFHX9f2UOB8jklahUQ_OwXfaI9RQi8BnKzS8kVerAlvxno7e0vN7fR0hMaySPZGVoXFNTlsYPsshxcM2RA-h7Np6vrqFv-gcKNOZPMawyfmXa7y0B_dd5zA_5zC4ljFa2E05wclAhFfxLB6d4uBbeGL_7TxWRCdwlLNt7mio39iKqw-veXVz5ZA59WMGxxerambUtttJRdaO6UEzbfy8041h6Ky8RV1U_sy',
                'image_alt' => 'Parade budaya TK PGRI Tamansari saat peringatan Hari Kartini',
                'image_caption' => 'Dokumentasi keceriaan parade budaya nusantara murid KB dan TK PGRI Tamansari.',
                'quote' => 'Pendidikan anak usia dini merupakan pondasi utama pembentukan karakter, rasa cinta tanah air, dan panggung ekspresi kreativitas masa depan.',
                'quote_attribution' => 'Pesan sekolah untuk orang tua',
                'tags' => ['Hari Kartini', 'Kegiatan siswa', 'Pentas seni', 'Budaya nusantara'],
                'published_at' => '2024-10-24 08:00:00',
            ],
        );

        $berita->moments()->delete();

        $moments = [
            [
                'title' => 'Lomba menyanyi bersama',
                'note' => 'Ekspresi vokal ceria anak di panggung utama.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC9bdZ33c_uulfiHZnF3PUEE-BgP7ZyZC5VWOw0RmyUrkhrv5UrM5pFtDF-ymnTgpqfI6WLmnCfhaX1of47oBN5U2fm4uQOZWxPXf-jLuDbd7IK1MyH4cPKgtJNZ2SnOMqR1sumxVcmGXMEqB2pfZl7v0YB27GghESJlTgllgqYGH0xnG9Tokerk-sugTPB-88VOXi03ItkBsTAhUPOPAlQEHjkj1ctXZMVlipAjiGpJc7nEhhwHuGA',
            ],
            [
                'title' => 'Mewarnai motif batik',
                'note' => 'Eksplorasi motorik halus dan seni visual anak.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDzI4ANMj9CKvdFpGvkDgLbiaMUj_TqY2aJ3bj1_55P6BV0awubaaEPB84D6Nv2uk1ZtAbz1_2UdF5RDOEXev9cUKvfiK5pupmUXDPP8ihXsoR_x0bsd5IIWyX90W1K8TnRKt729Yed53tTOEB_yFwRI3hgiDiEDjtnVyeHThtI2XN9pMODY5eEboTunBP0pgWYep9pN-XZlezK9yrbqrJZHyfEAQl_HTJ-xjSm6iHqz8ussZ1Hu802',
            ],
            [
                'title' => 'Kolaborasi guru dan komite',
                'note' => 'Kehangatan partisipasi sekolah dalam kegiatan anak.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD2IwJ7yL_ihRzVy9LyKASaGetURrBFdJantZq0pEdCQEK6WEGqV685JCbzvRN95HG0f5PnFhwxI1HtE1dmlgycaPGbpzi_ZfnDTxaoxeVThikhHTyZQy9Eu6tsS-m8uVSLxu-x1OLvKt1FFazWhOnX7OiWEdRn8Xtmo0vt4kddClsl14dMBF7mluRgeqP97ypRImrSgEn4mi8WPrmUhDDdvOBNBS1PuAYLP1OE2YEAs-8USfx3_XUV',
            ],
        ];

        foreach ($moments as $index => $moment) {
            $berita->moments()->create([
                ...$moment,
                'sort_order' => $index,
            ]);
        }
    }
}
