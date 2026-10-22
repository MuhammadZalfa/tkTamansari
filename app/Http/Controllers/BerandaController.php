<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Program;
use Inertia\Inertia;
use Inertia\Response;

class BerandaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Beranda', [
            'programs' => Program::query()
                ->active()
                ->where('type', 'jenjang')
                ->orderBy('sort_order')
                ->get(),
            'latestBerita' => Berita::query()->published()->latest('published_at')->first(),
        ]);
    }
}
