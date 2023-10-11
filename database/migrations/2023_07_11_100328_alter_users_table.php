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
        Schema::table('users', function (Blueprint $table) {;
            // $table->unsignedBigInteger('geoserver_account_id');
            // $table->foreign('geoserver_account_id')->nullable()->references('id')->on('geoserver_account')->onDelete('cascade');
            $table->foreignId('geoserver_account_id')->nullable()->constrained('geoserver_account')->onDelete('cascade');
            // $table->foreignId('geoserver_account_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_geoserver_account_id_foreign');
            $table->dropColumn('geoserver_account_id');
        });
    }
};
