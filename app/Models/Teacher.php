<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'focus',
        'points',
        'nuptk',
        'education',
        'photo',
        'is_active',
        'sort_order',
    ];

    /**
     * @var list<string>
     */
    protected $appends = ['photo_url'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'points' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Teacher>  $query
     * @return Builder<Teacher>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => ImageUrl::resolve($this->photo));
    }
}
