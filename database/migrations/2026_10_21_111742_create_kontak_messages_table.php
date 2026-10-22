<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kontak_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_orang_tua');
            $table->string('nomor_whatsapp', 30);
            $table->string('nama_ananda')->nullable();
            $table->string('program_interest', 20);
            $table->date('tanggal_kunjungan')->nullable();
            $table->text('pesan')->nullable();
            $table->string('status', 20)->default('baru');
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_messages');
    }
};
