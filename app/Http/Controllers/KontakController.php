<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontakMessageRequest;
use App\Models\KontakMessage;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class KontakController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Kontak');
    }

    /**
     * Simpan pesan dari formulir kontak publik.
     */
    public function store(StoreKontakMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (['nama_ananda', 'tanggal_kunjungan', 'pesan'] as $optional) {
            if (empty($data[$optional])) {
                unset($data[$optional]);
            }
        }

        KontakMessage::create($data);

        Inertia::flash('kontak_terkirim', true);

        return redirect()->route('kontak');
    }
}
