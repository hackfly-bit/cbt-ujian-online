<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Soal;
use App\Models\JawabanSoal;
use App\Models\TingkatKesulitan;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Support\Facades\Log;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function index(Request $request)
    // {

    //     if ($request->ajax()) {
    //         $soals = \App\Models\Soal::with(['kategori', 'tingkatKesulitan', 'subKategori'])
    //             ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at', 'jenis_isian']);

    //         if ($request->has('kategori') && $request->kategori !== 'all') {
    //             $soals->where('kategori_id', (int) $request->kategori);
    //         }

    //         return datatables()->of($soals->get())
    //             ->addIndexColumn()
    //             ->addColumn('pertanyaan', function ($row) {
    //                 return  $row->pertanyaan;
    //             })
    //             ->addColumn('kategori', function ($row) {
    //                 return $row->kategori ? $row->kategori->nama : '-';
    //             })
    //             ->addColumn('tingkat_kesulitan', function ($row) {
    //                 return $row->tingkatKesulitan ? $row->tingkatKesulitan->nama : '-';
    //             })
    //             ->addColumn('jenis_soal', function ($row) {
    //                 return $row->jenis_isian ? $row->jenis_isian : '-';
    //             })
    //             ->addColumn('media', function ($row) {
    //                 return $row->is_audio ? '<i class="ri-audio-line"></i> Audio' : '<i class="ri-text-wrap"></i> Teks';
    //             })

    //             ->addColumn('action', function ($row) {
    //                 return '
    //                     <div class="action-icons">
    //                         <a href="javascript:void(0)" class="text-primary" title="Edit" onclick="editSoal(' . $row->id . ')">
    //                             <i class="ri-edit-2-line"></i>
    //                         </a>
    //                         <a href="javascript:void(0)" class="text-danger" title="Hapus" onclick="showDeleteConfirmation(' . $row->id . ')">
    //                             <i class="ri-delete-bin-line"></i>
    //                         </a>
    //                     </div>
    //                 ';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('bank-soal.index', [
    //         'title' => 'Bank Soal',
    //         'active' => 'banksoal',
    //         'breadcrumbs' => [
    //             // ['label' => 'Dashboard', 'url' => route('dashboard')],
    //             ['label' => 'Bank Soal', 'url' => route('bank-soal.index')],
    //         ],
    //     ]);
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $soals = \App\Models\Soal::with(['kategori', 'tingkatKesulitan', 'subKategori'])
                ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at', 'jenis_isian'])
                ->orderBy('created_at', 'desc');

            // Jika 'filter_kategori' tidak ada atau kosong, dan 'kategori' bukan 'all', filter pakai kategori_id
            if (
                $request->filled('kategori') &&
                $request->kategori !== 'all' &&
                (!$request->filled('filter_kategori'))
            ) {
                $soals->where('kategori_id', (int) $request->kategori);
            }

            // Jika 'filter_kategori' diisi (khusus untuk tab "semua"), filter berdasarkan nama kategori
            if ($request->filled('filter_kategori')) {
                $soals->whereHas('kategori', function ($query) use ($request) {
                    $query->where('nama', $request->filter_kategori);
                });
            }

            // Jika 'tingkat_kesulitan' diisi, filter berdasarkan nama tingkat kesulitan
            if ($request->filled('tingkat_kesulitan')) {
                $soals->whereHas('tingkatKesulitan', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->tingkat_kesulitan . '%');
                });
            }

            return datatables()->of($soals->get())
                ->addIndexColumn()
                ->addColumn('pertanyaan', fn($row) => $row->pertanyaan)
                ->addColumn('kategori', fn($row) => $row->kategori ? $row->kategori->nama : '-')
                ->addColumn('tingkat_kesulitan', fn($row) => $row->tingkatKesulitan ? $row->tingkatKesulitan->nama : '-')
                ->addColumn('jenis_soal', fn($row) => $row->jenis_isian ?? '-')
                ->addColumn('media', fn($row) => $row->is_audio ? '<i class="ri-audio-line"></i> Audio' : '<i class="ri-text-wrap"></i> Teks')
                ->addColumn('action', function ($row) {
                    return '
                    <div class="action-icons">
                        <a href="javascript:void(0)" class="text-primary" title="Edit" onclick="editSoal(' . $row->id . ')">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-danger" title="Hapus" onclick="showDeleteConfirmation(' . $row->id . ')">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </div>
                ';
                })
                ->rawColumns(['action', 'media', 'tingkat_kesulitan', 'kategori'])
                ->make(true);
        }

        return view('bank-soal.index', [
            'title' => 'Bank Soal',
            'active' => 'banksoal',
            'breadcrumbs' => [
                ['label' => 'Bank Soal', 'url' => route('bank-soal.index')],
            ],
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     * jenis_font
     *
     */
    public function store(Request $request)
    {
        try {
            Log::info('Store request received', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'jenis_font' => 'required|string|max:255',
                'pertanyaan' => 'required|string',
                'jenis_soal' => 'required|in:pilihan_ganda,benar_salah,isian',
                'is_audio' => 'nullable|boolean',
                'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
                'tingkat_kesulitan_id' => 'required|exists:tingkat_kesulitan,id',
                'kategori_id' => 'required|exists:kategori,id',
                'sub_kategori_id' => 'nullable|exists:sub_kategori,id',
                'penjelasan_jawaban' => 'nullable|string',
                'tag' => 'nullable|string|max:255',
                'jawaban_soal' => 'required|array|min:1',
                'jawaban_soal.*.jawaban' => 'required|string',
                'jawaban_soal.*.jenis_isian' => 'required|string',
                'jawaban_soal.*.jawaban_benar' => 'required|boolean',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            DB::beginTransaction();

            $soal = new \App\Models\Soal();
            $soal->jenis_font = $validated['jenis_font'];
            $soal->pertanyaan = $validated['pertanyaan'];
            $soal->is_audio = $validated['is_audio'] ?? false;
            $soal->tingkat_kesulitan_id = $validated['tingkat_kesulitan_id'];
            $soal->kategori_id = $validated['kategori_id'];
            $soal->sub_kategori_id = $validated['sub_kategori_id'] ?? null;
            $soal->penjelasan_jawaban = $validated['penjelasan_jawaban'] ?? null;
            $soal->jenis_isian = $validated['jenis_soal'] ?? 'pilihan_ganda'; // Default to pilihan_ganda if not provided
            $soal->tag = $validated['tag'] ?? null;

            // Simpan audio file jika ada
            if ($request->hasFile('audio_file')) {
                $path = $request->file('audio_file')->store('audio_files', 'public');
                $soal->audio_file = $path;
                Log::info('Audio file saved', ['path' => $path]);
            } else {
                $soal->audio_file = null;
            }

            $soal->save();
            Log::info('Soal saved', ['soal_id' => $soal->id]);

            // Simpan jawaban soal
            foreach ($validated['jawaban_soal'] as $index => $jawaban) {
                $newJawaban = new \App\Models\JawabanSoal();
                $newJawaban->soal_id = $soal->id;
                $newJawaban->jenis_isian = $jawaban['jenis_isian'];
                $newJawaban->jawaban = $jawaban['jawaban'];
                $newJawaban->jawaban_benar = $jawaban['jawaban_benar'];
                $newJawaban->save();
                Log::info('Jawaban saved', ['jawaban_id' => $newJawaban->id, 'index' => $index]);
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil ditambahkan.',
                'data' => $soal->load('jawabanSoals')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan soal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $soal = \App\Models\Soal::with(['jawabanSoals', 'tingkatKesulitan', 'kategori', 'subKategori'])
            ->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $soal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'jenis_font' => 'required|string|max:255',
            'pertanyaan' => 'required|string',
            'jenis_soal' => 'required|in:pilihan_ganda,benar_salah,isian',
            'is_audio' => 'nullable|boolean',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'tingkat_kesulitan_id' => 'required|exists:tingkat_kesulitan,id',
            'kategori_id' => 'required|exists:kategori,id',
            'sub_kategori_id' => 'nullable|exists:sub_kategori,id',
            'penjelasan_jawaban' => 'nullable|string',
            'tag' => 'nullable|string|max:255',
            'jawaban_soal' => 'required|array|min:1',
            'jawaban_soal.*.jawaban' => 'required|string',
            'jawaban_soal.*.jenis_isian' => 'required|string',
            'jawaban_soal.*.jawaban_benar' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $soal = \App\Models\Soal::findOrFail($id);
            $soal->jenis_font = $validated['jenis_font'];
            $soal->pertanyaan = $validated['pertanyaan'];
            $soal->is_audio = $validated['is_audio'] ?? false;
            $soal->tingkat_kesulitan_id = $validated['tingkat_kesulitan_id'];
            $soal->kategori_id = $validated['kategori_id'];
            $soal->sub_kategori_id = $validated['sub_kategori_id'] ?? null;
            $soal->penjelasan_jawaban = $validated['penjelasan_jawaban'] ?? null;
            $soal->jenis_isian = $validated['jenis_soal'] ?? 'pilihan_ganda'; // Default to pilihan_ganda if not provided
            $soal->tag = $validated['tag'] ?? null;

            // Hapus audio lama jika ada file baru diupload
            if ($request->hasFile('audio_file')) {
                if ($soal->audio_file && Storage::disk('public')->exists($soal->audio_file)) {
                    Storage::disk('public')->delete($soal->audio_file);
                }
                $path = $request->file('audio_file')->store('audio_files', 'public');
                $soal->audio_file = $path;
            }

            $soal->save();

            // Hapus jawaban lama
            \App\Models\JawabanSoal::where('soal_id', $soal->id)->delete();
            // Tambahkan jawaban baru
            foreach ($validated['jawaban_soal'] as $jawaban) {
                $newJawaban = new \App\Models\JawabanSoal();
                $newJawaban->soal_id = $soal->id;
                $newJawaban->jenis_isian = $jawaban['jenis_isian'];
                $newJawaban->jawaban = $jawaban['jawaban'];
                $newJawaban->jawaban_benar = $jawaban['jawaban_benar'];
                $newJawaban->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil diperbarui.',
                'data' => $soal
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui soal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $soal = \App\Models\Soal::findOrFail($id);
            // Hapus file audio jika ada
            if ($soal->audio_file && Storage::disk('public')->exists($soal->audio_file)) {
                Storage::disk('public')->delete($soal->audio_file);
            }
            // Hapus semua jawaban terkait
            \App\Models\JawabanSoal::where('soal_id', $soal->id)->delete();
            // Hapus soal
            $soal->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus soal: ' . $e->getMessage(),
            ], 500);
        }
    }


}
