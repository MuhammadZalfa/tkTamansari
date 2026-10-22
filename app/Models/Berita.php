<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Berita extends Model
{
    protected $table = 'berita';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'title',
        'category',
        'excerpt',
        'body',
        'image',
        'image_alt',
        'image_caption',
        'quote',
        'quote_attribution',
        'tags',
        'published_at',
    ];

    /**
     * @var list<string>
     */
    protected $appends = ['image_url', 'date_label'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<BeritaMoment, $this>
     */
    public function moments(): HasMany
    {
        return $this->hasMany(BeritaMoment::class)->orderBy('sort_order');
    }

    /**
     * @param  Builder<Berita>  $query
     * @return Builder<Berita>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => ImageUrl::resolve($this->image));
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function dateLabel(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->published_at?->locale('id')->translatedFormat('j F Y'));
    }
}
