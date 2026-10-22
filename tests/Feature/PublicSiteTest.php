<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\GaleriKategori;
use App\Models\Program;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_beranda_menampilkan_jenjang_dan_berita_terbaru(): void
    {
        Program::create([
            'type' => 'jenjang',
            'name' => 'TK Kelompok A',
            'slug' => 'tk-a',
            'is_active' => true,
        ]);

        Berita::create([
            'slug' => 'kegiatan-terbaru',
            'title' => 'Kegiatan terbaru',
            'category' => 'Kegiatan siswa',
            'excerpt' => 'Ringkasan kegiatan.',
            'body' => 'Isi berita.',
            'published_at' => now(),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Beranda')
                ->has('programs', 1)
                ->where('latestBerita.slug', 'kegiatan-terbaru'));
    }

    public function test_profil_tidak_mengirim_nama_dan_nuptk_guru(): void
    {
        Teacher::create([
            'name' => 'Ibu Rahasia',
            'role' => 'Wali Kelas TK-A',
            'focus' => 'Mendampingi anak usia 4 sampai 5 tahun.',
            'points' => ['Pencatatan perkembangan'],
            'nuptk' => '123456789',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Teacher::create([
            'name' => 'Bapak Operator',
            'role' => 'Operator Sekolah',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $this->get(route('profil'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Profil')
                ->has('teachers', 1)
                ->where('teachers.0.role', 'Wali Kelas TK-A')
                ->missing('teachers.0.name')
                ->missing('teachers.0.nuptk')
                ->missing('teachers.0.photo'));
    }

    public function test_program_menampilkan_sentra_dan_ekstrakurikuler(): void
    {
        Program::create([
            'type' => 'sentra',
            'name' => 'Sentra Balok',
            'slug' => 'sentra-balok',
            'is_active' => true,
        ]);

        Program::create([
            'type' => 'ekskul',
            'name' => 'Angklung',
            'slug' => 'angklung',
            'is_active' => true,
        ]);

        $this->get(route('program'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Program')
                ->has('programs', 2));
    }

    public function test_daftar_berita_hanya_menampilkan_yang_terbit(): void
    {
        Berita::create([
            'slug' => 'sudah-terbit',
            'title' => 'Sudah terbit',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan.',
            'body' => 'Isi.',
            'published_at' => now()->subDay(),
        ]);

        Berita::create([
            'slug' => 'masih-draft',
            'title' => 'Masih draft',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan.',
            'body' => 'Isi.',
        ]);

        $this->get(route('berita.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('berita/Index')
                ->has('berita', 1)
                ->where('berita.0.slug', 'sudah-terbit'));
    }

    public function test_berita_draft_tidak_dapat_dibuka_publik(): void
    {
        Berita::create([
            'slug' => 'masih-draft',
            'title' => 'Masih draft',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan.',
            'body' => 'Isi.',
        ]);

        $this->get(route('berita.show', 'masih-draft'))->assertNotFound();
    }

    public function test_galeri_menampilkan_kategori_dan_foto(): void
    {
        $kategori = GaleriKategori::create(['nama' => 'Kegiatan belajar', 'slug' => 'kegiatan-belajar']);

        Galeri::create([
            'galeri_kategori_id' => $kategori->id,
            'title' => 'Foto kegiatan',
            'description' => 'Deskripsi foto.',
            'image' => 'https://example.com/foto.jpg',
            'taken_on' => now(),
        ]);

        $this->get(route('galeri'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Galeri')
                ->has('items', 1)
                ->has('kategoris', 1)
                ->where('items.0.kategori.slug', 'kegiatan-belajar'));
    }
}
