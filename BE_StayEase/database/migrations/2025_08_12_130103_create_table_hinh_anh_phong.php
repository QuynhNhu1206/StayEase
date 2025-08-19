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
         Schema::create('hinh_anh_phongs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phong')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->foreign('id_phong')->references('id')->on('phongtro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_phongs');
    }
};
