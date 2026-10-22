<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\ImageUrl;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfilController extends Controller
{
    public function edit(): Response
    {
        $profil = SiteSetting::get('profil');

        $profil['sambutan']['foto_url'] = ImageUrl::resolve($profil['sambutan']['foto'] ?? null);
        $profil['sejarah']['foto_url'] = ImageUrl::resolve($profil['sejarah']['foto'] ?? null);

        foreach ($profil['fasilitas'] ?? [] as $index => $fasilitas) {
            $profil['fasilitas'][$index]['image_url'] = ImageUrl::resolve($fasilitas['image'] ?? null);
        }

        return Inertia::render('admin/profil/Edit', [
            'profil' => $profil,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sambutan.nama' => ['required', 'string', 'max:100'],
            'sambutan.nip' => ['nullable', 'string', 'max:40'],
            'sambutan.masa_jabatan' => ['nullable', 'string', 'max:80'],
            'sambutan.headline' => ['nullable', 'string', 'max:300'],
            'sambutan.isi' => ['required', 'string', 'max:5000'],
            'sambutan_foto' => ['nullable', 'image', 'max:5120'],
            'sejarah.berdiri' => ['nullable', 'string', 'max:60'],
            'sejarah.judul' => ['nullable', 'string', 'max:150'],
            'sejarah.paragraf1' => ['nullable', 'string', 'max:2000'],
            'sejarah.paragraf2' => ['nullable', 'string', 'max:2000'],
            'sejarah.quote' => ['nullable', 'string', 'max:500'],
            'sejarah.quote_credit' => ['nullable', 'string', 'max:150'],
            'sejarah_foto' => ['nullable', 'image', 'max:5120'],
            'visi.utama' => ['required', 'string', 'max:1000'],
            'visi.deskripsi' => ['nullable', 'string', 'max:1000'],
            'misi' => ['array', 'max:8'],
            'misi.*.icon' => ['nullable', 'string', 'max:60'],
            'misi.*.title' => ['required', 'string', 'max:150'],
            'misi.*.body' => ['required', 'string', 'max:500'],
            'fakta' => ['array', 'max:8'],
            'fakta.*.label' => ['required', 'string', 'max:60'],
            'fakta.*.value' => ['required', 'string', 'max:60'],
            'fasilitas' => ['array', 'max:8'],
            'fasilitas.*.title' => ['required', 'string', 'max:150'],
            'fasilitas.*.body' => ['required', 'string', 'max:500'],
            'fasilitas.*.image' => ['nullable', 'string', 'max:2048'],
            'fasilitas.*.image_file' => ['nullable', 'image', 'max:5120'],
        ]);

        $existing = SiteSetting::get('profil');

        $profil = [
            'sambutan' => [
                ...($data['sambutan'] ?? []),
                'foto' => Uploads::store($request->file('sambutan_foto'))
                    ?? ($existing['sambutan']['foto'] ?? null),
            ],
            'sejarah' => [
                ...($data['sejarah'] ?? []),
                'foto' => Uploads::store($request->file('sejarah_foto'))
                    ?? ($existing['sejarah']['foto'] ?? null),
            ],
            'visi' => $data['visi'],
            'misi' => array_values($data['misi'] ?? []),
            'fakta' => array_values($data['fakta'] ?? []),
            'fasilitas' => collect($data['fasilitas'] ?? [])->values()->map(function (array $item, int $index) use ($request): array {
                return [
                    'title' => $item['title'],
                    'body' => $item['body'],
                    'image' => Uploads::store($request->file("fasilitas.$index.image_file")) ?? ($item['image'] ?? null),
                ];
            })->all(),
        ];

        SiteSetting::put('profil', $profil);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Profil sekolah berhasil disimpan.']);

        return redirect()->route('admin.profil.edit');
    }
}
