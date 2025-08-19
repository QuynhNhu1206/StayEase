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
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_user')->after('id')->unique();
            $table->string('username')->after('id_user')->unique();
            $table->date('ngay_sinh')->after('name')->nullable();
            $table->boolean('verify')->default(false);
            $table->string('que_quan')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('gioi_tinh')->nullable();
            $table->string('cccd')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
