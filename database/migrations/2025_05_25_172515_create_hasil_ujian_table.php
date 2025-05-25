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
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('peserta_id')->nullable()->index('peserta_id');
            $table->integer('hasil_nilai')->nullable();
            $table->string('waktu_selesai', 0)->nullable();
            $table->integer('sertifikat_id')->nullable()->index('sertifikat_id');
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
        Schema::dropIfExists('hasil_ujian');
    }
};
