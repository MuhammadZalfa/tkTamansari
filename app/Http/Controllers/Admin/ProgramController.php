<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Support\Slug;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProgramController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/program/Index', [
            'programs' => Program::query()->orderBy('type')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/program/Form', ['program' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Slug::unique($data['name'], Program::class);

        if ($request->hasFile('image')) {
            $data['image'] = Uploads::store($request->file('image'));
        }

        Program::create($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Program berhasil disimpan.']);

        return redirect()->route('admin.program.index');
    }

    public function edit(Program $program): Response
    {
        return Inertia::render('admin/program/Form', ['program' => $program]);
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Slug::unique($data['name'], Program::class, $program->id);

        if ($request->hasFile('image')) {
            Uploads::delete($program->image);
            $data['image'] = Uploads::store($request->file('image'));
        }

        $program->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Program berhasil diperbarui.']);

        return redirect()->route('admin.program.index');
    }

    public function destroy(Program $program): RedirectResponse
    {
        Uploads::delete($program->image);
        $program->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Program berhasil dihapus.']);

        return redirect()->route('admin.program.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', 'in:jenjang,pilar,sentra,ekskul'],
            'name' => ['required', 'string', 'max:150'],
            'short_name' => ['nullable', 'string', 'max:30'],
            'age_range' => ['nullable', 'string', 'max:60'],
            'category' => ['nullable', 'string', 'max:60'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'points' => ['nullable', 'string', 'max:2000'],
            'schedule' => ['nullable', 'string', 'max:150'],
            'time' => ['nullable', 'string', 'max:100'],
            'ratio' => ['nullable', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['points'] = array_values(array_filter(array_map('trim', explode("\n", (string) ($data['points'] ?? '')))));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
