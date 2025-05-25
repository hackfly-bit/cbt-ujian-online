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
        Schema::table('ujian_section_soal', function (Blueprint $table) {
            $table->foreign(['soal_id'], 'ujian_section_soal_ibfk_1')->references(['id'])->on('soal')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['ujian_section'], 'ujian_section_soal_ibfk_2')->references(['id'])->on('ujian_section')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ujian_section_soal', function (Blueprint $table) {
            $table->dropForeign('ujian_section_soal_ibfk_1');
            $table->dropForeign('ujian_section_soal_ibfk_2');
        });
    }
};
