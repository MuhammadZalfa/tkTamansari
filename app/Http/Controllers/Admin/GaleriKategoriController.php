<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKategori;
use App\Support\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GaleriKategoriController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:60'],
        ]);

        GaleriKategori::create([
            'nama' => $data['nama'],
            'slug' => Slug::unique($data['nama'], GaleriKategori::class),
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Kategori galeri berhasil ditambahkan.']);

        return redirect()->route('admin.galeri.index');
    }

    public function destroy(GaleriKategori $kategori): RedirectResponse
    {
        $kategori->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Kategori galeri berhasil dihapus.']);

        return redirect()->route('admin.galeri.index');
    }
}
