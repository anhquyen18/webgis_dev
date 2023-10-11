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
        Schema::create('user_edit_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edit_category_id')->constrained('edit_category');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('edit_type_id')->constrained('edit_type');
            $table->timestamp('edit_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_edit_history', function (Blueprint $table) {
            $table->dropForeign('user_edit_history_edit_category_id_foreign');
            $table->dropForeign('user_edit_history_edit_type_id_foreign');
            $table->dropForeign('user_edit_history_user_id_foreign');
        });
        Schema::dropIfExists('user_edit_history');
    }
};
