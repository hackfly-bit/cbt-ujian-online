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
            $table->integer('id')->primary();
            $table->string('link')->nullable();
            $table->string('nama_ujian')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('jenis_ujian_id')->nullable()->index('jenis_ujian_id');
            $table->integer('durasi')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('ujian');
    }
};
