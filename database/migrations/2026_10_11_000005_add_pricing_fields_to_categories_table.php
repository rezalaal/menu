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
        Schema::table('categories', function (Blueprint $table) {
            $table->float('waste_percent')->nullable()->after('sort_order');
            $table->float('overhead_percent')->nullable()->after('waste_percent');
            $table->float('profit_percent')->nullable()->after('overhead_percent');
            $table->float('tax_percent')->nullable()->after('profit_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'waste_percent',
                'overhead_percent',
                'profit_percent',
                'tax_percent',
            ]);
        });
    }
};
