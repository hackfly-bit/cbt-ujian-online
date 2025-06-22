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
            $totalUjian = Ujian::count() ?? 0;
            $totalSoal = Soal::count() ?? 0;
            $totalPeserta = Peserta::count() ?? 0;
            $totalSelesaiUjian = HasilUjian::where('status', 'completed')->count() ?? 0;

            // Mengambil data ujian terbaru (3 teratas)
            $ujianTerbaru = Ujian::orderBy('created_at', 'desc')
                ->take(3)
                ->get()
                ->map(function($ujian) {
                    // Menghitung jumlah peserta untuk setiap ujian
                    $jumlahPeserta = Peserta::where('ujian_id', $ujian->id)->count();

                    // Format tanggal
                    $tanggal = Carbon::parse($ujian->created_at)->format('d M Y');

                    // Status ujian
                    $status = $ujian->status ? 'Aktif' : 'Nonaktif';

                    return [
                        'nama' => $ujian->nama_ujian,
                        'tanggal' => $tanggal,
                        'peserta' => $jumlahPeserta,
                        'status' => $status,
                        'status_class' => $ujian->status ? 'text-success bg-green-light' : 'text-danger bg-danger-light'
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
            Log::error('Dashboard Error: ' . $e->getMessage());

            return view('index', compact('totalUjian', 'totalSoal', 'totalPeserta', 'totalSelesaiUjian', 'ujianTerbaru'));
        }
    }
}
