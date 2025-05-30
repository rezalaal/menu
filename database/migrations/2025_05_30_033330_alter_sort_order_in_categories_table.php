<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('sort_order')->nullable()->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {            
            $table->integer('sort_order')->nullable(false)->default(null)->change();
        });
    }
};
