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
        Schema::create('peserta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nama')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('institusi')->nullable();
            $table->string('nomor_induk')->nullable();
            $table->string('tanggal_lahir', 0)->nullable();
            $table->string('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->integer('ujian_id')->nullable()->index('ujian_id');
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
        Schema::dropIfExists('peserta');
    }
};
