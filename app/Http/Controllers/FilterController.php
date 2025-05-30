<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\TingkatKesulitan;
use App\Models\SubKategori;
use App\Models\Ujian;
use App\Models\UjianSectionSoal;

class FilterController extends Controller
{
    public function getSoals(Request $request)
    {
        $soals = Soal::with(['kategori', 'tingkatKesulitan', 'subKategori'])
            ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at', 'jenis_isian']);

        return response()->json([
            'data' => $soals->get(),
        ]);
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


    // get data data from ujianSectionsSoals and merge with soal if soal exists in ujianSectionsSoals dont show it
    public function getUjianSectionsSoals(Request $request)
    {
        $query = Soal::with(['ujianSectionSoals','kategori', 'tingkatKesulitan', 'subKategori'])
            ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at', 'jenis_isian']);

        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $ujianSectionsSoals = $query->get();

        return response()->json([
            'data' => $ujianSectionsSoals,
        ]);
    }
}
