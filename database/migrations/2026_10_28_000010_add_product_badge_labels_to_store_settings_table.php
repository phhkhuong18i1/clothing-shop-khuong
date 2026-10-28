<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table): void {
            $table->string('badge_featured', 60)->nullable()->default('Sản phẩm nổi bật');
            $table->string('badge_best_seller', 60)->nullable()->default('Bán chạy');
            $table->string('badge_sale', 60)->nullable()->default('Sale');
        });
    }

    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table): void {
            $table->dropColumn(['badge_featured', 'badge_best_seller', 'badge_sale']);
        });
    }
};
