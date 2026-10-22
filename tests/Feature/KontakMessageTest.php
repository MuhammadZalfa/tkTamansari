<?php

namespace Tests\Feature;

use App\Models\KontakMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KontakMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nama_orang_tua' => 'Bunda Sarah Nuraini',
            'nomor_whatsapp' => '0812-3456-7890',
            'nama_ananda' => 'Aisyah (4 tahun)',
            'program_interest' => 'tka',
            'tanggal_kunjungan' => '2026-11-02',
            'pesan' => 'Mohon informasi jadwal kunjungan sekolah.',
        ], $overrides);
    }

    public function test_pesan_kontak_valid_tersimpan_dan_mengalihkan_kembali()
    {
        $response = $this->from(route('kontak'))->post(route('kontak.store'), $this->payload());

        $response->assertRedirect(route('kontak'));
        $response->assertInertiaFlash('kontak_terkirim', true);

        $this->assertDatabaseHas('kontak_messages', [
            'nama_orang_tua' => 'Bunda Sarah Nuraini',
            'nomor_whatsapp' => '0812-3456-7890',
            'program_interest' => 'tka',
            'status' => 'baru',
        ]);
    }

    public function test_field_opsional_kosong_tetap_tersimpan()
    {
        $this->from(route('kontak'))->post(route('kontak.store'), $this->payload([
            'nama_ananda' => '',
            'tanggal_kunjungan' => '',
            'pesan' => '',
        ]))->assertRedirect(route('kontak'));

        $message = KontakMessage::query()->firstOrFail();

        $this->assertNull($message->nama_ananda);
        $this->assertNull($message->tanggal_kunjungan);
        $this->assertNull($message->pesan);
    }

    public function test_pesan_kontak_tanpa_data_wajib_gagal_dan_tidak_disimpan()
    {
        $response = $this->from(route('kontak'))->post(route('kontak.store'), []);

        $response->assertRedirect(route('kontak'));
        $response->assertSessionHasErrors(['nama_orang_tua', 'nomor_whatsapp', 'program_interest']);

        $this->assertDatabaseCount('kontak_messages', 0);
    }

    public function test_program_yang_tidak_dikenal_ditolak()
    {
        $response = $this->from(route('kontak'))->post(route('kontak.store'), $this->payload([
            'program_interest' => 'program-hantu',
        ]));

        $response->assertSessionHasErrors('program_interest');

        $this->assertDatabaseCount('kontak_messages', 0);
    }

    public function test_tanggal_kunjungan_di_masa_lalu_ditolak()
    {
        $response = $this->from(route('kontak'))->post(route('kontak.store'), $this->payload([
            'tanggal_kunjungan' => '2020-01-01',
        ]));

        $response->assertSessionHasErrors('tanggal_kunjungan');

        $this->assertDatabaseCount('kontak_messages', 0);
    }
}
