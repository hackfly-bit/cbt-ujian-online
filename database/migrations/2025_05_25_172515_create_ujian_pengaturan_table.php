<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_pengaturan', function (Blueprint $table) {
            $table->integer('ujian_id')->primary();
            $table->string('metode_penilaian')->nullable();
            $table->integer('nilai_kelulusan')->nullable();
            $table->boolean('hasil_ujian_tersedia')->nullable();
                  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujian_pengaturan');
    }
};
