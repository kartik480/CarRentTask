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
        Schema::table('bookings', function (Blueprint $table) {
            // Add total_days column if it doesn't exist
            if (!Schema::hasColumn('bookings', 'total_days')) {
                $table->integer('total_days')->nullable()->after('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Remove total_days column if it exists
            if (Schema::hasColumn('bookings', 'total_days')) {
                $table->dropColumn('total_days');
            }
        });
    }
};
