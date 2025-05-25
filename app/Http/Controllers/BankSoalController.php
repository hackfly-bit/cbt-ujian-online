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


class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $soals = \App\Models\Soal::with(['kategori', 'tingkatKesulitan', 'subKategori'])
                ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at']);

            return datatables()->of($soals)
                ->addIndexColumn()
                ->addColumn('pertanyaan', function ($row) {
                    return  $row->pertanyaan ;
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->nama : '-';
                })
                ->addColumn('tingkat_kesulitan', function ($row) {
                    return $row->tingkatKesulitan ? $row->tingkatKesulitan->nama : '-';
                })
                ->addColumn('jenis_soal', function ($row) {
                    return $row->jenis_isian ? $row->jenis_isian : '-';
                })
                ->addColumn('media', function ($row) {
                    return $row->is_audio ? '<i class="ri-audio-line"></i> Audio' : '<i class="ri-text-wrap"></i> Teks';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="action-icons">
                            <a href="javascript:void(0)" class="text-primary" title="Edit" onclick="editSoal('.$row->id.')">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="javascript:void(0)" class="text-danger" title="Hapus" onclick="showDeleteConfirmation('.$row->id.')">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bank-soal.index', [
            'title' => 'Bank Soal',
            'active' => 'banksoal',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
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
            } else {
                $soal->audio_file = null;
            }

            $soal->save();

            // Simpan jawaban soal
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
                'message' => 'Soal berhasil ditambahkan.',
                'data' => $soal
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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

            // Update jawaban soal
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

    /**
     * Get tingkat kesulitan for dropdown
     */
    public function getTingkatKesulitan()
    {
        $tingkatKesulitan = TingkatKesulitan::select('id', 'nama')->get();
        return response()->json($tingkatKesulitan);
    }

    /**
     * Get kategori for dropdown
     */
    public function getKategori()
    {
        $kategori = Kategori::select('id', 'nama')->get();
        return response()->json($kategori);
    }

    /**
     * Get sub kategori by kategori id
     */
    public function getSubKategori($kategoriId)
    {
        $subKategori = SubKategori::where('kategori_id', $kategoriId)
            ->select('id', 'nama')
            ->get();
        return response()->json($subKategori);
    }
}
