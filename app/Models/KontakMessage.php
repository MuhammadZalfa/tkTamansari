<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_orang_tua',
        'nomor_whatsapp',
        'nama_ananda',
        'program_interest',
        'tanggal_kunjungan',
        'pesan',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }
}
