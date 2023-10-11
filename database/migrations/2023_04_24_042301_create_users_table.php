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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('avatar')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('login_at')->nullable();
            $table->timestamp('change_password_at')->nullable();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('status_id')->constrained('user_status');
            // $table->bigInteger('department_id');
            // $table->bigInteger('status_id');
            $table->timestamp('delete_at')->nullable();
            $table->timestamps();
            // $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('status_id')->references('id')->on('user_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_department_id_foreign');
            $table->dropForeign('users_status_id_foreign');
        });
        Schema::dropIfExists('users');
    }
};
