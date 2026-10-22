<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\GaleriKategori;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GaleriController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/galeri/Index', [
            'items' => Galeri::query()->with('kategori:id,nama')->latest('taken_on')->get(),
            'kategoris' => GaleriKategori::query()->orderBy('nama')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/galeri/Form', [
            'item' => null,
            'kategoris' => GaleriKategori::query()->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = Uploads::store($request->file('image'));

        Galeri::create($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Foto galeri berhasil ditambahkan.']);

        return redirect()->route('admin.galeri.index');
    }

    public function edit(Galeri $galeri): Response
    {
        return Inertia::render('admin/galeri/Form', [
            'item' => $galeri,
            'kategoris' => GaleriKategori::query()->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Galeri $galeri): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            Uploads::delete($galeri->image);
            $data['image'] = Uploads::store($request->file('image'));
        }

        $galeri->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Foto galeri berhasil diperbarui.']);

        return redirect()->route('admin.galeri.index');
    }

    public function destroy(Galeri $galeri): RedirectResponse
    {
        Uploads::delete($galeri->image);
        $galeri->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Foto galeri berhasil dihapus.']);

        return redirect()->route('admin.galeri.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'galeri_kategori_id' => ['nullable', 'exists:galeri_kategori,id'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:100'],
            'taken_on' => ['nullable', 'date'],
            'image' => [$request->isMethod('post') ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);
    }
}
