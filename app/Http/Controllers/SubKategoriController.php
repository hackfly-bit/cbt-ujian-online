<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubKategori;
use App\Models\Kategori;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if($request->ajax()) {

            $subKategoris = SubKategori::with('kategori')
                ->select(['id', 'nama', 'deskripsi', 'kategori_id', 'created_at']);

            return DataTables::of($subKategoris)
                ->addIndexColumn()
                ->addColumn('kategori_nama', function ($subKategori) {
                    return $subKategori->kategori ? $subKategori->kategori->nama : '-';
                })
                ->addColumn('action', function ($subKategori) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-id="' . $subKategori->id . '" title="Edit">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $subKategori->id . '" title="Hapus">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    ';
                })
                ->editColumn('deskripsi', function ($subKategori) {
                    return $subKategori->deskripsi ?: '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kategoris = Kategori::all();

        return view('mastering.master-sub-kategori', compact('kategoris'));
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
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak ditemukan',
            'nama.required' => 'Nama sub kategori wajib diisi',
            'nama.max' => 'Nama sub kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subKategori = SubKategori::create([
                'kategori_id' => $request->kategori_id,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub kategori berhasil ditambahkan',
                'data' => $subKategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan sub kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $subKategori = SubKategori::with('kategori')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $subKategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sub kategori tidak ditemukan'
            ], 404);
        }
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
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak ditemukan',
            'nama.required' => 'Nama sub kategori wajib diisi',
            'nama.max' => 'Nama sub kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subKategori = SubKategori::findOrFail($id);

            $subKategori->update([
                'kategori_id' => $request->kategori_id,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub kategori berhasil diperbarui',
                'data' => $subKategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui sub kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subKategori = SubKategori::findOrFail($id);
            $subKategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sub kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus sub kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
