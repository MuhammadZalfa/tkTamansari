<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgendaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/agenda/Index', [
            'agendas' => Agenda::query()->orderBy('semester')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/agenda/Form', ['agenda' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        Agenda::create($this->validated($request));

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Agenda berhasil disimpan.']);

        return redirect()->route('admin.agenda.index');
    }

    public function edit(Agenda $agenda): Response
    {
        return Inertia::render('admin/agenda/Form', ['agenda' => $agenda]);
    }

    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $agenda->update($this->validated($request));

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Agenda berhasil diperbarui.']);

        return redirect()->route('admin.agenda.index');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Agenda berhasil dihapus.']);

        return redirect()->route('admin.agenda.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'semester' => ['required', 'in:ganjil,genap'],
            'month' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:1000'],
            'focus' => ['nullable', 'string', 'max:150'],
            'icon' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
