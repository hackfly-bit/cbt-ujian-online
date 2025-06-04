<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_pesertas', function (Blueprint $table) {
            $table->id();
            $table->integer('ujian_id');
            $table->string('peserta_email');
            $table->integer('soal_id');
            $table->integer('jawaban_soal_id')->nullable();
            $table->text('jawaban_text')->nullable(); // for essay questions
            $table->timestamp('dijawab_pada')->nullable();
            $table->timestamps();

            $table->index(['ujian_id', 'peserta_email']);
            $table->index(['soal_id']);
            $table->unique(['ujian_id', 'peserta_email', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pesertas');
    }
};
