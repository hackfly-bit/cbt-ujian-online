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
        Schema::create('ujian_pengaturan', function (Blueprint $table) {
            $table->integer('ujian_id')->primary();
            $table->string('metode_penilaian')->nullable();
            $table->integer('nilai_kelulusan')->nullable();
            $table->boolean('hasil_ujian_tersedia')->nullable();
            $table->boolean('acak_soal')->default(0);
            $table->boolean('acak_jawaban')->default(0);
            $table->boolean('lihat_hasil')->default(0);
            $table->boolean('lihat_pembahasan')->default(0);
            $table->boolean('is_arabic')->default(0);
            $table->string('formula_type')->nullable();
            $table->string('operation_1')->nullable()->default('*');
            $table->decimal('value_1', 8, 2)->nullable()->default(1);
            $table->string('operation_2')->nullable()->default('*');
            $table->decimal('value_2', 8, 2)->nullable()->default(1);
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
        Schema::dropIfExists('ujian_pengaturan');
    }
};
