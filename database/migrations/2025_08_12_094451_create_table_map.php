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
        Schema::create('map', function (Blueprint $table) {
            $table->id();
            $table->string('ma_map');
            $table->string('dia_chi')->nullable();
            $table->string('quan_huyen')->nullable();
            $table->string('kinh_do')->nullable();
            $table->string('vi_do')->nullable();
            $table->string('tinh_tp')->nullable();
             $table->string('xa_phuong')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map');
    }
};
