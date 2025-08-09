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
        Schema::create('phongtro', function (Blueprint $table) {
            $table->id(); // _id
            $table->string('ma_phong', 50);
            $table->unsignedBigInteger('id_danh_muc')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->string('ten_phong_tro', 100)->nullable();
            $table->string('dia_chi', 255)->nullable();
            $table->json('anh_phong')->nullable();
            $table->text('mo_ta')->nullable();
            $table->float('dien_tich')->nullable();
            $table->decimal('gia_tien', 15, 2)->nullable();
            $table->tinyInteger('trang_thai')->default(1);
            $table->integer('so_luong_nguoi')->nullable();

            $table->timestamps();
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_danh_muc')->references('id')->on('danhmuc')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phongtro');
    }
};
