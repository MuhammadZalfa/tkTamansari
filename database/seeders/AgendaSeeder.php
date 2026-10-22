<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = [
            'ganjil' => [
                [
                    'month' => 'Juli',
                    'icon' => 'celebration',
                    'title' => 'MPLS Ceria dan Parade Balon',
                    'body' => 'Masa pengenalan lingkungan sekolah tanpa rasa takut. Disambut badut karakter edukatif dan pelepasan balon cita-cita.',
                    'focus' => 'Adaptasi emosional dan kawan baru',
                ],
                [
                    'month' => 'September',
                    'icon' => 'local_fire_department',
                    'title' => 'Kunjungan Sahabat Damkar',
                    'body' => 'Eksplorasi profesi langsung ke Kantor Pemadam Kebakaran Tasikmalaya. Mencoba semprot air dan belajar keselamatan.',
                    'focus' => 'Keselamatan dini dan profesi',
                ],
                [
                    'month' => 'Oktober',
                    'icon' => 'storefront',
                    'title' => 'Market Day dan Cooking Class',
                    'body' => 'Simulasi pasar cilik di halaman sekolah. Membuat sandwich sehat dan bertransaksi koin mainan bersama teman.',
                    'focus' => 'Numerasi nyata dan wirausaha cilik',
                ],
                [
                    'month' => 'Desember',
                    'icon' => 'theater_comedy',
                    'title' => 'Gelar Karya dan Panggung Kreasi',
                    'body' => 'Pameran lukisan kriya daur ulang serta penampilan angklung cilik di hadapan seluruh wali murid.',
                    'focus' => 'Apresiasi karya anak dan keluarga',
                ],
            ],
            'genap' => [
                [
                    'month' => 'Februari',
                    'icon' => 'nature_people',
                    'title' => 'Outbound Alam Terbuka',
                    'body' => 'Petualangan alam asri: jembatan tali ramah anak, tangkap ikan air tawar, dan uji keberanian mandiri.',
                    'focus' => 'Ketahanan fisik dan motorik',
                ],
                [
                    'month' => 'Maret',
                    'icon' => 'mosque',
                    'title' => 'Pesantren Kilat Ramadhan',
                    'body' => 'Belajar berpuasa riang, berbagi berkah takjil, dan kisah teladan para Nabi dengan boneka dongeng.',
                    'focus' => 'Adab berbagi dan spiritualitas',
                ],
                [
                    'month' => 'April',
                    'icon' => 'palette',
                    'title' => 'Festival Seni Kartini Cilik',
                    'body' => 'Parade kostum nusantara, lomba mewarnai bersama ibu, serta sajian musik tradisional daerah.',
                    'focus' => 'Cinta tanah air dan percaya diri',
                ],
                [
                    'month' => 'Juni',
                    'icon' => 'school',
                    'title' => 'Wisuda dan Pelepasan Siswa B',
                    'body' => 'Prosesi khidmat pelepasan siswa ke sekolah dasar dengan pentas tari kolosal dan penyerahan sertifikat kelulusan.',
                    'focus' => 'Transisi sekolah dasar dan apresiasi',
                ],
            ],
        ];

        foreach ($agendas as $semester => $rows) {
            foreach ($rows as $index => $row) {
                Agenda::updateOrCreate(
                    [
                        'semester' => $semester,
                        'title' => $row['title'],
                    ],
                    [
                        ...$row,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
