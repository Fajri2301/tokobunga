<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->string('image')->nullable();
            $table->string('creativity_title')->nullable();
            $table->string('creativity_subtitle')->nullable();
            $table->text('creativity_description')->nullable();
            $table->string('image_creativity_left')->nullable();
            $table->string('image_creativity_right')->nullable();
            $table->string('experience_years')->default('10+');
            $table->string('clients_count')->default('5K+');
            $table->string('fresh_flowers_pct')->default('100%');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
