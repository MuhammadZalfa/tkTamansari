<?php

namespace Database\Seeders;

use App\Models\Galeri;
use App\Models\GaleriKategori;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = collect([
            ['slug' => 'belajar', 'nama' => 'Kegiatan belajar tematik'],
            ['slug' => 'seni', 'nama' => 'Pentas seni dan budaya'],
            ['slug' => 'outing', 'nama' => 'Outing class dan kunjungan'],
            ['slug' => 'keluarga', 'nama' => 'Keluarga dan komite'],
        ])->mapWithKeys(fn (array $kategori): array => [
            $kategori['slug'] => GaleriKategori::updateOrCreate(
                ['slug' => $kategori['slug']],
                ['nama' => $kategori['nama']],
            ),
        ]);

        $items = [
            [
                'title' => 'Parade Busana Adat Nusantara Cilik',
                'description' => 'Keceriaan murid mengenakan busana adat Nusantara melatih keberanian tampil percaya diri.',
                'category' => 'seni',
                'taken_on' => '2024-10-24',
                'location' => 'Halaman utama',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBmVm4CCyTAmgr358gm6bkSFmcjSSTR7qkGWnZ0myNZtxGvSgt-QlDvZZ2Nw5kqAjlth09oITkNEiNqeGx8jQEWBdS3IorSxf1soxcMYRGhkD8RL973zV88_t5joAkufO2wyoblhpimYOLzzmKoac8TWNEDX0vvYCUXVUEFVwqjKoLh9qykEiaALVsV_tJXHttFS24Zgj3HVhRqjdxoLPY7I67pEcIozYQX3HMaMG1UCL6KnxmISfpt',
            ],
            [
                'title' => 'Eksplorasi Sains Mini di Kebun Sekolah',
                'description' => 'Mengamati siklus hidup tanaman dan tekstur daun dengan kaca pembesar untuk memantik rasa ingin tahu.',
                'category' => 'belajar',
                'taken_on' => '2024-10-15',
                'location' => 'Kebun hidroponik',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnwED_inow7Ruw_VKpsElQY1k5cTQ3jExFUPdaO7U6Q3PTFpv7Z-U0JMNZGyjT4KQjhaWZ7TfSQHUkA-tZnSxJ2qvVc88ruQJeoo4kCL9anpJyAlTBIjMiajMjNOo8PG22pCVI3kZPusZl3RFNxKbv3WlrFBTnMAyTTwNWK7LIPLZNJf15yzdkgOKQhjje7gL5SFlyrGNKXsS9mVJQnSncxs2-YQ5aDvL5ZQZQk00i_G5xAbBE1yTU',
            ],
            [
                'title' => 'Kunjungan Edukasi Pemadam Kebakaran',
                'description' => 'Simulasi pemadaman api, menyiram air dengan selang, dan mengenal profesi tanggap bencana.',
                'category' => 'outing',
                'taken_on' => '2024-10-08',
                'location' => 'Pos damkar kota',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDwPoLjYXGNlpqbUO9mosUi9DICm9PwYXLCRiAkvw-_T3r0-ivG3BCiWZ1iIpVMsOelsC9N2txBu3lEl9UBRiuFXtMt-o_7vbKUdjndr_5kTHuFt3mRBNW2nwRCGKbQZDoqFnaoi_aDMMRahO7OPwc7mDS1BiQwg6HaSaZepirK0ZfmiQtnYrK-Jui97kl3UnnZZNBGZDx7Krc_R1tLj4aQSSM2LbVAtietZFoPO0TE99GbBnEPr2-1',
            ],
            [
                'title' => 'Kreasi Melukis Jari',
                'description' => 'Menstimulasi sensorik taktil dan ekspresi warna bebas ananda lewat seni melukis jari.',
                'category' => 'seni',
                'taken_on' => '2024-09-28',
                'location' => 'Ruang seni kreatif',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDopHlnls6Hfp74Yo8MP-PW0UusO-3uniiSHwlY277cfeKix-hsBCCCBxMP7WsYoEp4pgw1kqQWXdm6Jnhpo0QEs1E8WaMQfyLQwLu4j8mb5Flo7jx-XngmlC_epV5MwEmmtw5ddyr09IQDeN115hn_B8MHL1K4yFWLMIMs4yX_E5g_56HA5Q1_G44MqJEpf0dzeBmgHCqjbK5pWg2otiuLJlMs4l-1E1Hciojem7kgYuXHi4wl4RZz',
            ],
            [
                'title' => 'Senam Irama Ceria Pagi Hari',
                'description' => 'Membangun kebugaran fisik dan keceriaan dengan gerakan motorik kasar yang dipandu musik riang.',
                'category' => 'belajar',
                'taken_on' => null,
                'location' => 'Lapangan rumput',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDnuoNbbh-WFAnw1zTw7k6MlQYpnPNSth5X_Df4WYmcdCidfYBEfxhv2y7cGRVf7yQgHsnTWnk8lu0Yhy92Dv2Q2J7j1f9pecYzC3l0uoHFxGq-fomaSHtBX3Ltmgt3MyoDL0Z6GUsnoA5Y9hXgMxohmA6qJ5E2B6JxQPUVvZo8FK7_IMqKl2CHwDBWWyAEsjrNtMkl5NbBzSJB6jQxz8tI0tdwQtpl_Xf9qi_aIUPfxIzsx4hOzoDQ',
            ],
            [
                'title' => 'Momen Literasi dan Dongeng Bersama',
                'description' => 'Sesi mendongeng fabel ceria di perpustakaan ramah balita yang hangat dan interaktif.',
                'category' => 'belajar',
                'taken_on' => '2024-09-20',
                'location' => 'Perpustakaan mini',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD1aeVh6d4b42uvjYZ6CzN7bmMaWK8h-welbYUt69y21Dx__F-K6flpqObQA5REaLYlRKLfhmUg8hyD6ZnJx2vIyHTap5OHrAO5Euwz5BOrzo0K6g8iTQWw2mYKpjLg4-nllwy9Ni2C5tTfIwDF_NHb6vdMxm2HhGgHT1nQ6utlt_rT7sUQH8efQQEb_yLF2fThCryptyZ8GUUxic-VN_YiBT4i_uVCWaXZPOmuGkAcQle-_5gWCXJN',
            ],
        ];

        foreach ($items as $item) {
            $kategori = $kategoris[$item['category']];
            unset($item['category']);

            Galeri::updateOrCreate(
                ['title' => $item['title']],
                [
                    ...$item,
                    'galeri_kategori_id' => $kategori->id,
                ],
            );
        }
    }
}
