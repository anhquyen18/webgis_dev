<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('measuring_station_data', function (Blueprint $table) {
            $table->id();
            $table->date('measure_at')->useCurrent()->unique();
            $table->integer('rainfall');
            $table->double('temperature');
            $table->integer('station_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measuring_station_data');
    }
};
