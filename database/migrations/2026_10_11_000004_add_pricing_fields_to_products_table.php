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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('suggested_price')->nullable()->after('price');
            $table->unsignedInteger('portions')->default(1)->after('suggested_price');
            $table->timestamp('suggested_price_calculated_at')->nullable()->after('portions');
            $table->timestamp('price_approved_at')->nullable()->after('suggested_price_calculated_at');
            $table->foreignId('price_approved_by')->nullable()->after('price_approved_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('price_approved_by');
            $table->dropColumn([
                'suggested_price',
                'portions',
                'suggested_price_calculated_at',
                'price_approved_at',
            ]);
        });
    }
};
