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
        Schema::table('ujian_section', function (Blueprint $table) {
            $table->foreign(['ujian_id'], 'ujian_section_ibfk_1')->references(['id'])->on('ujian')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kategori_id'], 'ujian_section_ibfk_2')->references(['id'])->on('kategori')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ujian_section', function (Blueprint $table) {
            $table->dropForeign('ujian_section_ibfk_1');
        });
    }
};
