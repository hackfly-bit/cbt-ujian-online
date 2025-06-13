<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HasilUjian;
use App\Models\Peserta;
use App\Models\Ujian;
use App\Models\Sertifikat;

class HasilUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ujian = Ujian::first();

        if (!$ujian) {
            $this->command->error('No exam found. Please run TestUjianSeeder first.');
            return;
        }

        // Create sample participants (without ujian_id as it's not in the table)
        $peserta1 = Peserta::create([
            'nama' => 'Ahmad Santoso',
            'email' => 'ahmad@example.com',
            'phone' => '08123456789',
            'institusi' => 'Universitas Indonesia',
            'nomor_induk' => 'UI001',
            'alamat' => 'Jakarta'
        ]);

        $peserta2 = Peserta::create([
            'nama' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'phone' => '08234567890',
            'institusi' => 'Universitas Gadjah Mada',
            'nomor_induk' => 'UGM002',
            'alamat' => 'Yogyakarta'
        ]);

        $peserta3 = Peserta::create([
            'nama' => 'Budi Prasetyo',
            'email' => 'budi@example.com',
            'phone' => '08345678901',
            'institusi' => 'Institut Teknologi Bandung',
            'nomor_induk' => 'ITB003',
            'alamat' => 'Bandung'
        ]);

        // Create certificate template
        $sertifikat = Sertifikat::create([
            'ujian_id' => $ujian->id,
            'judul' => 'Sertifikat Bahasa Arab',
            'template' => json_encode([
                'template' => 'default',
                'background' => '#ffffff',
                'border' => '#gold'
            ])
        ]);

        // Create sample exam results
        HasilUjian::create([
            'peserta_id' => $peserta1->id,
            'ujian_id' => $ujian->id,
            'total_soal' => 10,
            'soal_dijawab' => 10,
            'jawaban_benar' => 9,
            'hasil_nilai' => 90,
            'durasi_pengerjaan' => 35,
            'waktu_mulai' => now()->subDays(1)->subMinutes(35),
            'waktu_selesai_timestamp' => now()->subDays(1),
            'detail_section' => json_encode([
                [
                    'section_name' => 'Section 0',
                    'total_questions' => 10,
                    'answered_questions' => 10,
                    'correct_answers' => 9,
                    'score_percentage' => 90
                ]
            ]),
            'status' => 'completed',
            'sertifikat_id' => $sertifikat->id
        ]);

        HasilUjian::create([
            'peserta_id' => $peserta2->id,
            'ujian_id' => $ujian->id,
            'total_soal' => 10,
            'soal_dijawab' => 10,
            'jawaban_benar' => 7,
            'hasil_nilai' => 70,
            'durasi_pengerjaan' => 42,
            'waktu_mulai' => now()->subDays(2)->subMinutes(42),
            'waktu_selesai_timestamp' => now()->subDays(2),
            'detail_section' => json_encode([
                [
                    'section_name' => 'Section 0',
                    'total_questions' => 10,
                    'answered_questions' => 10,
                    'correct_answers' => 7,
                    'score_percentage' => 70
                ]
            ]),
            'status' => 'completed',
            'sertifikat_id' => $sertifikat->id
        ]);

        HasilUjian::create([
            'peserta_id' => $peserta3->id,
            'ujian_id' => $ujian->id,
            'total_soal' => 10,
            'soal_dijawab' => 8,
            'jawaban_benar' => 6,
            'hasil_nilai' => 60,
            'durasi_pengerjaan' => 55,
            'waktu_mulai' => now()->subHours(2)->subMinutes(55),
            'waktu_selesai_timestamp' => now()->subHours(2),
            'detail_section' => json_encode([
                [
                    'section_name' => 'Section 0',
                    'total_questions' => 10,
                    'answered_questions' => 8,
                    'correct_answers' => 6,
                    'score_percentage' => 60
                ]
            ]),
            'status' => 'completed',
            'sertifikat_id' => null // No certificate for this participant (low score)
        ]);

        $this->command->info('Sample exam results created successfully!');
    }
}
