<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('jenjang')->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name', 30)->nullable();
            $table->string('age_range', 60)->nullable();
            $table->string('category', 60)->nullable();
            $table->text('summary')->nullable();
            $table->json('points')->nullable();
            $table->string('schedule')->nullable();
            $table->string('time')->nullable();
            $table->string('ratio')->nullable();
            $table->string('icon')->nullable();
            $table->text('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
