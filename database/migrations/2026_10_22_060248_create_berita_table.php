<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category', 60);
            $table->text('excerpt');
            $table->longText('body');
            $table->text('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_caption')->nullable();
            $table->text('quote')->nullable();
            $table->string('quote_attribution')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
