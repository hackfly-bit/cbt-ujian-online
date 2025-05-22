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
        Schema::create('ujian_peserta_form', function (Blueprint $table) {
            $table->integer('ujian_id')->primary();
            $table->boolean('nama')->nullable();
            $table->boolean('phone')->nullable();
            $table->boolean('email')->nullable();
            $table->boolean('institusi')->nullable();
            $table->boolean('nomor_induk')->nullable();
            $table->boolean('tanggal_lahir')->nullable();
            $table->boolean('alamat')->nullable();
            $table->boolean('foto')->nullable();
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
        Schema::dropIfExists('ujian_peserta_form');
    }
};
