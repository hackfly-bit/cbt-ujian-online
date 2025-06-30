<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UjianController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $ujian = Ujian::with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals.soal'])
                ->orderBy('created_at', 'desc');

            // Filter berdasarkan status jika ada parameter status
            if ($request->has('status') && $request->status !== null) {
                $ujian->where('status', $request->status);
            }
            return datatables()->of($ujian->get())
                ->addIndexColumn()
                ->addColumn('nama_ujian', function ($row) {
                    return $row->nama_ujian;
                })
                ->addColumn('deskripsi', function ($row) {
                    return $row->deskripsi;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
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
                    return $row->hasilUjian->count();
                })
                ->addColumn('tanggal_selesai', function ($row) {
                    return $row->tanggal_selesai ? date('d-m-Y H:i', strtotime($row->tanggal_selesai)) : '-';
                })
                ->addColumn('action', function ($row) {
                    $url = route('ujian.login', $row->link);

                    return '<div class="action-icons d-flex gap-2 justify-content-center">
                        <a href="' . route('ujian.show', $row->id) . '" class="text-primary" title="Edit">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        <a href="' . $url . '" class="text-success" title="Lihat Ujian" target="_blank">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-secondary copy-link" data-link="' . $url . '" title="Salin Link">
                            <i class="ri-file-copy-line"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-danger" title="Hapus" onclick="showDeleteConfirmation(' . $row->id . ')">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </div>';
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

        $masterColors = [
            'klasik' => [
                'primary_color' => '#ced4da',
                'secondary_color' => '#f8f9fa',
                'tertiary_color' => '#000000',
                'background' => '#f8f9fa',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#ced4da',
                'button_font' => '#000000',
            ],
            'modern' => [
                'primary_color' => '#0d6efd',
                'secondary_color' => '#ffffff',
                'tertiary_color' => '#000000',
                'background' => '#ffffff',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#0d6efd',
                'button_font' => '#ffffff',
            ],
            'glow' => [
                'primary_color' => 'linear-gradient(to right, #8e2de2, #f27121)',
                'secondary_color' => 'linear-gradient(to bottom, #ffe7a8, #fbb9b7)',
                'tertiary_color' => '#000000',
                'background' => '#fff3cd', // fallback background glow
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#f27121',
                'button_font' => '#ffffff',
            ],
            'minimal' => [
                'primary_color' => '#6c757d',
                'secondary_color' => '#f8f9fa',
                'tertiary_color' => '#000000',
                'background' => '#f8f9fa',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#6c757d',
                'button_font' => '#ffffff',
            ],
        ];


        Log::info("message", [
            'request' => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            // Parse JSON data from FormData
            $detail = json_decode($request->input('detail'), true) ?? $request->detail ?? [];
            $peserta = json_decode($request->input('peserta'), true) ?? $request->peserta ?? [];
            $pengaturan = json_decode($request->input('pengaturan'), true) ?? $request->pengaturan ?? [];
            $sections = json_decode($request->input('sections'), true) ?? $request->sections ?? [];

            // Create ujian
            $ujian = new Ujian();
            $ujian->nama_ujian   = $detail['nama'];
            $ujian->deskripsi = $detail['deskripsi'];
            $ujian->durasi = $detail['durasi'];
            $ujian->jenis_ujian_id = $detail['jenis_ujian'];
            $ujian->tanggal_selesai = $detail['tanggal_selesai'];
            $ujian->status = $detail['status'] ?? 'draft'; // Default to 'draft' if not provided
            $ujian->link = Str::uuid()->toString(); // Generate a unique link for the ujian
            $ujian->save();

            // Create ujian settings
            $ujianPengaturan = new \App\Models\UjianPengaturan();
            $ujianPengaturan->ujian_id = $ujian->id;
            $ujianPengaturan->nilai_kelulusan = $pengaturan['nilai_kelulusan'];
            $ujianPengaturan->hasil_ujian_tersedia = $pengaturan['hasil_ujian'];
            $ujianPengaturan->acak_soal = $pengaturan['acak_soal'] ?? false;
            $ujianPengaturan->acak_jawaban = $pengaturan['acak_jawaban'] ?? false;
            $ujianPengaturan->lihat_hasil = $pengaturan['lihat_hasil'] ?? false;
            $ujianPengaturan->lihat_pembahasan = $pengaturan['lihat_pembahasan'] ?? false;
            $ujianPengaturan->lockscreen = $pengaturan['lockscreen'] ?? false;
            $ujianPengaturan->is_arabic = $pengaturan['is_arabic'] ?? false;
            $ujianPengaturan->formula_type = $pengaturan['answer_type'];
            $ujianPengaturan->operation_1 = $pengaturan['operation'];
            $ujianPengaturan->value_1 = $pengaturan['value'];
            $ujianPengaturan->operation_2 = $pengaturan['operation2'];
            $ujianPengaturan->value_2 = $pengaturan['value2'];

            $ujianPengaturan->save();

            // Create ujian peserta form
            $ujianPesertaForm = new \App\Models\UjianPesertaForm();
            $ujianPesertaForm->ujian_id = $ujian->id;
            $ujianPesertaForm->nama = $peserta['nama'] ?? false;
            $ujianPesertaForm->phone = $peserta['phone'] ?? false;
            $ujianPesertaForm->email = $peserta['email'] ?? false;
            $ujianPesertaForm->institusi = $peserta['institusi'] ?? false;
            $ujianPesertaForm->nomor_induk = $peserta['nomor_induk'] ?? false;
            $ujianPesertaForm->tanggal_lahir = $peserta['tanggal_lahir'] ?? false;
            $ujianPesertaForm->alamat = $peserta['alamat'] ?? false;
            $ujianPesertaForm->foto = $peserta['foto'] ?? false;
            $ujianPesertaForm->save();

            // Create ujian theme
            $ujianThema = new \App\Models\UjianThema();
            $ujianThema->ujian_id = $ujian->id;
            $ujianThema->theme = $request->input('theme', 'classic');
            $ujianThema->institution_name = $request->input('institution_name');
            $ujianThema->welcome_message = $request->input('welcome_message');
            $ujianThema->use_custom_color = $request->input('use_custom_color', false);

            if ($request->input('use_custom_color')) {
                $ujianThema->use_custom_color = true;
                $ujianThema->primary_color = $request->input('primary_color');
                $ujianThema->secondary_color = $request->input('secondary_color');
                $ujianThema->tertiary_color = $request->input('tertiary_color');
                $ujianThema->background_color = $request->input('background_color');
                $ujianThema->header_color = $request->input('header_color');
                $ujianThema->font_color = $request->input('font_color');
                $ujianThema->button_color = $request->input('button_color');
                $ujianThema->button_font_color = $request->input('button_font_color');
            } else {
                $ujianThema->use_custom_color = false;
                $selectedTheme = $request->input('theme', 'klasik');

                if (isset($masterColors[$selectedTheme])) {
                    $themeColors = $masterColors[$selectedTheme];
                    $ujianThema->primary_color = $themeColors['primary_color'];
                    $ujianThema->secondary_color = $themeColors['secondary_color'];
                    $ujianThema->tertiary_color = $themeColors['tertiary_color'];

                    $ujianThema->background_color = $themeColors['background'];
                    $ujianThema->header_color = $themeColors['header'];
                    $ujianThema->font_color = $themeColors['font'];
                    $ujianThema->button_color = $themeColors['button'];
                    $ujianThema->button_font_color = $themeColors['button_font'];
                } else {
                    // Fallback to klasik theme if selected theme not found
                    $ujianThema->primary_color = $masterColors['klasik']['primary_color'];
                    $ujianThema->secondary_color = $masterColors['klasik']['secondary_color'];
                    $ujianThema->tertiary_color = $masterColors['klasik']['tertiary_color'];
                    $ujianThema->background_color = $masterColors['klasik']['background'];
                    $ujianThema->header_color = $masterColors['klasik']['header'];
                    $ujianThema->font_color = $masterColors['klasik']['font'];
                    $ujianThema->button_color = $masterColors['klasik']['button'];
                    $ujianThema->button_font_color = $masterColors['klasik']['button_font'];
                }
            }

            // Handle file uploads
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('ujian/logos', 'public');
                $ujianThema->logo_path = $logoPath;
            }

            if ($request->hasFile('background_image')) {
                $backgroundPath = $request->file('background_image')->store('ujian/backgrounds', 'public');
                $ujianThema->background_image_path = $backgroundPath;
            }

            if ($request->hasFile('header_image')) {
                $headerPath = $request->file('header_image')->store('ujian/headers', 'public');
                $ujianThema->header_image_path = $headerPath;
            }

            $ujianThema->save();

            // Create ujian sections
            foreach ($sections as $sectionData) {
                $ujianSection = new \App\Models\UjianSection();
                $ujianSection->ujian_id = $ujian->id;
                $ujianSection->nama_section = $sectionData['nama_section'];
                // $ujianSection->bobot_nilai = (float) $sectionData['bobot_nilai'];
                $ujianSection->instruksi = $sectionData['instruksi'] ?? null;
                $ujianSection->kategori_id = $sectionData['kategori_id'];
                $ujianSection->formula_type = $sectionData['formula_type'] ?? null;
                $ujianSection->operation_1 = $sectionData['operation_1'] ?? '*';
                $ujianSection->value_1 = (float) ($sectionData['value_1'] ?? 1);
                $ujianSection->operation_2 = $sectionData['operation_2'] ?? '*';
                $ujianSection->value_2 = (float) ($sectionData['value_2'] ?? 1);

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
        $ujian = Ujian::with(['ujianPengaturan', 'ujianPesertaForm', 'ujianSections.ujianSectionSoals.soal', 'ujianThema'])->findOrFail($id);

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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $masterColors = [
            'klasik' => [
                'primary_color' => '#ced4da',
                'secondary_color' => '#f8f9fa',
                'tertiary_color' => '#000000',
                'background' => '#f8f9fa',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#ced4da',
                'button_font' => '#000000',
            ],
            'modern' => [
                'primary_color' => '#0d6efd',
                'secondary_color' => '#ffffff',
                'tertiary_color' => '#000000',
                'background' => '#ffffff',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#0d6efd',
                'button_font' => '#ffffff',
            ],
            'glow' => [
                'primary_color' => 'linear-gradient(to right, #8e2de2, #f27121)',
                'secondary_color' => 'linear-gradient(to bottom, #ffe7a8, #fbb9b7)',
                'tertiary_color' => '#000000',
                'background' => '#fff3cd', // fallback background glow
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#f27121',
                'button_font' => '#ffffff',
            ],
            'minimal' => [
                'primary_color' => '#6c757d',
                'secondary_color' => '#f8f9fa',
                'tertiary_color' => '#000000',
                'background' => '#f8f9fa',
                'header' => '#f8f9fa',
                'font' => '#000000',
                'button' => '#6c757d',
                'button_font' => '#ffffff',
            ],
        ];
        // dd($request);
        Log::info("message update", [
            'request' => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            // Parse JSON data from FormData
            $detail = json_decode($request->input('detail'), true) ?? $request->detail ?? [];
            $peserta = json_decode($request->input('peserta'), true) ?? $request->peserta ?? [];
            $pengaturan = json_decode($request->input('pengaturan'), true) ?? $request->pengaturan ?? [];
            $sections = json_decode($request->input('sections'), true) ?? $request->sections ?? [];

            Log::info("Parsed Data", [
                'detail' => $detail,
                'peserta' => $peserta,
                'pengaturan' => $pengaturan,
                'sections' => $sections,
            ]);

            // Find existing ujian
            $ujian = Ujian::findOrFail($id);
            $ujian->nama_ujian   = $detail['nama'];
            $ujian->deskripsi = $detail['deskripsi'];
            $ujian->durasi = $detail['durasi'];
            $ujian->jenis_ujian_id = $detail['jenis_ujian'];
            $ujian->tanggal_selesai = $detail['tanggal_selesai'];
            $ujian->status = $detail['status'] ?? 'draft'; // Default to 'draft' if not provided
            $ujian->save();

            // Update ujian settings
            $ujianPengaturan = $ujian->ujianPengaturan;
            $ujianPengaturan->ujian_id = $ujian->id;
            $ujianPengaturan->nilai_kelulusan = $pengaturan['nilai_kelulusan'];
            $ujianPengaturan->hasil_ujian_tersedia = $pengaturan['hasil_ujian'];
            $ujianPengaturan->acak_soal = $pengaturan['acak_soal'] ?? false;
            $ujianPengaturan->acak_jawaban = $pengaturan['acak_jawaban'] ?? false;
            $ujianPengaturan->lihat_hasil = $pengaturan['lihat_hasil'] ?? false;
            $ujianPengaturan->lihat_pembahasan = $pengaturan['lihat_pembahasan'] ?? false;
            $ujianPengaturan->lockscreen = $pengaturan['lockscreen'] ?? false;
            $ujianPengaturan->is_arabic = $pengaturan['is_arabic'] ?? false;
            $ujianPengaturan->formula_type = $pengaturan['answer_type'];
            $ujianPengaturan->operation_1 = $pengaturan['operation'];
            $ujianPengaturan->value_1 = $pengaturan['value'];
            $ujianPengaturan->operation_2 = $pengaturan['operation2'];
            $ujianPengaturan->value_2 = $pengaturan['value2'];
            $ujianPengaturan->save();

            // Update ujian peserta form
            $ujianPesertaForm = $ujian->ujianPesertaForm;
            $ujianPesertaForm->nama = $peserta['nama'] ?? false;
            $ujianPesertaForm->phone = $peserta['phone'] ?? false;
            $ujianPesertaForm->email = $peserta['email'] ?? false;
            $ujianPesertaForm->institusi = $peserta['institusi'] ?? false;
            $ujianPesertaForm->nomor_induk = $peserta['nomor_induk'] ?? false;
            $ujianPesertaForm->tanggal_lahir = $peserta['tanggal_lahir'] ?? false;
            $ujianPesertaForm->alamat = $peserta['alamat'] ?? false;
            $ujianPesertaForm->foto = $peserta['foto'] ?? false;
            $ujianPesertaForm->save();

            // Update ujian theme
            $ujianThema = $ujian->ujianThema;
            if (!$ujianThema) {
                $ujianThema = new \App\Models\UjianThema();
                $ujianThema->ujian_id = $ujian->id;
            }

            $ujianThema->theme = $request->input('theme', 'classic');
            $ujianThema->institution_name = $request->input('institution_name');
            $ujianThema->welcome_message = $request->input('welcome_message');
            $ujianThema->use_custom_color = $request->input('use_custom_color', false);

            if ($request->input('use_custom_color')) {
                $ujianThema->use_custom_color = true;
                $ujianThema->primary_color = $request->input('primary_color');
                $ujianThema->secondary_color = $request->input('secondary_color');
                $ujianThema->tertiary_color = $request->input('tertiary_color');
                $ujianThema->background_color = $request->input('background_color');
                $ujianThema->header_color = $request->input('header_color');
                $ujianThema->font_color = $request->input('font_color');
                $ujianThema->button_color = $request->input('button_color');
                $ujianThema->button_font_color = $request->input('button_font_color');
            } else {
                $ujianThema->use_custom_color = false;
                $selectedTheme = $request->input('theme', 'klasik');

                if (isset($masterColors[$selectedTheme])) {
                    $themeColors = $masterColors[$selectedTheme];
                    $ujianThema->primary_color = $themeColors['primary_color'];
                    $ujianThema->secondary_color = $themeColors['secondary_color'];
                    $ujianThema->tertiary_color = $themeColors['tertiary_color'];
                    $ujianThema->background_color = $themeColors['background'];
                    $ujianThema->header_color = $themeColors['header'];
                    $ujianThema->font_color = $themeColors['font'];
                    $ujianThema->button_color = $themeColors['button'];
                    $ujianThema->button_font_color = $themeColors['button_font'];
                } else {
                    // Fallback to klasik theme if selected theme not found
                    $ujianThema->primary_color = $masterColors['klasik']['primary_color'];
                    $ujianThema->secondary_color = $masterColors['klasik']['secondary_color'];
                    $ujianThema->tertiary_color = $masterColors['klasik']['tertiary_color'];
                    $ujianThema->background_color = $masterColors['klasik']['background'];
                    $ujianThema->header_color = $masterColors['klasik']['header'];
                    $ujianThema->font_color = $masterColors['klasik']['font'];
                    $ujianThema->button_color = $masterColors['klasik']['button'];
                    $ujianThema->button_font_color = $masterColors['klasik']['button_font'];
                }
            }

            // Handle file uploads
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($ujianThema->logo_path && Storage::disk('public')->exists($ujianThema->logo_path)) {
                    Storage::disk('public')->delete($ujianThema->logo_path);
                }
                $logoPath = $request->file('logo')->store('ujian/logos', 'public');
                $ujianThema->logo_path = $logoPath;
            }

            if ($request->hasFile('background_image')) {
                // Delete old background if exists
                if ($ujianThema->background_image_path && Storage::disk('public')->exists($ujianThema->background_image_path)) {
                    Storage::disk('public')->delete($ujianThema->background_image_path);
                }
                $backgroundPath = $request->file('background_image')->store('ujian/backgrounds', 'public');
                $ujianThema->background_image_path = $backgroundPath;
            }

            if ($request->hasFile('header_image')) {
                // Delete old header if exists
                if ($ujianThema->header_image_path && Storage::disk('public')->exists($ujianThema->header_image_path)) {
                    Storage::disk('public')->delete($ujianThema->header_image_path);
                }
                $headerPath = $request->file('header_image')->store('ujian/headers', 'public');
                $ujianThema->header_image_path = $headerPath;
            }

            $ujianThema->save();

            // Update ujian sections
            // Delete existing section soals first
            foreach ($ujian->ujianSections as $section) {
                $section->ujianSectionSoals()->delete();
            }

            // Then delete the sections
            $ujian->ujianSections()->delete();
            foreach ($sections as $sectionData) {
                $ujianSection = new \App\Models\UjianSection();
                $ujianSection->ujian_id = $ujian->id;
                $ujianSection->nama_section = $sectionData['nama_section'];
                // $ujianSection->bobot_nilai = (float) $sectionData['bobot_nilai'];
                $ujianSection->instruksi = $sectionData['instruksi'] ?? null;
                $ujianSection->kategori_id = $sectionData['kategori_id'];
                $ujianSection->formula_type = $sectionData['formula_type'] ?? null;
                $ujianSection->operation_1 = $sectionData['operation_1'] ?? '*';
                $ujianSection->value_1 = (float) ($sectionData['value_1'] ?? 1);
                $ujianSection->operation_2 = $sectionData['operation_2'] ?? '*';
                $ujianSection->value_2 = (float) ($sectionData['value_2'] ?? 1);
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
                'message' => 'Ujian berhasil diperbarui',
                'data' => $ujian
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            // Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui ujian: ' . $e->getMessage()
            ], 500);
        }
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

            $ujian->ujianThema()->delete();

            // Delete related hasil ujian
            $ujian->hasilUjian()->delete();

            // Delete related sertifikat
            $ujian->sertifikats()->delete();

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
