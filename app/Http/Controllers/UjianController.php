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
                    $isActive = $row->status === 'aktif';

                    // Tombol Lihat Ujian - disabled jika status bukan aktif
                    $lihatUjianBtn = $isActive
                        ? '<a href="' . $url . '" class="text-success" title="Lihat Ujian" target="_blank"><i class="ri-eye-line"></i></a>'
                        : '<span class="text-muted opacity-50" title="Ujian tidak aktif" style="cursor: not-allowed;"><i class="ri-eye-line"></i></span>';

                    // Tombol Salin Link - disabled jika status bukan aktif
                    $salinLinkBtn = $isActive
                        ? '<a href="javascript:void(0)" class="text-secondary copy-link" data-link="' . $url . '" title="Salin Link"><i class="ri-file-copy-line"></i></a>'
                        : '<span class="text-muted opacity-50" title="Ujian tidak aktif" style="cursor: not-allowed;"><i class="ri-file-copy-line"></i></span>';

                    return '<div class="action-icons d-flex gap-2 justify-content-center">
                        <a href="' . route('ujian.show', $row->id) . '" class="text-primary" title="Edit">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        ' . $lihatUjianBtn . '
                        ' . $salinLinkBtn . '
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
            'ujian' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $masterColors = [
            'klasik' => [
                'primary_color'   => '#2c2c2c',                                 // Nama instansi & footer
                'secondary_color' => '#6c757d',                                 // Teks sambutan
                'tertiary_color'  => '#f5f5f5',                                 // Card
                'background'      => '#ffffff',                                 // Latar belakang utama
                'header'          => '#f0f0f0',                                 // Header sambutan
                'font'            => '#212529',                                 // Font isi card
                'button'          => '#0080ff',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
            ],
            'modern' => [
                'primary_color'   => '#2e2e2e',                                 // Nama instansi & footer
                'secondary_color' => '#f8f9fa',                                 // Teks sambutan
                'tertiary_color'  => '#ffffff',                                 // Card
                'background'      => '#eff5ff',                                 // Latar belakang utama
                'header'          => '#0d6efd',                                 // Header sambutan
                'font'            => '#212529',                                 // Font isi card
                'button'          => '#0d6efd',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
            ],
            'glow' => [
                'primary_color'   => '#252525',                                 // Nama instansi & footer
                'secondary_color' => '#ffffff',                                 // Teks sambutan
                'tertiary_color'  => '#ffffff',                                 // Card
                'background'      => 'linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%)', // Latar belakang
                'header'          => 'linear-gradient(135deg, #6f42c1 0%, #e83e8c 50%, #fd7e14 100%)', // Header sambutan
                'font'            => '#252525',                                 // Font isi card
                'button'          => '#6f42c1',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
            ],
        ];


        Log::info("Ujian Store Request", [
            'request' => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            // --- JSON Data ---
            $detail = json_decode($request->input('detail'), true) ?? $request->detail ?? [];
            $peserta = json_decode($request->input('peserta'), true) ?? $request->peserta ?? [];
            $pengaturan = json_decode($request->input('pengaturan'), true) ?? $request->pengaturan ?? [];
            $sections = json_decode($request->input('sections'), true) ?? $request->sections ?? [];

            // --- Ujian ---
            $ujian = new Ujian();
            $ujian->nama_ujian = $detail['nama'];
            $ujian->deskripsi = $detail['deskripsi'];
            $ujian->durasi = $detail['durasi'];
            $ujian->jenis_ujian_id = $detail['jenis_ujian'];
            $ujian->tanggal_selesai = $detail['tanggal_selesai'];
            $ujian->status = $detail['status'] ?? 'draft';
            $ujian->link = Str::uuid()->toString();
            $ujian->save();

            // --- Pengaturan ---
            $ujianPengaturan = new \App\Models\UjianPengaturan([
                'ujian_id' => $ujian->id,
                'nilai_kelulusan' => $pengaturan['nilai_kelulusan'],
                'hasil_ujian_tersedia' => $pengaturan['hasil_ujian'] ?? false,
                'acak_soal' => null,
                'acak_jawaban' => null,
                'lihat_hasil' => $pengaturan['lihat_hasil'] ?? false,
                'lihat_pembahasan' => $pengaturan['lihat_pembahasan'] ?? false,
                'lockscreen' => $pengaturan['lockscreen'] ?? false,
                'is_arabic' => $pengaturan['is_arabic'] ?? false,
                'formula_type' => $pengaturan['answer_type'] ?? null,
                'operation_1' => $pengaturan['operation'] ?? '*',
                'value_1' => $pengaturan['value'] ?? 1,
                'operation_2' => $pengaturan['operation2'] ?? '*',
                'value_2' => $pengaturan['value2'] ?? 1,
            ]);
            $ujianPengaturan->save();

            // --- Form Peserta ---
            $ujianPesertaForm = new \App\Models\UjianPesertaForm([
                'ujian_id' => $ujian->id,
                'nama' => $peserta['nama'] ?? false,
                'phone' => $peserta['phone'] ?? false,
                'email' => $peserta['email'] ?? false,
                'institusi' => $peserta['institusi'] ?? false,
                'nomor_induk' => $peserta['nomor_induk'] ?? false,
                'tanggal_lahir' => $peserta['tanggal_lahir'] ?? false,
                'alamat' => $peserta['alamat'] ?? false,
                'foto' => $peserta['foto'] ?? false,
            ]);
            $ujianPesertaForm->save();

            // --- Theme ---
            $use_custom_color = $request->boolean('use_custom_color') ? 1 : 0;
            $show_institution_name = $request->boolean('show_institution_name') ? 1 : 0;

            $selectedTheme = $request->input('theme', 'klasik');

            $ujianThema = new \App\Models\UjianThema();
            $ujianThema->ujian_id = $ujian->id;
            $ujianThema->theme = $selectedTheme;
            $ujianThema->institution_name = $show_institution_name ? $request->input('institution_name') : null;
            $ujianThema->welcome_message = $request->input('welcome_message');
            $ujianThema->use_custom_color = $use_custom_color;
            $ujianThema->show_institution_name = $show_institution_name;

            if ($use_custom_color) {
                $ujianThema->primary_color = $request->input('primary_color');
                $ujianThema->secondary_color = $request->input('secondary_color');
                $ujianThema->tertiary_color = $request->input('tertiary_color');
                $ujianThema->background_color = $request->input('background_color');
                $ujianThema->header_color = $request->input('header_color');
                $ujianThema->font_color = $request->input('font_color');
                $ujianThema->button_color = $request->input('button_color');
                $ujianThema->button_font_color = $request->input('button_font_color');
            } else {
                $themeColors = $masterColors[$selectedTheme] ?? $masterColors['klasik'];
                $ujianThema->primary_color = $themeColors['primary_color'];
                $ujianThema->secondary_color = $themeColors['secondary_color'];
                $ujianThema->tertiary_color = $themeColors['tertiary_color'];
                $ujianThema->background_color = $themeColors['background'];
                $ujianThema->header_color = $themeColors['header'];
                $ujianThema->font_color = $themeColors['font'];
                $ujianThema->button_color = $themeColors['button'];
                $ujianThema->button_font_color = $themeColors['button_font'];
            }

            // --- File Uploads ---
            if ($request->hasFile('logo')) {
                $logoFile = $request->file('logo');
                $logoName = time() . '_' . $logoFile->getClientOriginalName();
                $logoFile->move(public_path('images/ujian/logos'), $logoName);
                $ujianThema->logo_path = 'images/ujian/logos/' . $logoName;
            }

            if ($request->hasFile('background_image')) {
                $backgroundFile = $request->file('background_image');
                $backgroundName = time() . '_' . $backgroundFile->getClientOriginalName();
                $backgroundFile->move(public_path('images/ujian/backgrounds'), $backgroundName);
                $ujianThema->background_image_path = 'images/ujian/backgrounds/' . $backgroundName;
            }

            if ($request->hasFile('header_image')) {
                $headerFile = $request->file('header_image');
                $headerName = time() . '_' . $headerFile->getClientOriginalName();
                $headerFile->move(public_path('images/ujian/headers'), $headerName);
                $ujianThema->header_image_path = 'images/ujian/headers/' . $headerName;
            }

            // --- Hapus jika diminta (walau sangat jarang di store) ---
            if ($request->input('remove_background_image') == '1') {
                if ($ujianThema->background_image_path && file_exists(public_path($ujianThema->background_image_path))) {
                    @unlink(public_path($ujianThema->background_image_path));
                }
                $ujianThema->background_image_path = null;
            }

            if ($request->input('remove_header_image') == '1') {
                if ($ujianThema->header_image_path && file_exists(public_path($ujianThema->header_image_path))) {
                    @unlink(public_path($ujianThema->header_image_path));
                }
                $ujianThema->header_image_path = null;
            }

            $ujianThema->save();

            // --- Sections + Soal ---
            foreach ($sections as $sectionData) {
                $ujianSection = new \App\Models\UjianSection();
                $ujianSection->ujian_id = $ujian->id;
                $ujianSection->nama_section = $sectionData['nama_section'];
                $ujianSection->instruksi = $sectionData['instruksi'] ?? null;
                $ujianSection->kategori_id = $sectionData['kategori_id'];
                $ujianSection->formula_type = $sectionData['formula_type'] ?? null;
                $ujianSection->operation_1 = $sectionData['operation_1'] ?? '*';
                $ujianSection->value_1 = (float) ($sectionData['value_1'] ?? 1);
                $ujianSection->operation_2 = $sectionData['operation_2'] ?? '*';
                $ujianSection->value_2 = (float) ($sectionData['value_2'] ?? 1);
                $ujianSection->save();

                foreach ($sectionData['selected_questions'] as $soalId) {
                    $ujianSectionSoal = new \App\Models\UjianSectionSoal([
                        'ujian_section' => $ujianSection->id,
                        'soal_id' => $soalId
                    ]);
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

            Log::error("Error store ujian", ['error' => $e]);

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
                'primary_color'   => '#2c2c2c',                                 // Nama instansi & footer
                'secondary_color' => '#6c757d',                                 // Teks sambutan
                'tertiary_color'  => '#f5f5f5',                                 // Card
                'background'      => '#ffffff',                                 // Latar belakang utama
                'header'          => '#f0f0f0',                                 // Header sambutan
                'font'            => '#212529',                                 // Font isi card
                'button'          => '#0080ff',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
            ],
            'modern' => [
                'primary_color'   => '#2e2e2e',                                 // Nama instansi & footer
                'secondary_color' => '#f8f9fa',                                 // Teks sambutan
                'tertiary_color'  => '#ffffff',                                 // Card
                'background'      => '#eff5ff',                                 // Latar belakang utama
                'header'          => '#0d6efd',                                 // Header sambutan
                'font'            => '#212529',                                 // Font isi card
                'button'          => '#0d6efd',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
            ],
            'glow' => [
                'primary_color'   => '#252525',                                 // Nama instansi & footer
                'secondary_color' => '#ffffff',                                 // Teks sambutan
                'tertiary_color'  => '#ffffff',                                 // Card
                'background'      => 'linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%)', // Latar belakang
                'header'          => 'linear-gradient(135deg, #6f42c1 0%, #e83e8c 50%, #fd7e14 100%)', // Header sambutan
                'font'            => '#252525',                                 // Font isi card
                'button'          => '#6f42c1',                                 // Tombol
                'button_font'     => '#ffffff',                                 // Warna teks tombol
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
            $ujianPengaturan->hasil_ujian_tersedia = $pengaturan['hasil_ujian'] ?? false;
            $ujianPengaturan->acak_soal = null;
            $ujianPengaturan->acak_jawaban = null;
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

            $use_custom_color = $request->boolean('use_custom_color') ? 1 : 0;
            $show_institution_name = $request->boolean('show_institution_name') ? 1 : 0;

            if ($use_custom_color == 0) {
                $ujianThema->logo_path = null;
            }

            if ($show_institution_name == 0) {
                $ujianThema->institution_name = null;
            }

            $ujianThema->theme = $request->input('theme', 'classic');
            $ujianThema->institution_name = $request->input('institution_name');
            $ujianThema->welcome_message = $request->input('welcome_message');
            $ujianThema->use_custom_color = $use_custom_color;
            $ujianThema->show_institution_name = $show_institution_name;

            $selectedTheme = $request->input('theme', 'custom');

            // Cek apakah tema yang dipilih ada di daftar tema
            if (isset($masterColors[$selectedTheme])) {
                $themeColors = $masterColors[$selectedTheme];
            } else {
                // Fallback ke tema klasik
                $selectedTheme = 'klasik';
                $themeColors = $masterColors['klasik'];
            }

            // Simpan tema dan warnanya ke ujianThema
            $ujianThema->theme = $selectedTheme;
            $ujianThema->primary_color = $themeColors['primary_color'];
            $ujianThema->secondary_color = $themeColors['secondary_color'];
            $ujianThema->tertiary_color = $themeColors['tertiary_color'];
            $ujianThema->background_color = $themeColors['background'];
            $ujianThema->header_color = $themeColors['header'];
            $ujianThema->font_color = $themeColors['font'];
            $ujianThema->button_color = $themeColors['button'];
            $ujianThema->button_font_color = $themeColors['button_font'];


            // Handle file uploads
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($ujianThema->logo_path && file_exists(public_path($ujianThema->logo_path))) {
                    unlink(public_path($ujianThema->logo_path));
                }

                $logoFile = $request->file('logo');
                $logoName = time() . '_' . $logoFile->getClientOriginalName();
                $logoFile->move(public_path('images/ujian/logos'), $logoName);
                // Simpan path relatif dari public
                $ujianThema->logo_path = 'images/ujian/logos/' . $logoName;
            }

            // === File Upload ===
            if ($request->hasFile('background_image')) {
                if ($ujianThema->background_image_path && file_exists(public_path($ujianThema->background_image_path))) {
                    @unlink(public_path($ujianThema->background_image_path));
                }

                $backgroundFile = $request->file('background_image');
                $backgroundName = time() . '_' . $backgroundFile->getClientOriginalName();
                $backgroundFile->move(public_path('images/ujian/backgrounds'), $backgroundName);
                $ujianThema->background_image_path = 'images/ujian/backgrounds/' . $backgroundName;
            }

            if ($request->hasFile('header_image')) {
                if ($ujianThema->header_image_path && file_exists(public_path($ujianThema->header_image_path))) {
                    @unlink(public_path($ujianThema->header_image_path));
                }

                $headerFile = $request->file('header_image');
                $headerName = time() . '_' . $headerFile->getClientOriginalName();
                $headerFile->move(public_path('images/ujian/headers'), $headerName);
                $ujianThema->header_image_path = 'images/ujian/headers/' . $headerName;
            }

            // === Hapus jika diminta ===
            if ($request->input('remove_background_image') == '1') {
                if ($ujianThema->background_image_path && file_exists(public_path($ujianThema->background_image_path))) {
                    @unlink(public_path($ujianThema->background_image_path));
                }
                $ujianThema->background_image_path = null;
            }

            if ($request->input('remove_header_image') == '1') {
                if ($ujianThema->header_image_path && file_exists(public_path($ujianThema->header_image_path))) {
                    @unlink(public_path($ujianThema->header_image_path));
                }
                $ujianThema->header_image_path = null;
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

            Log::error($e);

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
