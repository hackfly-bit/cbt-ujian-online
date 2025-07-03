<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Models\Sertifikat;
use App\Models\Ujian;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $hasilUjian = HasilUjian::with(['peserta', 'ujian', 'sertifikat'])->findOrFail($id);

        $sertifikat = Sertifikat::where('ujian_id', $hasilUjian->ujian_id)->first();

        if (!$sertifikat || !$sertifikat->template) {
            return response()->json([
                'success' => false,
                'message' => 'Template sertifikat tidak ditemukan.'
            ], 404);
        }

        $templateJson = json_decode($sertifikat->template, true);

        if (!$templateJson || !is_array($templateJson)) {
            return response()->json([
                'success' => false,
                'message' => 'Template JSON tidak valid.'
            ], 500);
        }

        $templateVars = [
            'peserta_nama'   => $hasilUjian->peserta->nama ?? '-',
            'phone'          => $hasilUjian->peserta->phone ?? '-',
            'alamat'         => $hasilUjian->peserta->alamat ?? '-',
            'institusi'      => $hasilUjian->peserta->institusi ?? '-',
            'tanggal_lahir'  => $hasilUjian->peserta->tanggal_lahir
                ? \Carbon\Carbon::parse($hasilUjian->peserta->tanggal_lahir)->translatedFormat('d F Y')
                : '-',
            'ujian_nama'     => $hasilUjian->ujian->nama_ujian ?? '-',
            'nilai'          => number_format($hasilUjian->hasil_nilai, 2),
            'tanggal_ujian'  => $hasilUjian->waktu_selesai
                ? \Carbon\Carbon::parse($hasilUjian->waktu_selesai)->translatedFormat('d F Y')
                : now()->translatedFormat('d F Y'),
        ];

        $nilaiSection = [];
        $totalNilai = 0;
        $detail = json_decode($hasilUjian->detail_section, true);

        if (is_array($detail)) {
            foreach ($detail as $section) {
                $label = 'Nilai ' . $section['section_name'];
                $nilaiSection[$label] = number_format($section['score'], 2);
                $totalNilai += $section['score'];
            }
        }

        $templateVars['nilai_section'] = $nilaiSection;
        $templateVars['total_nilai'] = number_format($totalNilai, 2);

        // Ambil URL dan path foto peserta
        $fotoPesertaPath = $hasilUjian->peserta->foto
            ? public_path($hasilUjian->peserta->foto)
            : public_path('images/placeholder.jpeg');

        $fotoPesertaUrl = $hasilUjian->peserta->foto
            ? asset($hasilUjian->peserta->foto)
            : asset('images/placeholder.jpeg');

        // Generate QR Code URL untuk hasil ujian
        $qrCodeUrl = url('/hasil-ujian-ku/' . $hasilUjian->id);
        
        if (isset($templateJson['objects']) && is_array($templateJson['objects'])) {
            $templateJson['objects'] = array_map(function ($obj) use ($templateVars, $fotoPesertaUrl, $fotoPesertaPath, $qrCodeUrl) {

                // Replace teks
                if (
                    isset($obj['type'], $obj['text']) &&
                    strtolower($obj['type']) === 'textbox' &&
                    is_string($obj['text'])
                ) {
                    $obj['text'] = preg_replace_callback('/\[(.*?)\]/', function ($matches) use ($templateVars) {
                        $key = trim($matches[1]);

                        if (isset($templateVars['nilai_section'][$key])) {
                            return $templateVars['nilai_section'][$key];
                        }

                        $static = [
                            'Nama Lengkap'   => $templateVars['peserta_nama'],
                            'No. Telp'       => $templateVars['phone'],
                            'Alamat'         => $templateVars['alamat'],
                            'Institusi'      => $templateVars['institusi'],
                            'Tanggal Lahir'  => $templateVars['tanggal_lahir'],
                            'Nama Ujian'     => $templateVars['ujian_nama'],
                            'Tanggal Ujian'  => $templateVars['tanggal_ujian'],
                            'Nilai Ujian'    => $templateVars['nilai'],
                            'Total Nilai'    => $templateVars['total_nilai'],
                        ];

                        return $static[$key] ?? $matches[0];
                    }, $obj['text']);
                }

                // Replace gambar
                if (
                    isset($obj['type'], $obj['src']) &&
                    strtolower($obj['type']) === 'image' &&
                    str_contains($obj['src'], 'placeholder.jpeg')
                ) {
                    // Simpan dimensi asli placeholder
                    $originalWidth = $obj['width'] ?? 1;
                    $originalHeight = $obj['height'] ?? 1;
                    $originalScaleX = $obj['scaleX'] ?? 1;
                    $originalScaleY = $obj['scaleY'] ?? 1;
                    
                    // Get template placeholder dimensions (ukuran yang terlihat)
                    $templateWidth = $originalWidth * $originalScaleX;
                    $templateHeight = $originalHeight * $originalScaleY;

                    // Get participant photo dimensions
                    $imageSize = false;
                    if (file_exists($fotoPesertaPath)) {
                        $imageSize = getimagesize($fotoPesertaPath);
                    }

                    if ($imageSize) {
                        $photoWidth = $imageSize[0];
                        $photoHeight = $imageSize[1];

                        // Calculate aspect ratios
                        $templateRatio = $templateWidth / $templateHeight;
                        $photoRatio = $photoWidth / $photoHeight;

                        // Calculate scale to fit photo in template area
                        if ($photoRatio > $templateRatio) {
                            // Photo is wider - fit to height
                            $scale = $templateHeight / $photoHeight;
                        } else {
                            // Photo is taller - fit to width
                            $scale = $templateWidth / $photoWidth;
                        }

                        // Update object properties - pertahankan width/height asli, ubah scale
                        $obj['src'] = $fotoPesertaUrl;
                        $obj['width'] = $photoWidth;
                        $obj['height'] = $photoHeight;
                        $obj['scaleX'] = $scale;
                        $obj['scaleY'] = $scale;
                        
                        // Center the image in the original placeholder position
                        $scaledWidth = $photoWidth * $scale;
                        $scaledHeight = $photoHeight * $scale;
                        
                        if (isset($obj['left'], $obj['top'])) {
                            // Hitung offset untuk centering
                            $offsetX = ($templateWidth - $scaledWidth) / 2;
                            $offsetY = ($templateHeight - $scaledHeight) / 2;
                            
                            // Pertahankan posisi asli placeholder dan tambahkan offset centering
                            $obj['left'] = $obj['left'] + $offsetX;
                            $obj['top'] = $obj['top'] + $offsetY;
                        }
                    } else {
                        // Fallback if image dimensions cannot be determined
                        $obj['src'] = $fotoPesertaUrl;
                        // Pertahankan dimensi dan scale asli placeholder
                        $obj['width'] = $originalWidth;
                        $obj['height'] = $originalHeight;
                        $obj['scaleX'] = $originalScaleX;
                        $obj['scaleY'] = $originalScaleY;
                    }

                    // Reset crop settings
                    $obj['cropX'] = 0;
                    $obj['cropY'] = 0;
                    $obj['objectFit'] = 'contain';
                }

                // Replace QR Code
                if (
                    isset($obj['type'], $obj['src']) &&
                    strtolower($obj['type']) === 'image' &&
                    str_contains($obj['src'], 'qrcode.jpg')
                ) {
                    // Simpan dimensi asli placeholder QR code
                    $originalWidth = $obj['width'] ?? 200;
                    $originalHeight = $obj['height'] ?? 200;
                    $originalScaleX = $obj['scaleX'] ?? 1;
                    $originalScaleY = $obj['scaleY'] ?? 1;
                    
                    // Get template placeholder dimensions (ukuran yang terlihat)
                    $templateWidth = $originalWidth * $originalScaleX;
                    $templateHeight = $originalHeight * $originalScaleY;
                    
                    // Tentukan ukuran QR code berdasarkan ukuran placeholder
                    $qrSize = max($templateWidth, $templateHeight);
                    
                    // Generate QR Code sebagai SVG dengan ukuran yang disesuaikan
                    $qrCodeSvg = QrCode::format('svg')
                        ->size($qrSize)
                        ->margin(1)
                        ->generate($qrCodeUrl);
                    
                    // Convert SVG ke data URL
                    $qrCodeDataUrl = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                    
                    // Update src dengan QR code yang di-generate
                    $obj['src'] = $qrCodeDataUrl;
                    
                    // Sesuaikan dimensi QR code dengan placeholder
                    $obj['width'] = $qrSize;
                    $obj['height'] = $qrSize;
                    
                    // Hitung scale untuk fit ke placeholder
                    $scaleX = $templateWidth / $qrSize;
                    $scaleY = $templateHeight / $qrSize;
                    $scale = min($scaleX, $scaleY); // Gunakan scale terkecil untuk maintain aspect ratio
                    
                    $obj['scaleX'] = $scale;
                    $obj['scaleY'] = $scale;
                    
                    // Center QR code dalam placeholder
                    $scaledWidth = $qrSize * $scale;
                    $scaledHeight = $qrSize * $scale;
                    
                    if (isset($obj['left'], $obj['top'])) {
                        // Hitung offset untuk centering
                        $offsetX = ($templateWidth - $scaledWidth) / 2;
                        $offsetY = ($templateHeight - $scaledHeight) / 2;
                        
                        // Pertahankan posisi asli placeholder dan tambahkan offset centering
                        $obj['left'] = $obj['left'] + $offsetX;
                        $obj['top'] = $obj['top'] + $offsetY;
                    }
                    
                    // Reset crop settings untuk QR code
                    $obj['cropX'] = 0;
                    $obj['cropY'] = 0;
                    $obj['objectFit'] = 'contain';
                }

                return $obj;
            }, $templateJson['objects']);
        }

        Log::info('Template JSON:', $templateJson);

        return response()->json([
            'success' => true,
            'data' => [
                'sertifikat'    => $templateJson,
                'judul'         => $sertifikat->judul ?? 'Sertifikat',
                'peserta_nama'  => $templateVars['peserta_nama'],
                'tanggal_ujian' => $templateVars['tanggal_ujian'],
                'ujian_nama'    => $templateVars['ujian_nama'],
                'template_data' => $templateVars,
                'template'      => true,
            ]
        ]);
    }





    /**
     * Menampilkan hasil ujian publik (untuk QR Code)
     */
    public function showPublicResult(string $id)
    {
        $hasilUjian = HasilUjian::with(['peserta', 'ujian', 'sertifikat'])->findOrFail($id);

        // Parse detail section jika ada
        $detailSection = null;
        if ($hasilUjian->detail_section) {
            $detailSection = json_decode($hasilUjian->detail_section, true);
        }

        $data = [
            'title' => 'Hasil Ujian - ' . ($hasilUjian->peserta->nama ?? 'Peserta'),
            'hasil_ujian' => [
                'id' => $hasilUjian->id,
                'peserta' => [
                    'nama' => $hasilUjian->peserta->nama ?? '-',
                    'email' => $hasilUjian->peserta->email ?? '-',
                    'phone' => $hasilUjian->peserta->phone ?? '-',
                    'institusi' => $hasilUjian->peserta->institusi ?? '-',
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
        ];

        return view('hasil-ujian.public', $data);
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
}
