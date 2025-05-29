<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;

class UjianController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $soals = \App\Models\Soal::with(['kategori', 'tingkatKesulitan', 'subKategori'])
                ->select(['id', 'pertanyaan', 'jenis_font', 'is_audio', 'kategori_id', 'tingkat_kesulitan_id', 'sub_kategori_id', 'created_at', 'jenis_isian']);

            if ($request->has('kategori') && $request->kategori !== 'all') {
                $soals->where('kategori_id', (int) $request->kategori);
            }

            return datatables()->of($soals->get())
                ->addIndexColumn()
                ->addColumn('pertanyaan', function ($row) {
                    return  $row->pertanyaan;
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
                            <a href="javascript:void(0)" class="text-primary" title="Edit" onclick="editSoal(' . $row->id . ')">
                                <i class="ri-edit-2-line"></i>
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
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Ujian', 'url' => route('ujian.index')],
            ],
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
        //validation

        // logic

        $ujian = new Ujian();
        $ujian->jenis_ujian_id = $request->jenis_ujian_id;
        $ujian->nama = $request->nama;
        $ujian->deskripsi = $request->deskripsi;
        $ujian->durasi = $request->durasi;
        $ujian->tanggal_selesai = $request->tanggal_selesai;
        $ujian->link = $request->link;
        $ujian->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
