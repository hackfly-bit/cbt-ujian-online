<?php

namespace App\Http\Controllers;

use App\Models\TingkatKesulitan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TingkatKesulitanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = TingkatKesulitan::select(['id', 'nama', 'deskripsi', 'created_at']);

            return DataTables::of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-id="' . $item->id . '" title="Edit">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $item->id . '" title="Hapus">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    ';
                })
                ->editColumn('deskripsi', function ($item) {
                    return $item->deskripsi ?: '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('mastering.master-tingkat-kesulitan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:tingkat_kesulitan,nama',
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama tingkat kesulitan wajib diisi',
            'nama.unique' => 'Nama tingkat kesulitan sudah ada',
            'nama.max' => 'Nama tingkat kesulitan maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item = TingkatKesulitan::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tingkat kesulitan berhasil ditambahkan',
                'data' => $item
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tingkat kesulitan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $item = TingkatKesulitan::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tingkat kesulitan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:tingkat_kesulitan,nama,' . $id,
            'deskripsi' => 'nullable|string|max:1000'
        ], [
            'nama.required' => 'Nama tingkat kesulitan wajib diisi',
            'nama.unique' => 'Nama tingkat kesulitan sudah ada',
            'nama.max' => 'Nama tingkat kesulitan maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item = TingkatKesulitan::findOrFail($id);

            $item->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tingkat kesulitan berhasil diperbarui',
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tingkat kesulitan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = TingkatKesulitan::findOrFail($id);

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tingkat kesulitan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tingkat kesulitan: ' . $e->getMessage()
            ], 500);
        }
    }
}
