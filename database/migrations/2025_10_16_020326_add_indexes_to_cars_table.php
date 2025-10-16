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
        Schema::table('cars', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_available');
            $table->index(['status', 'is_available']);
            $table->index('type');
            $table->index('location');
            $table->index('price_per_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_available']);
            $table->dropIndex(['status', 'is_available']);
            $table->dropIndex(['type']);
            $table->dropIndex(['location']);
            $table->dropIndex(['price_per_day']);
        });
    }
};
