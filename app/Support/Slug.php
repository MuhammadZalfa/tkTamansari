<?php

namespace App\Support;

use Illuminate\Support\Str;

class Slug
{
    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     */
    public static function unique(string $value, string $model, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $counter = 2;

        while ($model::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
