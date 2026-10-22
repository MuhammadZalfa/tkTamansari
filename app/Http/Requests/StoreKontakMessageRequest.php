<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKontakMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_orang_tua' => ['required', 'string', 'max:100'],
            'nomor_whatsapp' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\- ]+$/'],
            'nama_ananda' => ['nullable', 'string', 'max:100'],
            'program_interest' => ['required', 'string', Rule::in(['kb', 'tka', 'tkb', 'trial', 'umum'])],
            'tanggal_kunjungan' => ['nullable', 'date', 'after_or_equal:today'],
            'pesan' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_orang_tua.required' => 'Nama orang tua atau wali wajib diisi.',
            'nama_orang_tua.max' => 'Nama orang tua atau wali maksimal 100 karakter.',
            'nomor_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'nomor_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, dan tanda hubung.',
            'nomor_whatsapp.max' => 'Nomor WhatsApp maksimal 30 karakter.',
            'nama_ananda.max' => 'Nama ananda maksimal 100 karakter.',
            'program_interest.required' => 'Pilih program atau layanan yang diminati.',
            'program_interest.in' => 'Pilihan program tidak dikenal.',
            'tanggal_kunjungan.date' => 'Tanggal kunjungan tidak valid.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'pesan.max' => 'Pesan maksimal 2000 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_orang_tua' => 'nama orang tua atau wali',
            'nomor_whatsapp' => 'nomor WhatsApp',
            'nama_ananda' => 'nama ananda',
            'program_interest' => 'program',
            'tanggal_kunjungan' => 'tanggal kunjungan',
            'pesan' => 'pesan',
        ];
    }
}
