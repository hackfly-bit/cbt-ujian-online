<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Models\Sertifikat;
use Yajra\DataTables\Facades\DataTables;

class HasilUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hasilUjians = HasilUjian::with(['peserta', 'ujian', 'sertifikat'])
                ->select(['id', 'peserta_id', 'ujian_id', 'hasil_nilai', 'waktu_selesai', 'sertifikat_id', 'created_at']);

            return DataTables::of($hasilUjians)
                ->addIndexColumn()
                ->addColumn('peserta_nama', function ($row) {
                    return $row->peserta ? $row->peserta->nama : '-';
                })
                ->addColumn('ujian_nama', function ($row) {
                    return $row->ujian ? $row->ujian->nama_ujian : '-';
                })
                ->addColumn('waktu_selesai_formatted', function ($row) {
                    return $row->waktu_selesai ? \Carbon\Carbon::parse($row->waktu_selesai)->format('d-m-Y H:i') : '-';
                })
                ->addColumn('skor_formatted', function ($row) {
                    return $row->hasil_nilai ? number_format($row->hasil_nilai, 2) : '0.00';
                })
                ->addColumn('action', function ($row) {
                    $actions = '<div class="action-icons d-flex gap-2 justify-content-center">';

                    // Tombol lihat detail
                    $actions .= '<a href="javascript:void(0)" class="text-primary btn-detail" data-id="' . $row->id . '" title="Lihat Detail">
                        <i class="ri-eye-line"></i>
                    </a>';

                    // Tombol lihat sertifikat (hanya jika ada sertifikat)
                    if ($row->sertifikat_id && $row->sertifikat) {
                        $actions .= '<a href="javascript:void(0)" class="text-success btn-certificate" data-id="' . $row->id . '" title="Lihat Sertifikat">
                            <i class="ri-award-line"></i>
                        </a>';
                    } else {
                        $actions .= '<span class="text-muted" title="Sertifikat Tidak Tersedia">
                            <i class="ri-award-line"></i>
                        </span>';
                    }

                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('hasil-ujian.index', [
            'title' => 'Hasil Ujian',
            'active' => 'hasil-ujian',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hasilUjian = HasilUjian::with(['peserta', 'ujian', 'sertifikat'])
            ->findOrFail($id);

        // Parse detail section jika ada
        $detailSection = null;
        if ($hasilUjian->detail_section) {
            $detailSection = json_decode($hasilUjian->detail_section, true);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $hasilUjian->id,
                'peserta' => [
                    'nama' => $hasilUjian->peserta->nama ?? '-',
                    'email' => $hasilUjian->peserta->email ?? '-',
                ],
                'ujian' => [
                    'nama_ujian' => $hasilUjian->ujian->nama_ujian ?? '-',
                    'deskripsi' => $hasilUjian->ujian->deskripsi ?? '-',
                ],
                'hasil' => [
                    'total_soal' => $hasilUjian->total_soal,
                    'soal_dijawab' => $hasilUjian->soal_dijawab,
                    'jawaban_benar' => $hasilUjian->jawaban_benar,
                    'hasil_nilai' => number_format($hasilUjian->hasil_nilai, 2),
                    'durasi_pengerjaan' => $hasilUjian->durasi_pengerjaan . ' menit',
                ],
                'waktu' => [
                    'waktu_mulai' => $hasilUjian->waktu_mulai ? \Carbon\Carbon::parse($hasilUjian->waktu_mulai)->format('d-m-Y H:i:s') : '-',
                    'waktu_selesai' => $hasilUjian->waktu_selesai ? \Carbon\Carbon::parse($hasilUjian->waktu_selesai)->format('d-m-Y H:i:s') : '-',
                ],
                'detail_section' => $detailSection,
                'status' => $hasilUjian->status,
                'sertifikat_available' => $hasilUjian->sertifikat_id ? true : false
            ]
        ]);
    }

    /**
     * Menampilkan sertifikat
     */
    public function showCertificate(string $id)
    {
        $hasilUjian = HasilUjian::with(['peserta', 'ujian', 'sertifikat'])
            ->findOrFail($id);

        if (!$hasilUjian->sertifikat_id || !$hasilUjian->sertifikat) {
            return response()->json([
                'success' => false,
                'message' => 'Sertifikat tidak tersedia untuk hasil ujian ini.'
            ], 404);
        }

        // Template sertifikat
        $templateData = [
            'peserta_nama' => $hasilUjian->peserta->nama ?? 'Tidak Diketahui',
            'ujian_nama' => $hasilUjian->ujian->nama_ujian ?? 'Tidak Diketahui',
            'nilai' => number_format($hasilUjian->hasil_nilai, 2),
            'tanggal_selesai' => $hasilUjian->waktu_selesai ? $hasilUjian->waktu_selesai->format('d F Y') : date('d F Y'),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'sertifikat' => $hasilUjian->sertifikat,
                'template_data' => $templateData
            ]
        ]);
    }

    /**
     * Download hasil ujian dalam format Excel/CSV
     */
    public function downloadResults(Request $request)
    {
        // Implementasi download akan ditambahkan nanti
        $hasilUjians = HasilUjian::with(['peserta', 'ujian'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Download akan segera dimulai',
            'data' => $hasilUjians->count() . ' hasil ujian ditemukan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
