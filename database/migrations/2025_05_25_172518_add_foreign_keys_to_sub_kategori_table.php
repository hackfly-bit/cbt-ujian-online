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
        Schema::table('sub_kategori', function (Blueprint $table) {
            $table->foreign(['kategori_id'], 'sub_kategori_ibfk_1')->references(['id'])->on('kategori')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_kategori', function (Blueprint $table) {
            $table->dropForeign('sub_kategori_ibfk_1');
        });
    }
};
