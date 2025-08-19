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
        Schema::create('danhgias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phong')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->unsignedBigInteger('reply')->nullable();
            $table->string('noi_dung')->nullable();
            $table->integer('danh_gia_sao')->nullable();
            $table->timestamps();

            $table->foreign('reply')->references('id')->on('danhgias')->onDelete('cascade');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_phong')->references('id')->on('phongtro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhgias');
    }
};
