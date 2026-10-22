<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Uploads
{
    public static function store(?UploadedFile $file, string $folder = 'uploads'): ?string
    {
        return $file?->store($folder, 'public');
    }

    public static function delete(?string $path): void
    {
        if ($path === null || $path === '' || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
