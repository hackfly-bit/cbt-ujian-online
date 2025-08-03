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
        Schema::table('jawaban_pesertas', function (Blueprint $table) {
            // Tambah kolom section_id jika belum ada
            if (!Schema::hasColumn('jawaban_pesertas', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('soal_id');
            }

            // Drop existing unique key
            // $table->dropUnique('jawaban_pesertas_ujian_id_peserta_email_soal_id_unique');

            // Tambahkan unique baru yang termasuk section_id
            $table->unique(
                ['ujian_id', 'peserta_email', 'soal_id', 'section_id'],
                'jawaban_pesertas_unique_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_pesertas', function (Blueprint $table) {
            // Drop unique baru
            $table->dropUnique('jawaban_pesertas_ujian_id_peserta_email_soal_id_section_id_unique');

            // Tambah kembali unique lama
            $table->unique(
                ['ujian_id', 'peserta_email', 'soal_id'],
                'jawaban_pesertas_unique_idx'
            );

            // Drop kolom section_id jika memang hanya untuk keperluan constraint
            $table->dropColumn('section_id');
        });
    }
};
