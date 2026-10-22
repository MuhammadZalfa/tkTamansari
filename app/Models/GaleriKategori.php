<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GaleriKategori extends Model
{
    protected $table = 'galeri_kategori';

    /**
     * @var list<string>
     */
    protected $fillable = ['slug', 'nama'];

    /**
     * @return HasMany<Galeri, $this>
     */
    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class);
    }
}
