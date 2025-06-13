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
        Schema::table('hasil_ujian', function (Blueprint $table) {
            $table->foreign(['peserta_id'], 'hasil_ujian_ibfk_1')->references(['id'])->on('peserta')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['ujian_id'], 'hasil_ujian_ibfk_3')->references(['id'])->on('ujian')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['sertifikat_id'], 'hasil_ujian_ibfk_2')->references(['id'])->on('sertifikat')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            $table->dropForeign('hasil_ujian_ibfk_1');
            $table->dropForeign('hasil_ujian_ibfk_2');
        });
    }
};
