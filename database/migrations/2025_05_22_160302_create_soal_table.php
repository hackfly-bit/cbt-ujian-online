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
            $table->integer('id')->primary();
            $table->string('jenis_font')->nullable();
            $table->text('pertanyaan')->nullable();
            $table->boolean('is_audio')->nullable();
            $table->string('audio_file')->nullable();
            $table->integer('tingkat_kesulitan_id')->nullable()->index('tingkat_kesulitan_id');
            $table->integer('kategori_id')->nullable()->index('kategori_id');
            $table->integer('sub_kategori_id')->nullable()->index('sub_kategori_id');
            $table->text('penjelasan_jawaban')->nullable();
            $table->string('tag')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
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
