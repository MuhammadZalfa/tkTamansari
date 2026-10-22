<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PesanController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->string('status')->toString();

        return Inertia::render('admin/pesan/Index', [
            'messages' => KontakMessage::query()
                ->when(in_array($status, ['baru', 'diproses', 'selesai'], true), fn ($query) => $query->where('status', $status))
                ->latest()
                ->get(),
            'status' => $status,
        ]);
    }

    public function update(Request $request, KontakMessage $pesan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai'],
        ]);

        $pesan->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Status pesan diperbarui.']);

        return back();
    }

    public function destroy(KontakMessage $pesan): RedirectResponse
    {
        $pesan->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Pesan berhasil dihapus.']);

        return back();
    }
}
