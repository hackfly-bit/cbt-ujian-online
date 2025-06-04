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
        Schema::create('ujian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('link')->nullable();
            $table->string('nama_ujian')->nullable();
            // $table->string('deskripsi', 65535)->nullable();
            $table->string('deskripsi')->nullable();
            $table->integer('jenis_ujian_id')->nullable()->index('jenis_ujian_id');
            $table->integer('durasi')->nullable();
            $table->string('tanggal_selesai', 0)->nullable();
            // $table->boolean('status')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('ujian');
    }
};
