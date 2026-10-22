<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galeri extends Model
{
    protected $table = 'galeri';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'galeri_kategori_id',
        'title',
        'description',
        'image',
        'location',
        'taken_on',
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
            'taken_on' => 'date',
        ];
    }

    /**
     * @return BelongsTo<GaleriKategori, $this>
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(GaleriKategori::class, 'galeri_kategori_id');
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
        return Attribute::get(fn (): ?string => $this->taken_on?->locale('id')->translatedFormat('d M Y'));
    }
}
