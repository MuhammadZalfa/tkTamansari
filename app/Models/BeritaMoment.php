<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaMoment extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'berita_id',
        'title',
        'note',
        'image',
        'sort_order',
    ];

    /**
     * @var list<string>
     */
    protected $appends = ['image_url'];

    /**
     * @return BelongsTo<Berita, $this>
     */
    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => ImageUrl::resolve($this->image));
    }
}
