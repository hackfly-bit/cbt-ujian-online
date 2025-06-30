<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Peserta;
use App\Models\HasilUjian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Mengambil data untuk statistik
            $totalUjian = Ujian::count();
            $totalSoal = Soal::count();
            $totalPeserta = Peserta::count();
            $totalSelesaiUjian = HasilUjian::where('status', 'completed')->count();

            // Mengambil data ujian terbaru (5 teratas) dengan eager loading
            $ujianTerbaru = HasilUjian::with(['ujian', 'peserta'])
                ->select('ujian_id', 'created_at')
                ->orderBy('created_at', 'desc')
                ->groupBy('ujian_id', 'created_at')
                ->take(5)
                ->get()
                ->map(function($hasil) {
                    // Count participants for this exam
                    $jumlahPeserta = HasilUjian::where('ujian_id', $hasil->ujian_id)->count();

                    // Format date
                    $tanggal = Carbon::parse($hasil->created_at)->format('d M Y');

                    // Get exam status
                    $status = $hasil->ujian->status ? 'Aktif' : 'Nonaktif';

                    return [
                        'id' => $hasil->ujian_id,
                        'nama' => $hasil->ujian->nama_ujian,
                        'tanggal' => $tanggal,
                        'peserta' => $jumlahPeserta,
                        'status' => $status,
                        'status_class' => $hasil->ujian->status ? 'text-success bg-green-light' : 'text-danger bg-danger-light'
                    ];
                });

            return view('index', compact('totalUjian', 'totalSoal', 'totalPeserta', 'totalSelesaiUjian', 'ujianTerbaru'));

        } catch (\Exception $e) {
            // Jika terjadi error, set default values untuk mencegah undefined variable
            $totalUjian = 0;
            $totalSoal = 0;
            $totalPeserta = 0;
            $totalSelesaiUjian = 0;
            $ujianTerbaru = collect();

            // Log error untuk debugging
            Log::error('Dashboard Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return view('index', compact('totalUjian', 'totalSoal', 'totalPeserta', 'totalSelesaiUjian', 'ujianTerbaru'));
        }
    }
}
