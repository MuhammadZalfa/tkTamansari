<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Support\Slug;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BeritaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/berita/Index', [
            'berita' => Berita::query()->latest('created_at')->get(['id', 'slug', 'title', 'category', 'image', 'published_at']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/berita/Form', [
            'berita' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Slug::unique($data['title'], Berita::class);

        if ($request->hasFile('image')) {
            $data['image'] = Uploads::store($request->file('image'));
        }

        $data['published_at'] = $request->boolean('published') ? now() : null;

        $berita = Berita::create($data);

        $this->syncMoments($berita, $request);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Berita berhasil disimpan.']);

        return redirect()->route('admin.berita.index');
    }

    public function edit(Berita $berita): Response
    {
        $berita->load('moments');

        return Inertia::render('admin/berita/Form', [
            'berita' => $berita,
        ]);
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Slug::unique($data['title'], Berita::class, $berita->id);

        if ($request->hasFile('image')) {
            Uploads::delete($berita->image);
            $data['image'] = Uploads::store($request->file('image'));
        }

        $data['published_at'] = $request->boolean('published')
            ? ($berita->published_at ?? now())
            : null;

        $berita->update($data);

        $this->syncMoments($berita, $request);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Berita berhasil diperbarui.']);

        return redirect()->route('admin.berita.index');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        Uploads::delete($berita->image);
        $berita->moments()->each(fn ($moment) => Uploads::delete($moment->image));
        $berita->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Berita berhasil dihapus.']);

        return redirect()->route('admin.berita.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:60'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:200'],
            'image_caption' => ['nullable', 'string', 'max:200'],
            'quote' => ['nullable', 'string', 'max:1000'],
            'quote_attribution' => ['nullable', 'string', 'max:150'],
            'tags' => ['nullable', 'string', 'max:255'],
            'moments' => ['nullable', 'array', 'max:6'],
            'moments.*.title' => ['nullable', 'string', 'max:150'],
            'moments.*.note' => ['nullable', 'string', 'max:150'],
            'moments.*.existing_image' => ['nullable', 'string', 'max:2048'],
            'moments.*.image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['tags'] = array_values(array_filter(array_map('trim', explode(',', (string) ($data['tags'] ?? '')))));

        unset($data['moments']);

        return $data;
    }

    private function syncMoments(Berita $berita, Request $request): void
    {
        $berita->moments()->delete();

        foreach ($request->input('moments', []) as $index => $moment) {
            $image = Uploads::store($request->file("moments.$index.image")) ?? ($moment['existing_image'] ?? null);

            if (empty($moment['title']) || empty($image)) {
                continue;
            }

            $berita->moments()->create([
                'title' => $moment['title'],
                'note' => $moment['note'] ?? null,
                'image' => $image,
                'sort_order' => $index,
            ]);
        }
    }
}
