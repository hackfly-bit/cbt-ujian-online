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
        Schema::table('jawaban_soal', function (Blueprint $table) {
            $table->foreign(['soal_id'], 'jawaban_soal_ibfk_1')->references(['id'])->on('soal')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jawaban_soal', function (Blueprint $table) {
            $table->dropForeign('jawaban_soal_ibfk_1');
        });
    }
};
