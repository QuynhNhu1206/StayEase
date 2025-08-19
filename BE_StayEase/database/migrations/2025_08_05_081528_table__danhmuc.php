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
        Schema::create('DanhMuc', function (Blueprint $table) {
            $table->id();
            $table->string('ma_danh_muc')->unique();
            $table->string('ten_danh_muc');
            $table->integer('trang_thai');
            $table->string('mo_ta', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DanhMuc');
    }
};
