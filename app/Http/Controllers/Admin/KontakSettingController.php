<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KontakSettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/kontak/Edit', [
            'kontak' => SiteSetting::get('kontak'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'telepon' => ['required', 'string', 'max:40'],
            'telepon_link' => ['required', 'string', 'max:60'],
            'whatsapp' => ['required', 'string', 'max:40'],
            'whatsapp_link' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:100'],
            'alamat' => ['required', 'string', 'max:200'],
            'kota' => ['required', 'string', 'max:200'],
            'maps' => ['required', 'url', 'max:500'],
            'jam' => ['required', 'array', 'max:7'],
            'jam.*.label' => ['required', 'string', 'max:60'],
            'jam.*.value' => ['required', 'string', 'max:60'],
            'jam.*.note' => ['nullable', 'string', 'max:100'],
            'jam.*.closed' => ['boolean'],
        ]);

        $data['jam'] = collect($data['jam'])->map(fn (array $row): array => [
            'label' => $row['label'],
            'value' => $row['value'],
            'note' => $row['note'] ?? '',
            'closed' => (bool) ($row['closed'] ?? false),
        ])->values()->all();

        SiteSetting::put('kontak', $data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Kontak sekolah berhasil disimpan.']);

        return redirect()->route('admin.kontak.edit');
    }
}
