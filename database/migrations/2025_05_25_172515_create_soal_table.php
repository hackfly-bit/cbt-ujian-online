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
        Schema::create('soal', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('jenis_font')->nullable();
            $table->string('jenis_isian')->nullable();
            // $table->string('pertanyaan', 65535)->nullable();
            $table->text('pertanyaan')->nullable();
            $table->boolean('is_audio')->nullable();
            $table->string('audio_file')->nullable();
            $table->integer('tingkat_kesulitan_id')->nullable()->index('tingkat_kesulitan_id');
            $table->integer('kategori_id')->nullable()->index('kategori_id');
            $table->integer('sub_kategori_id')->nullable()->index('sub_kategori_id');
            // $table->string('penjelasan_jawaban', 65535)->nullable();
            $table->text('penjelasan_jawaban')->nullable();
            $table->string('tag')->nullable();
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
        Schema::dropIfExists('soal');
    }
};
