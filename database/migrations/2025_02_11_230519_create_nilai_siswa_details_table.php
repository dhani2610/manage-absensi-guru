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
        Schema::create('nilai_siswa_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nilai');
            $table->integer('id_siswa');
            $table->integer('bobot_1')->nullable();
            $table->integer('bobot_2')->nullable();
            $table->integer('bobot_3')->nullable();
            $table->integer('bobot_4')->nullable();
            $table->integer('persentase_bobot_1')->nullable();
            $table->integer('persentase_bobot_2')->nullable();
            $table->integer('persentase_bobot_3')->nullable();
            $table->integer('persentase_bobot_4')->nullable();
            $table->integer('persentase_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa_details');
    }
};
