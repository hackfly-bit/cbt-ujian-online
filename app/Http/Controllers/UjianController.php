<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UjianController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $ujian = Ujian::with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals.soal']);
            return datatables()->of($ujian->get())
                ->addIndexColumn()
                ->addColumn('nama_ujian', function ($row) {
                    return $row->nama_ujian;
                })
                ->addColumn('status', function ($row) {
                    return $row->deskripsi;
                })
                ->addColumn('soal', function ($row) {
                    return $row->ujianSections->sum(function ($section) {
                        return $section->ujianSectionSoals->count();
                    });
                })
                ->addColumn('durasi', function ($row) {
                    return $row->durasi . ' menit';
                })
                ->addColumn('peserta', function ($row) {
                    return $row->pesertas->count();
                })
                ->addColumn('tanggal_selesai', function ($row) {
                    return $row->tanggal_selesai ? date('d-m-Y H:i', strtotime($row->tanggal_selesai)) : '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="action-icons">
                           <a href="' . route('ujian.show', $row->id) . '" class="text-primary" title="Edit">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="' . route('ujian.login', $row->link) . '" class="text-success" title="Lihat Ujian">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="javascript:void(0)" class="text-danger" title="Hapus" onclick="showDeleteConfirmation(' . $row->id . ')">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ujian.index', [
            'title' => 'Ujian',
            'active' => 'ujian',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $jenisUjian = \App\Models\JenisUjian::all();
        return view('ujian.buat-ujian', [
            'title' => 'Buat Ujian',
            'active' => 'ujian',
            'jenisUjian' => $jenisUjian,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Log::info("message", [
            'request' => $request->all(),
        ]);
        // Validation
        // $request->validate([
        //     'detail.nama' => 'required|string|max:255',
        //     'detail.deskripsi' => 'nullable|string',
        //     'detail.durasi' => 'required|string',
        //     'detail.jenis_ujian' => 'required|string',
        //     'detail.tanggal_selesai' => 'required|date',
        //     'sections' => 'required|array|min:1',
        //     'sections.*.nama_section' => 'required|string|max:255',
        //     'sections.*.bobot_nilai' => 'required|numeric|min:0|max:100',
        //     'sections.*.instruksi' => 'nullable|string',
        //     'sections.*.metode_penilaian' => 'required|in:otomatis,manual',
        //     'sections.*.kategori_id' => 'required|exists:kategoris,id',
        //     'sections.*.selected_questions' => 'required|array|min:1',
        //     'sections.*.selected_questions.*' => 'exists:soals,id',
        //     'peserta' => 'required|array',
        //     'pengaturan.metode_penilaian' => 'required|in:presentase,poin',
        //     'pengaturan.nilai_kelulusan' => 'nullable|numeric|min:0',
        //     'pengaturan.hasil_ujian' => 'required|numeric|min:0',
        // ]);

        try {
            DB::beginTransaction();

            // Create ujian
            $ujian = new Ujian();
            $ujian->nama_ujian   = $request->detail['nama'];
            $ujian->deskripsi = $request->detail['deskripsi'];
            $ujian->durasi = $request->detail['durasi'];
            $ujian->jenis_ujian_id = $request->detail['jenis_ujian'];
            $ujian->tanggal_selesai = $request->detail['tanggal_selesai'];
            $ujian->status = $request->detail['status'] ?? 'draft'; // Default to 'draft' if not provided
            $ujian->link = Str::uuid()->toString(); // Generate a unique link for the ujian
            $ujian->save();

            // Create ujian settings
            $ujianPengaturan = new \App\Models\UjianPengaturan();
            $ujianPengaturan->ujian_id = $ujian->id;
            $ujianPengaturan->metode_penilaian = $request->pengaturan['metode_penilaian'];
            $ujianPengaturan->nilai_kelulusan = $request->pengaturan['nilai_kelulusan'];
            $ujianPengaturan->hasil_ujian_tersedia = $request->pengaturan['hasil_ujian'];
            $ujianPengaturan->save();

            // Create ujian peserta form
            $ujianPesertaForm = new \App\Models\UjianPesertaForm();
            $ujianPesertaForm->ujian_id = $ujian->id;
            $ujianPesertaForm->nama = $request->peserta['nama'] ?? false;
            $ujianPesertaForm->phone = $request->peserta['phone'] ?? false;
            $ujianPesertaForm->email = $request->peserta['email'] ?? false;
            $ujianPesertaForm->institusi = $request->peserta['institusi'] ?? false;
            $ujianPesertaForm->nomor_induk = $request->peserta['nomor_induk'] ?? false;
            $ujianPesertaForm->tanggal_lahir = $request->peserta['tanggal_lahir'] ?? false;
            $ujianPesertaForm->alamat = $request->peserta['alamat'] ?? false;
            $ujianPesertaForm->foto = $request->peserta['foto'] ?? false;
            $ujianPesertaForm->save();

            // Create ujian sections
            foreach ($request->sections as $sectionData) {
                $ujianSection = new \App\Models\UjianSection();
                $ujianSection->ujian_id = $ujian->id;
                $ujianSection->nama_section = $sectionData['nama_section'];
                $ujianSection->bobot_nilai = (float) $sectionData['bobot_nilai'];
                $ujianSection->instruksi = $sectionData['instruksi'] ?? null;
                $ujianSection->metode_penilaian = $sectionData['metode_penilaian'];
                $ujianSection->save();

                // Create ujian section soals
                foreach ($sectionData['selected_questions'] as $soalId) {
                    $ujianSectionSoal = new \App\Models\UjianSectionSoal();
                    $ujianSectionSoal->ujian_section = $ujianSection->id;
                    $ujianSectionSoal->soal_id = $soalId;
                    $ujianSectionSoal->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil dibuat',
                'data' => $ujian
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat ujian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return all relational of ujian
        $jenisUjian = \App\Models\JenisUjian::all();
        $ujian = Ujian::with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals.soal'])->findOrFail($id);

        return view('ujian.buat-ujian', [
            'title' => $ujian->nama_ujian,
            'active' => 'ujian',
            'ujian' => $ujian,
            'jenisUjian' => $jenisUjian,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $ujian = Ujian::findOrFail($id);

            // Delete related data first (due to foreign key constraints)
            // Delete ujian section soals
            foreach ($ujian->ujianSections as $section) {
                $section->ujianSectionSoals()->delete();
            }

            // Delete ujian sections
            $ujian->ujianSections()->delete();

            // Delete ujian peserta form
            $ujian->ujianPesertaForm()->delete();

            // Delete ujian pengaturan
            $ujian->ujianPengaturan()->delete();

            // Delete the ujian itself
            $ujian->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus ujian: ' . $e->getMessage()
            ], 500);
        }
    }
}
