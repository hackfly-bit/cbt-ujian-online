<?php

namespace App\Http\Controllers;
use App\Models\JenisUjian;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JenisUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jenisUjians = JenisUjian::select(['id', 'nama', 'deskripsi', 'created_at']);

            return DataTables::of($jenisUjians)
                ->addIndexColumn()
                ->addColumn('action', function ($jenisUjian) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-id="' . $jenisUjian->id . '" title="Edit">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $jenisUjian->id . '" title="Hapus">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    ';
                })
                // ->editColumn('created_at', function ($jenisUjian) {
                //     return $jenisUjian->created_at->format('d/m/Y H:i');
                // })
                ->editColumn('deskripsi', function ($jenisUjian) {
                    return $jenisUjian->deskripsi ?: '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('mastering.master-jenis-ujian');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:jenis_ujian,nama',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama jenis ujian wajib diisi',
            'nama.unique' => 'Nama jenis ujian sudah ada',
            'nama.max' => 'Nama jenis ujian maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jenisUjian = JenisUjian::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis Ujian berhasil ditambahkan',
                'data' => $jenisUjian
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan jenis ujian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $jenisUjian = JenisUjian::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $jenisUjian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis Ujian tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama jenis ujian wajib diisi',
            'nama.unique' => 'Nama jenis ujian sudah ada',
            'nama.max' => 'Nama jenis ujian maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jenisUjian = JenisUjian::findOrFail($id);

            $jenisUjian->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis Ujian berhasil diperbarui',
                'data' => $jenisUjian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui jenis ujian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jenisUjian = JenisUjian::findOrFail($id);

            // Check if jenis ujian is being used (you can add this check later)
            // if ($jenisUjian->soals()->count() > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Jenis Ujian tidak dapat dihapus karena masih digunakan'
            //     ], 422);
            // }

            $jenisUjian->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jenis Ujian berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jenis ujian: ' . $e->getMessage()
            ], 500);
        }
    }
}
