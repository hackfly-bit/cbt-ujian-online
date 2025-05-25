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
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->foreign(['ujian_id'], 'sertifikat_ibfk_1')->references(['id'])->on('ujian')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropForeign('sertifikat_ibfk_1');
        });
    }
};
