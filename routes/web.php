<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\GaleriKategoriController;
use App\Http\Controllers\Admin\KontakSettingController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

// Public school website
Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/program', [ProgramController::class, 'index'])->name('program');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('kontak.store');

// Admin portal
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('berita', AdminBeritaController::class)->except('show')->parameters(['berita' => 'berita']);
        Route::resource('galeri', AdminGaleriController::class)->except('show');
        Route::post('galeri/kategori', [GaleriKategoriController::class, 'store'])->name('galeri.kategori.store');
        Route::delete('galeri/kategori/{kategori}', [GaleriKategoriController::class, 'destroy'])->name('galeri.kategori.destroy');
        Route::resource('program', AdminProgramController::class)->except('show');
        Route::resource('agenda', AgendaController::class)->except('show');
        Route::resource('guru', TeacherController::class)->except('show');

        Route::get('profil', [AdminProfilController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [AdminProfilController::class, 'update'])->name('profil.update');

        Route::get('kontak', [KontakSettingController::class, 'edit'])->name('kontak.edit');
        Route::put('kontak', [KontakSettingController::class, 'update'])->name('kontak.update');

        Route::get('pesan', [PesanController::class, 'index'])->name('pesan.index');
        Route::patch('pesan/{pesan}', [PesanController::class, 'update'])->name('pesan.update');
        Route::delete('pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');
    });
});

require __DIR__.'/settings.php';
