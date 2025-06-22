<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test categories
        // Create test categories with random ID
        $kategoriId = rand(1, 3);
        $kategori = \App\Models\Kategori::find($kategoriId);

        if (!$kategori) {
            $kategori = \App\Models\Kategori::create([
            'nama' => 'Bahasa Arab',
            'deskripsi' => 'Kategori soal bahasa Arab'
            ]);
        }

        // Create difficulty level with random ID
        $tingkatKesulitanId = rand(1, 3);
        $tingkatKesulitan = \App\Models\TingkatKesulitan::find($tingkatKesulitanId);

        if (!$tingkatKesulitan) {
            $tingkatKesulitan = \App\Models\TingkatKesulitan::create([
            'nama' => 'Mudah',
            'deskripsi' => 'Tingkat kesulitan mudah'
            ]);
        }

        // Create exam type
        $jenisUjian = \App\Models\JenisUjian::create([
            'nama' => 'Ujian Online'
        ]);

        // Create exam
        $ujian = \App\Models\Ujian::create([
            'jenis_ujian_id' => $jenisUjian->id,
            'link' => 'test-bahasa-arab',
            'nama_ujian' => 'TEST - Bahasa Arab',
            'deskripsi' => 'Ujian test bahasa arab online',
            'durasi' => 120, // 2 hours
            'tanggal_selesai' => now()->addDays(7)->toDateString(),
            'status' => true
        ]);

        // Create exam section
        $section = \App\Models\UjianSection::create([
            'ujian_id' => $ujian->id,
            'kategori_id' => $kategori->id,
            'nama_section' => 'Section 0',
            'bobot_nilai' => 100,
            'instruksi' => 'Jawablah pertanyaan berikut dengan tepat.',
            'formula_type' => 'correctAnswer',
            'operation_1' => '+',
            'value_1' => 10,
            'operation_2' => '*',
            'value_2' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create test questions
        $questions = [
            [
                'pertanyaan' => '"اختر الجمع الصحيح لكلمة "مؤنث',
                'jawaban' => [
                    ['jawaban' => 'فنون', 'benar' => false],
                    ['jawaban' => 'فنات', 'benar' => false],
                    ['jawaban' => 'فنادق', 'benar' => false],
                    ['jawaban' => 'فنائن', 'benar' => true]
                ]
            ],
            [
                'pertanyaan' => 'ما هو الجمع الصحيح لكلمة "كتاب"؟',
                'jawaban' => [
                    ['jawaban' => 'كتب', 'benar' => true],
                    ['jawaban' => 'كتابات', 'benar' => false],
                    ['jawaban' => 'كتائب', 'benar' => false],
                    ['jawaban' => 'كتبان', 'benar' => false]
                ]
            ],
            [
                'pertanyaan' => 'اختر الإجابة الصحيحة: "الطالب ... في المدرسة"',
                'jawaban' => [
                    ['jawaban' => 'يدرس', 'benar' => true],
                    ['jawaban' => 'تدرس', 'benar' => false],
                    ['jawaban' => 'ندرس', 'benar' => false],
                    ['jawaban' => 'يدرسون', 'benar' => false]
                ]
            ],
            [
                'pertanyaan' => 'ما معنى كلمة "بيت" باللغة الإنجليزية؟',
                'jawaban' => [
                    ['jawaban' => 'School', 'benar' => false],
                    ['jawaban' => 'House', 'benar' => true],
                    ['jawaban' => 'Book', 'benar' => false],
                    ['jawaban' => 'Car', 'benar' => false]
                ]
            ],
            [
                'pertanyaan' => 'أي من هذه الكلمات فعل؟',
                'jawaban' => [
                    ['jawaban' => 'كتاب', 'benar' => false],
                    ['jawaban' => 'طالب', 'benar' => false],
                    ['jawaban' => 'كتب', 'benar' => true],
                    ['jawaban' => 'مدرسة', 'benar' => false]
                ]
            ],
            [
                'pertanyaan' => 'اختر الضمير المناسب: "... طالب مجتهد"',
                'jawaban' => [
                    ['jawaban' => 'هو', 'benar' => true],
                    ['jawaban' => 'هي', 'benar' => false],
                    ['jawaban' => 'نحن', 'benar' => false],
                    ['jawaban' => 'أنتم', 'benar' => false]
                ]
            ]
        ];

        foreach ($questions as $index => $questionData) {
            // Create question
            $soal = \App\Models\Soal::create([
                'tingkat_kesulitan_id' => $tingkatKesulitan->id,
                'kategori_id' => $kategori->id,
                'jenis_font' => 'Arial',
                'jenis_isian' => 'pilihan_ganda',
                'pertanyaan' => $questionData['pertanyaan'],
                'is_audio' => false,
                'tag' => 'bahasa-arab'
            ]);

            // Create answers for the question
            foreach ($questionData['jawaban'] as $jawabanData) {
                \App\Models\JawabanSoal::create([
                    'soal_id' => $soal->id,
                    'jenis_isian' => 'pilihan_ganda',
                    'jawaban' => $jawabanData['jawaban'],
                    'jawaban_benar' => $jawabanData['benar']
                ]);
            }

            // Add question to section
            \App\Models\UjianSectionSoal::create([
                'ujian_section' => $section->id,
                'soal_id' => $soal->id
            ]);
        }

        // Create exam settings
        \App\Models\UjianPengaturan::create([
            'ujian_id' => $ujian->id,
            'metode_penilaian' => 'otomatis',
            'nilai_kelulusan' => 70,
            'hasil_ujian_tersedia' => true,
            'acak_soal' => false,
            'acak_jawaban' => false,
            'lihat_hasil' => true,
            'lihat_pembahasan' => true,
            'is_arabic' => true,
            'formula_type' => 'correctAnswer',
            'operation_1' => '+',
            'value_1' => 10,
            'operation_2' => '*',
            'value_2' => 5
        ]);

        // Create participant form
        \App\Models\UjianPesertaForm::create([
            'ujian_id' => $ujian->id,
            'nama' => true,
            'email' => true,
            // 'password' => true,
            // 'tanggal_lahir' => false,
            // 'jenis_kelamin' => false,
            // 'nomor_hp' => false,
            // 'alamat' => false
        ]);

        echo "Test exam data created successfully!\n";
        echo "Exam link: test-bahasa-arab\n";
        echo "Access URL: /kerjakan/test-bahasa-arab\n";
    }
}
