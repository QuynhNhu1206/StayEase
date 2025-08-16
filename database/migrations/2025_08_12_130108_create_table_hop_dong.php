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
            $table->unsignedBigInteger('id_phong')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->string('ten_hop_dong')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('tien_coc', 18, 2)->nullable();
            $table->decimal('tien_phong', 18, 2)->nullable();
            $table->integer('trang_thai')->nullable();
            $table->string('file_hop_dong')->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
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
