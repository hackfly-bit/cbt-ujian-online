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
        Schema::table('soal', function (Blueprint $table) {
            $table->foreign(['tingkat_kesulitan_id'], 'soal_ibfk_1')->references(['id'])->on('tingkat_kesulitan')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kategori_id'], 'soal_ibfk_2')->references(['id'])->on('kategori')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['sub_kategori_id'], 'soal_ibfk_3')->references(['id'])->on('sub_kategori')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign('soal_ibfk_1');
            $table->dropForeign('soal_ibfk_2');
            $table->dropForeign('soal_ibfk_3');
        });
    }
};
