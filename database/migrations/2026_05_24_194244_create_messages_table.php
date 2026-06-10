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
        Schema::create('messages', function (Blueprint $box) {
            $box->id();
            $box->string('session_id')->index();
            $box->enum('sender_type', ['customer', 'admin', 'bot'])->default('customer');
            $box->text('message');
            $box->boolean('is_read')->default(false);
            $box->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
