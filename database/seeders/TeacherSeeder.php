<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Ibu Sri Rahayu, S.Pd',
                'role' => 'Kepala Sekolah & Guru Sentra Religi',
                'focus' => 'Menjaga arah kurikulum, tata kelola kelas, dan komunikasi dengan orang tua.',
                'points' => ['Perencanaan pembelajaran semester', 'Pendampingan wali kelas', 'Kemitraan dengan komite sekolah'],
                'nuptk' => '19780412 200801 2 006',
                'education' => 'S1 PG-PAUD UPI Bandung',
                'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop',
            ],
            [
                'name' => 'Ibu Rina Kurniasih, S.Pd',
                'role' => 'Wali Kelas Kelompok Bermain (KB) & Sentra Main Peran',
                'focus' => 'Mendampingi anak usia 3 sampai 4 tahun pada masa adaptasi dan kemandirian awal.',
                'points' => ['Pembiasaan toilet dan makan mandiri', 'Sosialisasi berpasangan dan berbagi mainan', 'Pencatatan perkembangan harian'],
                'nuptk' => '19900918 201601 2 005',
                'education' => 'S1 Psikologi Perkembangan Anak Unpad',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop',
            ],
            [
                'name' => 'Ibu Maya Astuti, S.Pd',
                'role' => 'Wali Kelas TK-A & Sentra Seni Bahan Alam',
                'focus' => 'Menemani anak usia 4 sampai 5 tahun pada tahap eksplorasi dan kemandirian awal.',
                'points' => ['Sentra bermain dan projek motorik', 'Pengenalan huruf dan angka', 'Pencatatan perkembangan harian'],
                'nuptk' => '19850615 201201 2 008',
                'education' => 'S1 Pendidikan Seni Tari & Rupa UNY',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop',
            ],
            [
                'name' => 'Ibu Hj. Siti Maryam, S.Pd.I',
                'role' => 'Wali Kelas TK-B & Sentra Persiapan Calistung Halus',
                'focus' => 'Menyiapkan anak usia 5 sampai 6 tahun untuk transisi ke sekolah dasar.',
                'points' => ['Latihan literasi dan numerasi', 'Kebiasaan berbaris dan mandiri', 'Persiapan transisi PAUD ke SD'],
                'nuptk' => '19820320 201001 2 012',
                'education' => 'S1 Pendidikan Agama Islam UIN SGD Bandung',
                'photo' => 'https://images.unsplash.com/photo-1580894732488-812e96030c6a?q=80&w=200&auto=format&fit=crop',
            ],
            [
                'name' => 'Bapak Deden Hendrawan, S.Kom',
                'role' => 'Operator Dapodik & Administrator Sekolah',
                'focus' => null,
                'points' => null,
                'nuptk' => '19921105 201901 1 004',
                'education' => 'S1 Teknik Informatika Unsil Tasikmalaya',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
            ],
            [
                'name' => 'Ibu Enok Komalasari',
                'role' => 'Staf Kebersihan & Tata Usaha Penunjang',
                'focus' => null,
                'points' => null,
                'nuptk' => 'Honor Tetap Yayasan PGRI',
                'education' => 'SMA Negeri 3 Tasikmalaya',
                'photo' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?q=80&w=200&auto=format&fit=crop',
            ],
        ];

        foreach ($teachers as $index => $teacher) {
            Teacher::updateOrCreate(
                ['name' => $teacher['name']],
                [
                    ...$teacher,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
