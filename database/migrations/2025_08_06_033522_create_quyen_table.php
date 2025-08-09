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
         Schema::create('quyenchucnangs', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_quyen')->nullable();
            $table->unsignedBigInteger('id_chucnang')->nullable();
            $table->timestamps();

            $table->foreign('id_quyen')->references('id')->on('quyens')->onDelete('cascade');
            $table->foreign('id_chucnang')->references('id')->on('chucnangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quyenchucnangs');
    }
};
