<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id(); $table->foreignId('category_id')->constrained()->restrictOnDelete(); $table->string('name', 180); $table->string('slug')->unique();
            $table->string('sku', 80)->nullable()->unique(); $table->text('description')->nullable(); $table->decimal('price', 10, 2); $table->decimal('sale_price', 10, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0); $table->json('sizes')->nullable(); $table->json('colors')->nullable(); $table->boolean('is_published')->default(false); $table->boolean('is_featured')->default(false); $table->timestamps();
            $table->index(['is_published', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
