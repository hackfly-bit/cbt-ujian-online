<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TingkatKesulitan;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Soal;
use App\Models\JawabanSoal;

class BankSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Tingkat Kesulitan
        $tingkatKesulitan = [
            ['id' => 1, 'nama' => 'Easy'],
            ['id' => 2, 'nama' => 'Medium'],
            ['id' => 3, 'nama' => 'Hard'],
        ];

        foreach ($tingkatKesulitan as $tk) {
            TingkatKesulitan::firstOrCreate(['id' => $tk['id']], $tk);
        }

        // Create Kategori
        $kategori = [
            ['id' => 1, 'nama' => 'Reading'],
            ['id' => 2, 'nama' => 'Listening'],
            ['id' => 3, 'nama' => 'Grammar'],
        ];

        foreach ($kategori as $kat) {
            Kategori::firstOrCreate(['id' => $kat['id']], $kat);
        }

        // Create Sub Kategori
        $subKategori = [
            ['id' => 1, 'kategori_id' => 1, 'nama' => 'Reading Comprehension'],
            ['id' => 2, 'kategori_id' => 1, 'nama' => 'Vocabulary'],
            ['id' => 3, 'kategori_id' => 2, 'nama' => 'Conversation'],
            ['id' => 4, 'kategori_id' => 2, 'nama' => 'Audio News'],
            ['id' => 5, 'kategori_id' => 3, 'nama' => 'Tenses'],
            ['id' => 6, 'kategori_id' => 3, 'nama' => 'Structure'],
        ];

        foreach ($subKategori as $sub) {
            SubKategori::firstOrCreate(['id' => $sub['id']], $sub);
        }

        // Create Sample Soal with different types
        $soalData = [
            [
                'id' => 1,
                'jenis_font' => 'Arial',
                'pertanyaan' => 'What is the capital of Indonesia?',
                'is_audio' => false,
                'tingkat_kesulitan_id' => 1,
                'kategori_id' => 1,
                'sub_kategori_id' => 2,
                'penjelasan_jawaban' => 'Jakarta is the capital and largest city of Indonesia.',
                'tag' => 'geography, capital',
                'jawaban' => [
                    ['jenis_isian' => 'multiple_choice', 'jawaban' => 'Jakarta', 'jawaban_benar' => true],
                    ['jenis_isian' => 'multiple_choice', 'jawaban' => 'Surabaya', 'jawaban_benar' => false],
                    ['jenis_isian' => 'multiple_choice', 'jawaban' => 'Bandung', 'jawaban_benar' => false],
                    ['jenis_isian' => 'multiple_choice', 'jawaban' => 'Medan', 'jawaban_benar' => false],
                ]
            ],
            [
                'id' => 2,
                'jenis_font' => 'Times New Roman',
                'pertanyaan' => 'English is the official language of Indonesia.',
                'is_audio' => false,
                'tingkat_kesulitan_id' => 1,
                'kategori_id' => 3,
                'sub_kategori_id' => 6,
                'penjelasan_jawaban' => 'Indonesian (Bahasa Indonesia) is the official language of Indonesia, not English.',
                'tag' => 'language, facts',
                'jawaban' => [
                    ['jenis_isian' => 'true_false', 'jawaban' => 'Benar', 'jawaban_benar' => false],
                    ['jenis_isian' => 'true_false', 'jawaban' => 'Salah', 'jawaban_benar' => true],
                ]
            ],
            [
                'id' => 3,
                'jenis_font' => 'Calibri',
                'pertanyaan' => 'Explain the difference between present perfect and simple past tense in English.',
                'is_audio' => false,
                'tingkat_kesulitan_id' => 3,
                'kategori_id' => 3,
                'sub_kategori_id' => 5,
                'penjelasan_jawaban' => 'Present perfect connects past actions to present, while simple past describes completed past actions.',
                'tag' => 'grammar, tenses',
                'jawaban' => [
                    ['jenis_isian' => 'essay', 'jawaban' => '', 'jawaban_benar' => true],
                ]
            ],
        ];

        foreach ($soalData as $index => $soal) {
            // For Soal table, manually assign ID since it's not auto-incrementing
            $soalId = $soal['id'];

            $newSoal = Soal::updateOrCreate(['id' => $soalId], [
                'jenis_font' => $soal['jenis_font'],
                'jenis_isian' => $soal['jawaban'][0]['jenis_isian'], // Set jenis_isian from first answer
                'pertanyaan' => $soal['pertanyaan'],
                'is_audio' => $soal['is_audio'],
                'tingkat_kesulitan_id' => $soal['tingkat_kesulitan_id'],
                'kategori_id' => $soal['kategori_id'],
                'sub_kategori_id' => $soal['sub_kategori_id'],
                'penjelasan_jawaban' => $soal['penjelasan_jawaban'],
                'tag' => $soal['tag'],
            ]);

            // Clear existing jawaban for this soal
            JawabanSoal::where('soal_id', $newSoal->id)->delete();

            // Create jawaban for this soal with manual ID assignment
            $jawabanIdStart = ($index * 10) + 1; // Start IDs at 1, 11, 21, etc.
            foreach ($soal['jawaban'] as $jawabanIndex => $jawaban) {
                JawabanSoal::create([
                    'id' => $jawabanIdStart + $jawabanIndex,
                    'soal_id' => $newSoal->id,
                    'jenis_isian' => $jawaban['jenis_isian'],
                    'jawaban' => $jawaban['jawaban'], // Laravel will handle JSON casting
                    'jawaban_benar' => $jawaban['jawaban_benar'],
                ]);
            }
        }
    }
}
