<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Inertia\Inertia;
use Inertia\Response;

class BeritaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('berita/Index', [
            'berita' => Berita::query()->published()->latest('published_at')->get(),
        ]);
    }

    public function show(Berita $berita): Response
    {
        abort_unless($berita->published_at !== null && $berita->published_at->isPast(), 404);

        $berita->load('moments');

        return Inertia::render('berita/Show', [
            'berita' => $berita,
        ]);
    }
}
