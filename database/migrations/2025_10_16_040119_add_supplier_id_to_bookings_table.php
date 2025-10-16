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
            // Add supplier_id column if it doesn't exist
            if (!Schema::hasColumn('bookings', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->constrained('users')->onDelete('cascade')->after('car_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Remove supplier_id column if it exists
            if (Schema::hasColumn('bookings', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });
    }
};
