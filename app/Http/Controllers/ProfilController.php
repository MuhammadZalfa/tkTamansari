<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Support\ImageUrl;
use Inertia\Inertia;
use Inertia\Response;

class ProfilController extends Controller
{
    public function index(): Response
    {
        $profil = SiteSetting::get('profil');

        foreach (['sambutan', 'sejarah'] as $section) {
            if (isset($profil[$section]['foto'])) {
                $profil[$section]['foto'] = ImageUrl::resolve($profil[$section]['foto']);
            }
        }

        foreach ($profil['fasilitas'] ?? [] as $index => $fasilitas) {
            $profil['fasilitas'][$index]['image'] = ImageUrl::resolve($fasilitas['image'] ?? null);
        }

        return Inertia::render('Profil', [
            'profil' => $profil,
            // Nama, NUPTK, dan foto pendidik sengaja tidak dikirim ke halaman publik.
            'teachers' => Teacher::query()
                ->active()
                ->whereNotNull('focus')
                ->orderBy('sort_order')
                ->get(['id', 'role', 'focus', 'points']),
        ]);
    }
}
