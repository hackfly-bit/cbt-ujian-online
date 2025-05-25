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
        Schema::create('jawaban_soal', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('soal_id')->nullable()->index('soal_id');
            $table->string('jenis_isian')->nullable();
            $table->string('jawaban')->nullable();
            $table->boolean('jawaban_benar')->nullable();
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
        Schema::dropIfExists('jawaban_soal');
    }
};
