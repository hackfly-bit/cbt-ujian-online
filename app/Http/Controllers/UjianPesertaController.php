<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanSoal; // add model for checking
use App\Models\Peserta;
use Illuminate\Support\Facades\Log;

class UjianPesertaController extends Controller
{
    //
    public function ujianLogin($link)
    {

        // link ujian
        $getUjian = \App\Models\Ujian::where('link', $link)->with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals', 'ujianThema', 'jenisUjian'])->first();
        $pesertaForm = \App\Models\UjianPesertaForm::where('ujian_id', $getUjian->id)->first();

        $is_arabic = $getUjian->ujianPengaturan->is_arabic ?? false;
        if ($is_arabic) {
            return view('ujian.ujian-peserta-arab.ujian-login', [
                'title' => 'Login Ujian',
                'active' => 'ujian',
                'ujian' => $getUjian,
                'pesertaForm' => $pesertaForm,
            ]);
        }

        return view('ujian.ujian-peserta.ujian-login', [
            'title' => 'Login Ujian',
            'active' => 'ujian',
            'ujian' => $getUjian,
            'pesertaForm' => $pesertaForm,
        ]);
    }


    public function generateSession(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|string|min:6',
            'ujian_link' => 'required|string'
        ]);

        // Ambil data ujian berdasarkan link
        $ujian = \App\Models\Ujian::where('link', $request->ujian_link)->with(['ujianPengaturan'])->first();

        if (!$ujian) {
            return back()->withErrors(['ujian_link' => 'Ujian tidak ditemukan.']);
        }

        // Buat session untuk peserta ujian
        session([
            'ujian_id' => $ujian->id,
            'ujian_link' => $request->ujian_link,
            'name' => $request->nama,
            'email' => $request->email,
            'exam_start_time' => now(),
            'answered_questions' => [],
            'lockscreen_enabled' => $ujian->ujianPengaturan->lockscreen ?? false
        ]);

        if ($request->hasFile('foto')) {
            $pesertaFoto = $request->file('foto');
            $fileName = time() . '_' . $pesertaFoto->getClientOriginalName();
            $pesertaFoto->move(public_path('images/ujian/peserta'), $fileName);
            // Save relative path from public
            $path = 'images/ujian/peserta/' . $fileName;
        }

        $peserta = Peserta::updateOrCreate(
            ['email' => $request->email],
            [
                'nama' => $request->nama ?? null,
                'phone' => $request->phone ?? null,
                'institusi' => $request->institusi ?? null,
                'nomor_induk' => $request->nomor_induk ?? null,
                'tanggal_lahir' => $request->tanggal_lahir ?? null,
                'alamat' => $request->alamat ?? null,
                'foto' => $path ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        if ($peserta) {
            // Simpan ID peserta di session
            session(['peserta_id' => $peserta->id]);

            // if exist return tu ujian selesai
            $existingHasilUjian = \App\Models\HasilUjian::where('ujian_id', $ujian->id)
                ->where('peserta_id', $peserta->id)
                ->first();
            if ($existingHasilUjian) {
                // Ambil data dari $existingHasilUjian
                $examSummary = [
                    'ujian_name' => $ujian->nama_ujian,
                    'peserta_name' => $peserta->nama,
                    'peserta_email' => $peserta->email,
                    'total_sections' => $existingHasilUjian->detail_section ? count(json_decode($existingHasilUjian->detail_section, true)) : 0,
                    'total_questions' => $existingHasilUjian->total_soal,
                    'total_answered' => $existingHasilUjian->soal_dijawab,
                    'total_correct' => $existingHasilUjian->jawaban_benar,
                    'total_incorrect' => $existingHasilUjian->total_soal - $existingHasilUjian->jawaban_benar,
                    'total_score' => round($existingHasilUjian->hasil_nilai, 2),
                    'completion_percentage' => $existingHasilUjian->total_soal > 0 ? round(($existingHasilUjian->soal_dijawab / max($existingHasilUjian->total_soal, 1)) * 100, 2) : 0,
                    'exam_duration_minutes' => $existingHasilUjian->durasi_pengerjaan,
                    'exam_start_time' => $existingHasilUjian->waktu_mulai,
                    'exam_end_time' => $existingHasilUjian->waktu_selesai,
                    'section_results' => $existingHasilUjian->detail_section ? json_decode($existingHasilUjian->detail_section, true) : []
                ];

                // pastikan ujian telah selesai
                if ($existingHasilUjian->status != 'completed') {
                    // force update status to completed
                    $existingHasilUjian->update([
                        'status' => 'completed',
                        'waktu_selesai' => now(),
                        'waktu_selesai_timestamp' => now()->timestamp,
                        'updated_at' => now()
                    ]);
                }

                // Tampilkan halaman selesai
                $isArabic = $ujian->ujianPengaturan->is_arabic ?? false;
                if ($isArabic) {
                    return view('ujian.ujian-peserta-arab.ujian-selesai', [
                        'examSummary' => $examSummary,
                        'ujian' => $ujian
                    ]);
                }
                return view('ujian.ujian-peserta.ujian-selesai', [
                    'examSummary' => $examSummary,
                    'ujian' => $ujian
                ]);
            }

            $hasilUjian = \App\Models\HasilUjian::updateOrCreate(
                ['ujian_id' => $ujian->id, 'peserta_id' => $peserta->id],
                [
                    'hasil_nilai' => 0,
                    'total_soal' => 0,
                    'soal_dijawab' => 0,
                    'jawaban_benar' => 0,
                    'durasi_pengerjaan' => 0,
                    'waktu_selesai' => null, // Waktu selesai akan diisi setelah ujian selesai
                    'waktu_selesai_timestamp' => null, // Waktu selesai timestamp akan diisi setelah ujian selesai
                    'status' => 'in_progress', // Status awal ujian
                    'peserta_id' => $peserta->id,
                    'ujian_id' => $ujian->id,
                    // Sertifikat ID akan diisi setelah ujian selesai
                    'sertifikat_id' => null, // Sertifikat akan diisi setelah ujian selesai
                    'waktu_mulai' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        } else {
            return back()->withErrors(['peserta' => 'Gagal menyimpan data peserta.']);
        }

        // Redirect ke halaman ujian
        return redirect()->route('ujian.peserta', ['link' => $request->ujian_link]);
    }

    public function ujianPeserta(Request $request, $link)
    {
        // Cek session ujian
        if (!session('ujian_id') || session('ujian_link') !== $link) {
            return redirect()->route('ujian.login', ['link' => $link])
                ->withErrors(['session' => 'Session tidak valid. Silakan login kembali.']);
        }

        // Ambil data ujian dengan relasi
        $ujian = \App\Models\Ujian::where('link', $link)
            ->with([
                'ujianSections.ujianSectionSoals.soal' => function ($query) {
                    $query->select(
                        'id',
                        'tingkat_kesulitan_id',
                        'kategori_id',
                        'sub_kategori_id',
                        'jenis_font',
                        'jenis_isian',
                        'pertanyaan',
                        'is_audio',
                        'audio_file',
                        'penjelasan_jawaban',
                        'tag',
                        'created_at',
                        'updated_at'
                    );
                },
                'ujianSections.ujianSectionSoals.soal.jawabanSoals',
                'ujianPengaturan'
            ])
            ->first();

        if (!$ujian) {
            return redirect()->route('ujian.login', ['link' => $link])
                ->withErrors(['ujian' => 'Ujian tidak ditemukan.']);
        }

        // Ambil section saat ini dari parameter atau default ke 1
        $currentSectionNumber = (int) $request->get('section', 1);
        $questionParam = $request->get('question', 1);
        $questionIdParam = $request->get('question_id');

        // Validasi section
        if ($currentSectionNumber < 1 || $currentSectionNumber > $ujian->ujianSections->count()) {
            $currentSectionNumber = 1;
        }

        // Ambil section saat ini
        $currentSection = $ujian->ujianSections->get($currentSectionNumber - 1);

        if (!$currentSection) {
            return redirect()->route('ujian.login', ['link' => $link])
                ->withErrors(['section' => 'Section tidak ditemukan.']);
        }

        // Section time tracking - initialize if not exists
        $sectionStartTimes = session('section_start_times', []);
        if (!isset($sectionStartTimes[$currentSectionNumber])) {
            $sectionStartTimes[$currentSectionNumber] = now();
            session(['section_start_times' => $sectionStartTimes]);
        }

        // Check section time limit if exists
        if (isset($currentSection->durasi) && $currentSection->durasi > 0) {
            $sectionStartTime = $sectionStartTimes[$currentSectionNumber];
            $sectionEndTime = $sectionStartTime->copy()->addMinutes($currentSection->durasi);
            $sectionTimeRemaining = max(0, $sectionEndTime->diffInSeconds(now()));

            // If section time is up, redirect to next section or end exam
            if ($sectionTimeRemaining <= 0) {
                if ($currentSectionNumber < $ujian->ujianSections->count()) {
                    return redirect()->route('ujian.peserta', ['link' => $link, 'section' => $currentSectionNumber + 1, 'question' => 1])
                        ->with('warning', 'Waktu untuk section ' . $currentSectionNumber . ' telah berakhir. Lanjut ke section berikutnya.');
                } else {
                    return redirect()->route('ujian.submit', ['link' => $link])
                        ->with('info', 'Waktu ujian telah berakhir.');
                }
            }
        } else {
            $sectionTimeRemaining = null;
        }

        // Ambil soal dari section saat ini
        $sectionQuestions = collect();
        foreach ($currentSection->ujianSectionSoals as $sectionSoal) {
            $sectionQuestions->push([
                'soal' => $sectionSoal->soal,
                'section' => $currentSection,
                'section_soal' => $sectionSoal
            ]);
        }

        // Fitur acak soal dan acak jawaban telah dinonaktifkan
        // Soal akan ditampilkan sesuai urutan asli

        // Count total questions in section excluding bumper questions for display
        $totalQuestionsInSectionForDisplay = $sectionQuestions->filter(function ($questionData) {
            return $questionData['soal']->jenis_isian !== 'bumper';
        })->count();

        // $totalQuestionsInSectionForDisplayAll = $sectionQuestions->count();

        $totalQuestionsInSection = $sectionQuestions->count();

        // Handle parameter 'last' untuk question atau question_id
        if ($questionIdParam) {
            // Cari posisi soal berdasarkan question_id
            $questionPosition = null;
            foreach ($sectionQuestions as $index => $questionData) {
                if ($questionData['soal']->id == $questionIdParam) {
                    $questionPosition = $index + 1;
                    break;
                }
            }
            $currentQuestionNumber = $questionPosition ?: 1;
        } elseif ($questionParam === 'last') {
            $currentQuestionNumber = $totalQuestionsInSection;
        } else {
            $currentQuestionNumber = (int) $questionParam;
        }

        // Validasi nomor soal dalam section
        if ($currentQuestionNumber < 1 || $currentQuestionNumber > $totalQuestionsInSection) {
            $currentQuestionNumber = 1;
        }

        // Ambil soal saat ini
        $currentQuestionData = $sectionQuestions->get($currentQuestionNumber - 1);
        $currentQuestion = $currentQuestionData ? $currentQuestionData['soal'] : null;

        // Hitung total soal dari semua section (untuk informasi) - exclude bumper questions
        $allQuestions = collect();
        foreach ($ujian->ujianSections as $section) {
            foreach ($section->ujianSectionSoals as $sectionSoal) {
                // Skip bumper questions from total count
                if ($sectionSoal->soal->jenis_isian !== 'bumper') {
                    $allQuestions->push([
                        'soal' => $sectionSoal->soal,
                        'section' => $section,
                        'section_soal' => $sectionSoal
                    ]);
                }
            }
        }
        $totalQuestions = $allQuestions->count();

        // Ambil jawaban yang sudah disimpan dari database
        $savedAnswers = \App\Models\JawabanPeserta::where('ujian_id', $ujian->id)
            ->where('peserta_email', session('email'))
            ->where('section_id', $currentSection->id)
            ->get();

        $savedAnsweredThisSession = \App\Models\JawabanPeserta::where('ujian_id', $ujian->id)
            ->where('peserta_email', session('email'))
            // ->where('section_id', $currentSection->id)
            ->get();

        // Log::info("current Section " . $currentSection->id ?? 'tidak Tidak terdeteksi');

        // Buat mapping soal_id ke nomor soal dan jawaban untuk section saat ini
        $answeredQuestionsInSection = [];
        $answeredQuestionsInSectionWithoutBumper = [];
        $selectedAnswers = [];
        $savedTextAnswers = [];

        foreach ($sectionQuestions as $index => $questionData) {
            $soalId = $questionData['soal']->id;
            $savedAnswer = $savedAnswers->where('soal_id', $soalId)->first();

            // Auto mark bumper questions as answered
            if ($questionData['soal']->jenis_isian === 'bumper') {
                $answeredQuestionsInSection[] = $index;
            } else if ($savedAnswer) {
                $answeredQuestionsInSection[] = $index; // nomor soal dalam section (1-based)
                if ($savedAnswer->jawaban_soal_id) {
                    $selectedAnswers[$soalId] = $savedAnswer->jawaban_soal_id;
                }
                if ($savedAnswer->jawaban_text) {
                    $savedTextAnswers[$soalId] = $savedAnswer->jawaban_text;
                }
            }
        }

         foreach ($sectionQuestions as $index => $questionData) {
            $soalId = $questionData['soal']->id;
            $savedAnswer = $savedAnswers->where('soal_id', $soalId)->first();

            // Auto mark bumper questions as answered
            if ($questionData['soal']->jenis_isian !== 'bumper') {
                $answeredQuestionsInSectionWithoutBumper[] = $index;
            }
        }

        $getCountSoalWithoutBumper = $sectionQuestions->filter(function ($questionData) use ($savedAnswers) {
            $soalId = $questionData['soal']->id;
            $savedAnswer = $savedAnswers->where('soal_id', $soalId)->first();
            return $questionData['soal']->jenis_isian !== 'bumper' && $savedAnswer;
        })->count();

        // Hitung jawaban yang sudah dijawab dari semua section - exclude bumper questions
        $totalAnsweredQuestions = 0;
        foreach ($ujian->ujianSections as $section) {
            foreach ($section->ujianSectionSoals as $sectionSoal) {
                $soalId = $sectionSoal->soal->id;
                // Auto count bumper questions as answered
                if ($sectionSoal->soal->jenis_isian === 'bumper') {
                    $totalAnsweredQuestions++;
                }
                // Count regular answered questions
                else if ($savedAnswers->where('soal_id', $soalId)->first()) {
                    $totalAnsweredQuestions++;
                }
            }
        }

        $answeredCountInSection = count($answeredQuestionsInSection);

        // Hitung waktu tersisa (dalam detik) - prioritaskan section time jika ada
        $startTime = session('exam_start_time', now());
        $duration = $ujian->durasi; // durasi dalam menit
        $endTime = $startTime->copy()->addMinutes($duration);
        $timeRemaining = max(0, $endTime->diffInSeconds(now()));

        // Use section time if it's more restrictive
        if ($sectionTimeRemaining !== null && $sectionTimeRemaining < $timeRemaining) {
            $timeRemaining = $sectionTimeRemaining;
        }

        // Check if trying to access a section that requires previous sections to be completed
        if ($currentSectionNumber > 1) {
            $sectionCompletionRequired = $ujian->ujianPengaturan->require_section_completion ?? false;

            if ($sectionCompletionRequired) {
                // Check if previous sections are completed
                for ($i = 1; $i < $currentSectionNumber; $i++) {
                    $prevSection = $ujian->ujianSections->get($i - 1);
                    $prevSectionSoalCount = $prevSection->ujianSectionSoals->count();
                    $prevSectionAnsweredCount = 0;

                    foreach ($prevSection->ujianSectionSoals as $sectionSoal) {
                        $soalId = $sectionSoal->soal->id;
                        if ($savedAnswers->where('soal_id', $soalId)->first()) {
                            $prevSectionAnsweredCount++;
                        }
                    }

                    if ($prevSectionAnsweredCount < $prevSectionSoalCount) {
                        return redirect()->route('ujian.peserta', ['link' => $link, 'section' => $i, 'question' => 1])
                            ->with('warning', 'Anda harus menyelesaikan semua soal di section sebelumnya terlebih dahulu.');
                    }
                }
            }
        }

        Log::info('Current question number:', ['currentQuestionNumber' => $currentQuestionNumber]);
        Log::info('Total questions:', ['totalQuestions' => $totalQuestions]);
        // check is_arabic
        $isArabic = $ujian->ujianPengaturan->is_arabic ?? false;
        if ($isArabic) {
            return view('ujian.ujian-peserta-arab.ujian', [
                'ujian' => $ujian,
                'currentQuestion' => $currentQuestion,
                'currentSection' => $currentSection,
                'currentSectionNumber' => $currentSectionNumber,
                'currentQuestionNumber' => $currentQuestionNumber,
                'totalSections' => $ujian->ujianSections->count(),
                'totalQuestions' => $totalQuestions,
                'totalQuestionsInSection' => $totalQuestionsInSection,
                'totalQuestionsInSectionForDisplay' => $totalQuestionsInSectionForDisplay,
                'totalQuestionAnswered' => $getCountSoalWithoutBumper,
                'currentSectionSoals' => $sectionQuestions,
                'answeredQuestionsInSection' => $answeredQuestionsInSection,
                'answeredQuestionsInSectionWithoutBumper' => $answeredQuestionsInSectionWithoutBumper,
                'answeredCountInSection' => $answeredCountInSection,
                'totalAnsweredQuestions' => $totalAnsweredQuestions,
                'timeRemaining' => $timeRemaining,
                'sectionTimeRemaining' => $sectionTimeRemaining,
                'sectionQuestions' => $sectionQuestions,
                'selectedAnswers' => $selectedAnswers,
                'savedTextAnswers' => $savedTextAnswers,
                'savedAnswers' => $savedAnswers, // Pass saved answers for section completion calculation
                'savedAnsweredThisSession' => $savedAnsweredThisSession,
                'lockscreenEnabled' => $ujian->ujianPengaturan->lockscreen ?? false
            ]);
        }

        return view('ujian.ujian-peserta.ujian', [
            'ujian' => $ujian,
            'currentQuestion' => $currentQuestion,
            'currentSection' => $currentSection,
            'currentSectionNumber' => $currentSectionNumber,
            'currentQuestionNumber' => $currentQuestionNumber,
            'totalSections' => $ujian->ujianSections->count(),
            'totalQuestions' => $totalQuestions,
            'totalQuestionsInSection' => $totalQuestionsInSection,
            'totalQuestionsInSectionForDisplay' => $totalQuestionsInSectionForDisplay,
            'currentSectionSoals' => $sectionQuestions,
            'answeredQuestionsInSection' => $answeredQuestionsInSection,
            'answeredQuestionsInSectionWithoutBumper' => $answeredQuestionsInSectionWithoutBumper,
            'answeredCountInSection' => $answeredCountInSection,
            'totalQuestionAnswered' => $getCountSoalWithoutBumper,
            'totalAnsweredQuestions' => $totalAnsweredQuestions,
            'timeRemaining' => $timeRemaining,
            'sectionTimeRemaining' => $sectionTimeRemaining,
            'sectionQuestions' => $sectionQuestions,
            'selectedAnswers' => $selectedAnswers,
            'savedTextAnswers' => $savedTextAnswers,
            'savedAnswers' => $savedAnswers, // Pass saved answers for section completion calculation
            'savedAnsweredThisSession' => $savedAnsweredThisSession,
            'lockscreenEnabled' => $ujian->ujianPengaturan->lockscreen ?? false
        ]);
    }

    public function saveAnswer(Request $request, $link)
    {
        // Cek session ujian
        if (!session('ujian_id') || session('ujian_link') !== $link) {
            return response()->json(['success' => false, 'message' => 'Session tidak valid']);
        }

        $ujianId = session('ujian_id');
        $email = session('email');

        // Ambil data dari request
        $soalId = null;
        $value = null;

        // Cari input jawaban dari form
        foreach ($request->all() as $key => $val) {
            if (strpos($key, 'jawaban_') === 0) {
                $soalId = (int) str_replace('jawaban_', '', $key);
                $value = $val;
                break;
            }
        }

        if (!$soalId || $value === null || $value === '') {
            return response()->json(['success' => false, 'message' => 'Data jawaban tidak valid atau kosong']);
        }

        // Ambil data soal untuk menentukan jenis jawaban
        $soal = \App\Models\Soal::find($soalId);
        if (!$soal) {
            return response()->json(['success' => false, 'message' => 'Soal tidak ditemukan']);
        }

        // Tentukan jenis jawaban berdasarkan jenis soal
        $jawabanSoalId = null;
        $jawabanText = null;

        if ($soal->jenis_isian === 'multiple_choice' || $soal->jenis_isian === 'pilihan_ganda') {
            // Untuk multiple choice, pastikan jawaban adalah ID jawaban yang valid
            if (is_numeric($value) && \App\Models\JawabanSoal::where('id', $value)->where('soal_id', $soalId)->exists()) {
                $jawabanSoalId = (int)$value;
            } else {
                return response()->json(['success' => false, 'message' => 'Pilihan jawaban tidak valid']);
            }
        } elseif ($soal->jenis_isian === 'isian') {
            // Untuk isian, simpan sebagai text
            $jawabanText = trim($value);
            if (strlen($jawabanText) === 0) {
                return response()->json(['success' => false, 'message' => 'Jawaban tidak boleh kosong']);
            }
        } elseif ($soal->jenis_isian === 'true_false' || 'benar_salah') {
            // Untuk true/false, simpan sebagai text 'true' atau 'false'
            if (in_array($value, ['true', 'false'])) {
                $jawabanText = $value;
            } else {
                return response()->json(['success' => false, 'message' => 'Jawaban harus true atau false']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Jenis soal tidak dikenali']);
        }

        // Simpan atau update jawaban ke database
        try {
            // Dapatkan section_id dari soal_id
            // $ujianSectionSoal = \App\Models\UjianSectionSoal::where('soal_id', $soalId)->first();
            // $sectionId = $ujianSectionSoal ? $ujianSectionSoal->ujian_section : null;

            \App\Models\JawabanPeserta::updateOrCreate(
                [
                    'ujian_id' => $ujianId,
                    'peserta_email' => $email,
                    'soal_id' => $soalId,
                    'section_id' => $request->input('section_id')
                ],
                [
                    'jawaban_soal_id' => $jawabanSoalId,
                    'jawaban_text' => $jawabanText,
                    'section_id' => $request->input('section_id'),
                    'dijawab_pada' => now(),
                    'updated_at' => now() // Add updated_at timestamp
                ]
            );

            // Update session untuk tracking jawaban
            $answeredQuestions = session('answered_questions', []);
            $questionNumber = (int) $request->get('question', 1);

            if (!in_array($questionNumber, $answeredQuestions)) {
                $answeredQuestions[] = $questionNumber;
                session(['answered_questions' => $answeredQuestions]);
            }

            return response()->json(['success' => true, 'message' => 'Jawaban berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jawaban: ' . $e->getMessage()]);
        }
    }

    public function submitExam($link)
    {
        // Cek session ujian
        if (!session('ujian_id') || session('ujian_link') !== $link) {
            return redirect()->route('ujian.login', ['link' => $link])
                ->withErrors(['session' => 'Session tidak valid']);
        }

        $ujianId = session('ujian_id');
        $email = session('email');
        $name = session('name');
        $pesertaId = session('peserta_id');
        $examStartTime = session('exam_start_time');

        // Ambil data ujian dengan relasi
        $ujian = \App\Models\Ujian::where('link', $link)
            ->with(['ujianSections.ujianSectionSoals.soal.jawabanSoals', 'ujianPengaturan'])
            ->first();

        if (!$ujian) {
            return redirect()->route('ujian.login', ['link' => $link])
                ->withErrors(['ujian' => 'Ujian tidak ditemukan']);
        }

        // Ambil semua jawaban peserta
        $savedAnswers = \App\Models\JawabanPeserta::where('ujian_id', $ujianId)
            ->where('peserta_email', $email)
            ->get();

        // Hitung hasil per section dan total
        $sectionResults = [];
        $totalQuestions = 0;
        $totalAnswered = 0;
        $totalCorrect = 0;
        $totalIncorrect = 0;
        $totalScoreSections = 0;
        $totalScore = 0;

        foreach ($ujian->ujianSections as $sectionIndex => $section) {
            $sectionQuestions = 0;
            $sectionAnswered = 0;
            $sectionCorrect = 0;
            $sectionScore = 0;
            $sectionIncorrect = 0;

            foreach ($section->ujianSectionSoals as $sectionSoal) {
                $soal = $sectionSoal->soal;

                // Skip bumper questions from scoring calculation
                if ($soal->jenis_isian === 'bumper') {
                    continue;
                }

                $sectionQuestions++;
                $totalQuestions++;

                $savedAnswer = $savedAnswers->where('soal_id', $soal->id)->first();

                if ($savedAnswer) {
                    $sectionAnswered++;
                    $totalAnswered++;

                    // Check if answer is correct (for multiple choice and true/false)
                    if ($soal->jenis_isian === 'multiple_choice' || $soal->jenis_isian === 'pilihan_ganda') {
                        if ($savedAnswer->jawaban_soal_id) {
                            $correctAnswer = $soal->jawabanSoals->where('jawaban_benar', true)->first();
                            if ($correctAnswer && $savedAnswer->jawaban_soal_id == $correctAnswer->id) {
                                $sectionCorrect++;
                                $totalCorrect++;
                            } else {
                                $sectionIncorrect++;
                                $totalIncorrect++;
                            }
                        }
                    } elseif ($soal->jenis_isian === 'true_false') {
                        // For true/false, check against correct answer from jawaban_soals
                        $correctAnswer = $soal->jawabanSoals->where('jawaban_benar', true)->first();
                        if ($correctAnswer && $savedAnswer->jawaban_text) {
                            $correctValue = strtolower($correctAnswer->jawaban) === 'true' ? 'true' : 'false';
                            if ($savedAnswer->jawaban_text === $correctValue) {
                                $sectionCorrect++;
                                $totalCorrect++;
                            } else {
                                $sectionIncorrect++;
                                $totalIncorrect++;
                            }
                        }
                    }
                    // Note: Essay questions (isian) need manual grading
                }
            }

            if ($sectionQuestions > 0) {
                if ($section->formula_type == 'correctAnswer') {
                    // Build formula string for correct answers
                    $formula = "($sectionCorrect{$section->operation_1}{$section->value_1}){$section->operation_2}{$section->value_2}";
                    // Evaluate the formula using eval() safely
                    $sectionScore = eval("return " . $formula . ";");
                } else {
                    // Build formula string for incorrect answers
                    $formula = "($sectionIncorrect{$section->operation_1}{$section->value_1}){$section->operation_2}{$section->value_2}";
                    // Evaluate the formula using eval() safely
                    $sectionScore = eval("return " . $formula . ";");
                }
            }

            $sectionResults[] = [
                'section_number' => $sectionIndex + 1,
                'section_name' => $section->nama_section ?? 'Section ' . ($sectionIndex + 1),
                'total_questions' => $sectionQuestions,
                'answered_questions' => $sectionAnswered,
                'correct_answers' => $sectionCorrect,
                'incorrect_answers' => $sectionIncorrect,
                'score_percentage' => round($sectionScore, 2),
                'score' => $sectionScore,
                'completion_percentage' => $sectionQuestions > 0 ? round(($sectionAnswered / $sectionQuestions) * 100, 2) : 0
            ];
        }

        // Custom calculate score
        foreach ($sectionResults as $sectionResult) {
            if ($ujian->ujianPengaturan->formula_type == 'correctAnswer') {
                // Build formula string for correct answers
                $formula = "({$sectionResult['score']}{$ujian->ujianPengaturan->operation_1}{$ujian->ujianPengaturan->value_1}){$ujian->ujianPengaturan->operation_2}{$ujian->ujianPengaturan->value_2}";
                // Evaluate the formula using eval() safely
                $totalScoreSections += eval("return " . $formula . ";");
            } else {
                // Build formula string for incorrect answers
                $formula = "({$sectionResult['score']}{$ujian->ujianPengaturan->operation_1}{$ujian->ujianPengaturan->value_1}){$ujian->ujianPengaturan->operation_2}{$ujian->ujianPengaturan->value_2}";
                // Evaluate the formula using eval() safely
                $totalScoreSections += eval("return " . $formula . ";");
            }
        }

        // Calculate total score
        if ($totalQuestions > 0) {
            // $totalScore = ($totalCorrect / $totalQuestions) * 100;
            $totalScore = round($totalScoreSections, 2);
        }

        // Calculate exam duration
        $examEndTime = now();
        $examDuration = $examStartTime ? $examStartTime->diffInMinutes($examEndTime) : 0;

        $getSertifikat = \App\Models\Sertifikat::where('ujian_id', $ujianId)->first();

        // Determine pass/fail status based on passing grade
        $nilaiKelulusan = $ujian->ujianPengaturan->nilai_kelulusan ?? 0;
        $statusKelulusan = $totalScore >= $nilaiKelulusan ? 'lulus' : 'tidak_lulus';

        // Prepare exam summary
        $examSummary = [
            'ujian_name' => $ujian->nama_ujian,
            'peserta_name' => $name,
            'peserta_email' => $email,
            'total_sections' => count($sectionResults),
            'total_questions' => $totalQuestions,
            'total_answered' => $totalAnswered,
            'total_correct' => $totalCorrect,
            'total_incorrect' => $totalIncorrect,
            'total_score' => round($totalScore, 2),
            'completion_percentage' => $totalQuestions > 0 ? round(($totalAnswered / max($totalQuestions, 1)) * 100, 2) : 0,
            'exam_duration_minutes' => $examDuration,
            'exam_start_time' => $examStartTime,
            'exam_end_time' => $examEndTime,
            'section_results' => $sectionResults,
            'nilai_kelulusan' => $nilaiKelulusan,
            'status_kelulusan' => $statusKelulusan
        ];

        // Save exam result to database (if HasilUjian model exists)
        try {
            \App\Models\HasilUjian::updateOrCreate(
                [
                    'ujian_id' => $ujianId,
                    'peserta_id' => $pesertaId
                ],
                [
                    'total_soal' => $totalQuestions,
                    'soal_dijawab' => $totalAnswered,
                    'jawaban_benar' => $totalCorrect,
                    'hasil_nilai' => $totalScore,
                    'durasi_pengerjaan' => $examDuration,
                    'waktu_mulai' => $examStartTime,
                    'waktu_selesai' => $examEndTime,
                    'detail_section' => json_encode($sectionResults),
                    'status' => 'completed',
                    'status_kelulusan' => $statusKelulusan,
                    'sertifikat_id' => $getSertifikat ? $getSertifikat->id : null
                ]
            );
        } catch (\Exception $e) {
            // If HasilUjian table doesn't exist or has different structure, continue without saving
            Log::warning('Could not save exam result: ' . $e->getMessage());
        }

        // Clear session
        // session()->forget([
        //     'ujian_id',
        //     'ujian_link',
        //     'name',
        //     'email',
        //     'answered_questions',
        //     'exam_start_time',
        //     'section_start_times',
        //     'lockscreen_enabled'
        // ]);

        // Check if is_arabic is set to true
        $isArabic = $ujian->ujianPengaturan->is_arabic ?? false;

        if ($isArabic) {
            return view('ujian.ujian-peserta-arab.ujian-selesai', [
                'examSummary' => $examSummary,
                'ujian' => $ujian
            ]);
        }

        return view('ujian.ujian-peserta.ujian-selesai', [
            'examSummary' => $examSummary,
            'ujian' => $ujian
        ]);
    }
}
