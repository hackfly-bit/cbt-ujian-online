<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoris = Kategori::select(['id', 'nama', 'deskripsi', 'created_at']);

            return DataTables::of($kategoris)
                ->addIndexColumn()
                ->addColumn('action', function ($kategori) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-id="' . $kategori->id . '" title="Edit">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $kategori->id . '" title="Hapus">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    ';
                })
                // ->editColumn('created_at', function ($kategori) {
                //     return $kategori->created_at->format('d/m/Y H:i');
                // })
                ->editColumn('deskripsi', function ($kategori) {
                    return $kategori->deskripsi ?: '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('mastering.master-kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori,nama',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategori = Kategori::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategori = Kategori::findOrFail($id);

            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            // Check if kategori is being used (you can add this check later)
            // if ($kategori->soals()->count() > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Kategori tidak dapat dihapus karena masih digunakan'
            //     ], 422);
            // }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
