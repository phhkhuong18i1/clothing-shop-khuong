<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('phone', 40)->nullable();
            $table->string('email', 180)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('instagram_url', 2048)->nullable();
            $table->string('zalo_url', 2048)->nullable();
            $table->string('messenger_url', 2048)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
