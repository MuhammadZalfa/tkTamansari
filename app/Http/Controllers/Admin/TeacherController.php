<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/guru/Index', [
            'teachers' => Teacher::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/guru/Form', ['teacher' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = Uploads::store($request->file('photo'));
        }

        Teacher::create($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Data pendidik berhasil disimpan.']);

        return redirect()->route('admin.guru.index');
    }

    public function edit(Teacher $guru): Response
    {
        return Inertia::render('admin/guru/Form', ['teacher' => $guru]);
    }

    public function update(Request $request, Teacher $guru): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            Uploads::delete($guru->photo);
            $data['photo'] = Uploads::store($request->file('photo'));
        }

        $guru->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Data pendidik berhasil diperbarui.']);

        return redirect()->route('admin.guru.index');
    }

    public function destroy(Teacher $guru): RedirectResponse
    {
        Uploads::delete($guru->photo);
        $guru->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Data pendidik berhasil dihapus.']);

        return redirect()->route('admin.guru.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'role' => ['required', 'string', 'max:150'],
            'focus' => ['nullable', 'string', 'max:500'],
            'points' => ['nullable', 'string', 'max:1000'],
            'nuptk' => ['nullable', 'string', 'max:30'],
            'education' => ['nullable', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['points'] = array_values(array_filter(array_map('trim', explode("\n", (string) ($data['points'] ?? '')))));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
