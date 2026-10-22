<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeri_kategori_id')->nullable()->constrained('galeri_kategori')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('image');
            $table->string('location')->nullable();
            $table->date('taken_on')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
