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
        Schema::create('hopdongs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hop_dong')->unique(); // Mã hợp đồng
            $table->unsignedBigInteger('id_chu_tro'); // Khóa ngoại chủ trọ
            $table->unsignedBigInteger('id_khach_thue'); // Khóa ngoại khách thuê
            $table->unsignedBigInteger('id_phong'); // Khóa ngoại phòng

            $table->date('ngay_ky');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');

            $table->decimal('gia_thue', 15, 2); // Giá thuê (VD: 3500000.00)
            $table->decimal('tien_coc', 15, 2)->nullable(); // Tiền cọc

            $table->enum('hinh_thuc_thanh_toan', ['Tien mat', 'Chuyen khoan']);
            $table->enum('trang_thai', ['Chua hieu luc','Hieu luc', 'Het han', 'Huy'])->default('Chua hieu luc');

            $table->longText('noi_dung')->nullable();
            $table->string('file_pdf')->nullable();
            $table->string('file_word')->nullable();

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id_chu_tro')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_khach_thue')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_phong')->references('id')->on('phongtro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopdongs');
    }
};
