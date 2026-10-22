<?php

namespace Tests\Feature\Admin;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\KontakMessage;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_semua_halaman_admin_dapat_dibuka_oleh_pengguna_terautentikasi(): void
    {
        $this->actingAs(User::factory()->create());

        $urls = [
            '/admin',
            '/admin/berita',
            '/admin/berita/create',
            '/admin/galeri',
            '/admin/galeri/create',
            '/admin/program',
            '/admin/program/create',
            '/admin/agenda',
            '/admin/agenda/create',
            '/admin/guru',
            '/admin/guru/create',
            '/admin/profil',
            '/admin/kontak',
            '/admin/pesan',
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_berita_dapat_dibuat_diperbarui_dan_dihapus(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/admin/berita', [
            'title' => 'Berita baru sekolah',
            'category' => 'Kegiatan siswa',
            'excerpt' => 'Ringkasan berita baru.',
            'body' => 'Paragraf pertama.'.PHP_EOL.PHP_EOL.'Paragraf kedua.',
            'tags' => 'Kegiatan, Sekolah',
            'published' => true,
        ])->assertRedirect(route('admin.berita.index'));

        $berita = Berita::query()->firstOrFail();

        $this->assertSame('berita-baru-sekolah', $berita->slug);
        $this->assertNotNull($berita->published_at);
        $this->assertSame(['Kegiatan', 'Sekolah'], $berita->tags);

        $this->put(route('admin.berita.update', $berita), [
            'title' => 'Judul berita diperbarui',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan diperbarui.',
            'body' => 'Isi diperbarui.',
            'published' => false,
        ])->assertRedirect(route('admin.berita.index'));

        $berita->refresh();

        $this->assertSame('Judul berita diperbarui', $berita->title);
        $this->assertNull($berita->published_at);

        $this->delete(route('admin.berita.destroy', $berita))
            ->assertRedirect(route('admin.berita.index'));

        $this->assertDatabaseCount('berita', 0);
    }

    public function test_foto_galeri_dapat_diunggah(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create());

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=');

        $this->post('/admin/galeri', [
            'title' => 'Foto kegiatan baru',
            'description' => 'Dokumentasi kegiatan.',
            'location' => 'Halaman sekolah',
            'taken_on' => now()->toDateString(),
            'image' => UploadedFile::fake()->createWithContent('kegiatan.png', $png),
        ])->assertRedirect(route('admin.galeri.index'));

        $galeri = Galeri::query()->firstOrFail();

        $this->assertNotNull($galeri->image);
        Storage::disk('public')->assertExists($galeri->image);
    }

    public function test_halaman_ubah_setiap_konten_dapat_dibuka(): void
    {
        $this->actingAs(User::factory()->create());

        $berita = Berita::create([
            'slug' => 'berita-uji',
            'title' => 'Berita uji',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan.',
            'body' => 'Isi.',
        ]);

        $galeri = Galeri::create([
            'title' => 'Foto uji',
            'image' => 'https://example.com/foto.jpg',
        ]);

        $program = Program::create([
            'type' => 'jenjang',
            'name' => 'Program uji',
            'slug' => 'program-uji',
        ]);

        $agenda = Agenda::create([
            'semester' => 'ganjil',
            'month' => 'Juli',
            'title' => 'Agenda uji',
            'body' => 'Isi agenda.',
        ]);

        $teacher = Teacher::create([
            'name' => 'Guru uji',
            'role' => 'Wali Kelas',
        ]);

        $this->get("/admin/berita/{$berita->slug}/edit")->assertOk();
        $this->get("/admin/galeri/{$galeri->id}/edit")->assertOk();
        $this->get("/admin/program/{$program->id}/edit")->assertOk();
        $this->get("/admin/agenda/{$agenda->id}/edit")->assertOk();
        $this->get("/admin/guru/{$teacher->id}/edit")->assertOk();
    }

    public function test_profil_sekolah_dan_kontak_dapat_diperbarui(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/profil', [
            'sambutan' => [
                'nama' => 'Ibu Kepala Sekolah',
                'nip' => '123',
                'masa_jabatan' => '2020 - sekarang',
                'headline' => 'Sambutan hangat',
                'isi' => 'Isi sambutan.',
            ],
            'sejarah' => [
                'berdiri' => '1998',
                'judul' => 'Sejarah singkat',
                'paragraf1' => 'Paragraf pertama.',
                'paragraf2' => 'Paragraf kedua.',
                'quote' => 'Kutipan.',
                'quote_credit' => 'Sekolah',
            ],
            'visi' => [
                'utama' => 'Visi sekolah.',
                'deskripsi' => 'Deskripsi visi.',
            ],
            'misi' => [
                ['icon' => 'flag', 'title' => 'Misi pertama', 'body' => 'Isi misi.'],
            ],
            'fakta' => [
                ['label' => 'Berdiri sejak', 'value' => '1998'],
            ],
            'fasilitas' => [
                ['title' => 'Ruang kelas', 'body' => 'Ruang kelas nyaman.'],
            ],
        ])->assertRedirect(route('admin.profil.edit'));

        $this->assertSame('Visi sekolah.', SiteSetting::get('profil')['visi']['utama']);

        $this->put('/admin/kontak', [
            'telepon' => '(0265) 111-222',
            'telepon_link' => 'tel:0265111222',
            'whatsapp' => '+62 812-1111-2222',
            'whatsapp_link' => 'https://wa.me/6281211112222',
            'email' => 'sekolah@example.com',
            'alamat' => 'Jl. Uji No. 1',
            'kota' => 'Tasikmalaya',
            'maps' => 'https://maps.google.com/?q=Tasikmalaya',
            'jam' => [
                ['label' => 'Senin - Jumat', 'value' => '07.30 - 11.30 WIB', 'note' => '', 'closed' => false],
            ],
        ])->assertRedirect(route('admin.kontak.edit'));

        $this->assertSame('sekolah@example.com', SiteSetting::get('kontak')['email']);
    }

    public function test_status_pesan_dapat_diperbarui(): void
    {
        $this->actingAs(User::factory()->create());

        $message = KontakMessage::create([
            'nama_orang_tua' => 'Bunda Sarah',
            'nomor_whatsapp' => '081234567890',
            'program_interest' => 'tka',
            'status' => 'baru',
        ]);

        $this->patch(route('admin.pesan.update', $message), ['status' => 'selesai'])
            ->assertRedirect();

        $this->assertSame('selesai', $message->refresh()->status);
    }

    public function test_halaman_pesan_menyaring_status(): void
    {
        $this->actingAs(User::factory()->create());

        KontakMessage::create([
            'nama_orang_tua' => 'Bunda Baru',
            'nomor_whatsapp' => '0812',
            'program_interest' => 'tka',
            'status' => 'baru',
        ]);

        $this->get('/admin/pesan?status=selesai')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('admin/pesan/Index')
                ->has('messages', 0)
                ->where('status', 'selesai'));
    }
}
