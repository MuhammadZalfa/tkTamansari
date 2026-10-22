<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\KontakMessage;
use App\Models\Program;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'berita' => Berita::query()->count(),
                'berita_terbit' => Berita::query()->published()->count(),
                'galeri' => Galeri::query()->count(),
                'program' => Program::query()->active()->count(),
                'pesan_baru' => KontakMessage::query()->where('status', 'baru')->count(),
            ],
            'recentBerita' => Berita::query()
                ->latest('created_at')
                ->take(5)
                ->get(['id', 'slug', 'title', 'category', 'published_at']),
            'recentMessages' => KontakMessage::query()->latest()->take(5)->get(),
        ]);
    }
}
