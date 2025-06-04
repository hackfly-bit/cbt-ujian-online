<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanSoal; // add model for checking
use Illuminate\Support\Facades\Log;

class UjianPesertaController extends Controller
{
    //


    public function ujianLogin($link)
    {

        // link ujian
        $getUjian = \App\Models\Ujian::where('link', $link)->with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals', 'jenisUjian'])->first();
        $pesertaForm = \App\Models\UjianPesertaForm::where('ujian_id', $getUjian->id)->first();



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
        $ujian = \App\Models\Ujian::where('link', $request->ujian_link)->first();

        if (!$ujian) {
            return back()->withErrors(['ujian_link' => 'Ujian tidak ditemukan.']);
        }

        // Cek apakah peserta terdaftar untuk ujian ini


        // Verifikasi password (tidak di-hash, plaintext)
        // if ($request->password !== $peserta->password) {
        //     return back()->withErrors(['password' => 'Password tidak valid.']);
        // }

        // Buat session untuk peserta ujian
        session([
            'ujian_id' => $ujian->id,
            'ujian_link' => $request->ujian_link,
            'name' => $request->name,
            'email' => $request->email,
            'exam_start_time' => now(),
            'answered_questions' => []
        ]);

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

        $totalQuestionsInSection = $sectionQuestions->count();

        // Handle parameter 'last' untuk question
        if ($questionParam === 'last') {
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

        // Hitung total soal dari semua section (untuk informasi)
        $allQuestions = collect();
        foreach ($ujian->ujianSections as $section) {
            foreach ($section->ujianSectionSoals as $sectionSoal) {
                $allQuestions->push([
                    'soal' => $sectionSoal->soal,
                    'section' => $section,
                    'section_soal' => $sectionSoal
                ]);
            }
        }
        $totalQuestions = $allQuestions->count();

        // Ambil jawaban yang sudah disimpan dari database
        $savedAnswers = \App\Models\JawabanPeserta::where('ujian_id', $ujian->id)
            ->where('peserta_email', session('email'))
            ->get();

        // Buat mapping soal_id ke nomor soal dan jawaban untuk section saat ini
        $answeredQuestionsInSection = [];
        $selectedAnswers = [];
        $savedTextAnswers = [];

        foreach ($sectionQuestions as $index => $questionData) {
            $soalId = $questionData['soal']->id;
            $savedAnswer = $savedAnswers->where('soal_id', $soalId)->first();

            if ($savedAnswer) {
                $answeredQuestionsInSection[] = $index + 1; // nomor soal dalam section (1-based)
                if ($savedAnswer->jawaban_soal_id) {
                    $selectedAnswers[$soalId] = $savedAnswer->jawaban_soal_id;
                }
                if ($savedAnswer->jawaban_text) {
                    $savedTextAnswers[$soalId] = $savedAnswer->jawaban_text;
                }
            }
        }

        // Hitung jawaban yang sudah dijawab dari semua section
        $totalAnsweredQuestions = 0;
        foreach ($ujian->ujianSections as $section) {
            foreach ($section->ujianSectionSoals as $sectionSoal) {
                $soalId = $sectionSoal->soal->id;
                if ($savedAnswers->where('soal_id', $soalId)->first()) {
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

        return view('ujian.ujian-peserta.ujian', [
            'ujian' => $ujian,
            'currentQuestion' => $currentQuestion,
            'currentSection' => $currentSection,
            'currentSectionNumber' => $currentSectionNumber,
            'currentQuestionNumber' => $currentQuestionNumber,
            'totalSections' => $ujian->ujianSections->count(),
            'totalQuestions' => $totalQuestions,
            'totalQuestionsInSection' => $totalQuestionsInSection,
            'answeredQuestionsInSection' => $answeredQuestionsInSection,
            'answeredCountInSection' => $answeredCountInSection,
            'totalAnsweredQuestions' => $totalAnsweredQuestions,
            'timeRemaining' => $timeRemaining,
            'sectionTimeRemaining' => $sectionTimeRemaining,
            'sectionQuestions' => $sectionQuestions,
            'selectedAnswers' => $selectedAnswers,
            'savedTextAnswers' => $savedTextAnswers,
            'savedAnswers' => $savedAnswers // Pass saved answers for section completion calculation
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
        } elseif ($soal->jenis_isian === 'true_false') {
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
            \App\Models\JawabanPeserta::updateOrCreate(
                [
                    'ujian_id' => $ujianId,
                    'peserta_email' => $email,
                    'soal_id' => $soalId
                ],
                [
                    'jawaban_soal_id' => $jawabanSoalId,
                    'jawaban_text' => $jawabanText,
                    'dijawab_pada' => now()
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
        $examStartTime = session('exam_start_time');

        // Ambil data ujian dengan relasi
        $ujian = \App\Models\Ujian::where('link', $link)
            ->with(['ujianSections.ujianSectionSoals.soal.jawabanSoals'])
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
        $totalScore = 0;

        foreach ($ujian->ujianSections as $sectionIndex => $section) {
            $sectionQuestions = 0;
            $sectionAnswered = 0;
            $sectionCorrect = 0;
            $sectionScore = 0;

            foreach ($section->ujianSectionSoals as $sectionSoal) {
                $soal = $sectionSoal->soal;
                $sectionQuestions++;
                $totalQuestions++;

                $savedAnswer = $savedAnswers->where('soal_id', $soal->id)->first();

                if ($savedAnswer) {
                    $sectionAnswered++;
                    $totalAnswered++;

                    // Check if answer is correct (for multiple choice and true/false)
                    if ($soal->jenis_isian === 'multiple_choice' || $soal->jenis_isian === 'pilihan_ganda') {
                        if ($savedAnswer->jawaban_soal_id) {
                            $correctAnswer = $soal->jawabanSoals->where('is_correct', true)->first();
                            if ($correctAnswer && $savedAnswer->jawaban_soal_id == $correctAnswer->id) {
                                $sectionCorrect++;
                                $totalCorrect++;
                            }
                        }
                    } elseif ($soal->jenis_isian === 'true_false') {
                        // For true/false, check against correct answer from jawaban_soals
                        $correctAnswer = $soal->jawabanSoals->where('is_correct', true)->first();
                        if ($correctAnswer && $savedAnswer->jawaban_text) {
                            $correctValue = strtolower($correctAnswer->jawaban) === 'true' ? 'true' : 'false';
                            if ($savedAnswer->jawaban_text === $correctValue) {
                                $sectionCorrect++;
                                $totalCorrect++;
                            }
                        }
                    }
                    // Note: Essay questions (isian) need manual grading
                }
            }

            // Calculate section score
            if ($sectionQuestions > 0) {
                $sectionScore = ($sectionCorrect / $sectionQuestions) * 100;
            }

            $sectionResults[] = [
                'section_number' => $sectionIndex + 1,
                'section_name' => $section->nama_section ?? 'Section ' . ($sectionIndex + 1),
                'total_questions' => $sectionQuestions,
                'answered_questions' => $sectionAnswered,
                'correct_answers' => $sectionCorrect,
                'score_percentage' => round($sectionScore, 2),
                'completion_percentage' => $sectionQuestions > 0 ? round(($sectionAnswered / $sectionQuestions) * 100, 2) : 0
            ];
        }

        // Calculate total score
        if ($totalQuestions > 0) {
            $totalScore = ($totalCorrect / $totalQuestions) * 100;
        }

        // Calculate exam duration
        $examEndTime = now();
        $examDuration = $examStartTime ? $examStartTime->diffInMinutes($examEndTime) : 0;

        // Prepare exam summary
        $examSummary = [
            'ujian_name' => $ujian->nama_ujian,
            'peserta_name' => $name,
            'peserta_email' => $email,
            'total_sections' => count($sectionResults),
            'total_questions' => $totalQuestions,
            'total_answered' => $totalAnswered,
            'total_correct' => $totalCorrect,
            'total_score' => round($totalScore, 2),
            'completion_percentage' => $totalQuestions > 0 ? round(($totalAnswered / $totalQuestions) * 100, 2) : 0,
            'exam_duration_minutes' => $examDuration,
            'exam_start_time' => $examStartTime,
            'exam_end_time' => $examEndTime,
            'section_results' => $sectionResults
        ];

        // Save exam result to database (if HasilUjian model exists)
        try {
            \App\Models\HasilUjian::create([
                'ujian_id' => $ujianId,
                'peserta_email' => $email,
                'peserta_nama' => $name,
                'total_soal' => $totalQuestions,
                'soal_dijawab' => $totalAnswered,
                'jawaban_benar' => $totalCorrect,
                'nilai' => $totalScore,
                'durasi_pengerjaan' => $examDuration,
                'waktu_mulai' => $examStartTime,
                'waktu_selesai' => $examEndTime,
                'detail_section' => json_encode($sectionResults),
                'status' => 'completed'
            ]);
        } catch (\Exception $e) {
            // If HasilUjian table doesn't exist or has different structure, continue without saving
            Log::warning('Could not save exam result: ' . $e->getMessage());
        }

        // Clear session
        session()->forget([
            'ujian_id',
            'ujian_link',
            'name',
            'email',
            'answered_questions',
            'exam_start_time',
            'section_start_times'
        ]);

        return view('ujian.ujian-peserta.ujian-selesai', [
            'examSummary' => $examSummary,
            'ujian' => $ujian
        ]);
    }
}
