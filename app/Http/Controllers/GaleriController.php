<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\GaleriKategori;
use Inertia\Inertia;
use Inertia\Response;

class GaleriController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Galeri', [
            'kategoris' => GaleriKategori::query()->orderBy('nama')->get(),
            'items' => Galeri::query()->with('kategori:id,slug,nama')->latest('taken_on')->get(),
        ]);
    }
}
