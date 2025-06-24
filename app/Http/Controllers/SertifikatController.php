<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sertifikats = Sertifikat::with('ujian')->select(['id', 'judul', 'ujian_id', 'created_at']);

            return DataTables::of($sertifikats)
                ->addIndexColumn()
                ->addColumn('ujian_nama', function ($row) {
                    return $row->ujian ? $row->ujian->nama_ujian : 'Tanpa Ujian';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="action-icons d-flex gap-2 justify-content-center">
                        <a href="javascript:void(0)" class="text-info btn-preview" data-id="' . $row->id . '" title="Preview">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="' . route('sertifikat.edit', $row->id) . '" class="text-primary" title="Edit">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sertifikat.index');
    }

    public function create()
    {
        $ujians = Ujian::all();

        $templates = [
            [
                'id' => 'template1',
                'name' => 'Template 1',
                'image' => asset('images/template1.jpeg'),
                'content' => json_encode([
                    'html' => view('sertifikat.template.template1')->render(),
                ]),
            ],
            [
                'id' => 'template2',
                'name' => 'Template 2',
                'image' => asset('images/placeholder.jpeg'),
                'content' => json_encode([
                    'html' => '<div class="text-center p-5">Template 2 Placeholder</div>',
                ]),
            ],
            [
                'id' => 'template3',
                'name' => 'Template 3',
                'image' => asset('images/placeholder.jpeg'),
                'content' => json_encode([
                    'html' => '<div class="text-center p-5">Template 3 Placeholder</div>',
                ]),
            ],
            [
                'id' => 'template4',
                'name' => 'Template 4',
                'image' => asset('images/placeholder.jpeg'),
                'content' => json_encode([
                    'html' => '<div class="text-center p-5">Template 4 Placeholder</div>',
                ]),
            ],
        ];

        return view('sertifikat.create', compact('ujians', 'templates'));
    }



    public function store(Request $request)
    {


        // dd($request->all());

        $sertifikat = Sertifikat::create([
            'judul' => $request->judul,
            'ujian_id' => $request->ujian_id,
            'template' => $request->template,
        ]);

        if ($request->is_custom == 1) {
            // Redirect ke halaman canvas editor
            return redirect()->route('sertifikat.edit', ['id' => $sertifikat->id]);
        }

        // Redirect biasa jika bukan custom
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan');
    }


    public function edit($id)
    {
        $sertifikat = Sertifikat::with('ujian')->findOrFail($id);

        // Ambil section dari tabel ujian_section
        $sections = \App\Models\UjianSection::where('ujian_id', $sertifikat->ujian_id)
            ->get();

        return view('sertifikat.template', compact('sertifikat', 'sections'));
    }


    public function template()
    {

        return view('sertifikat.template');
    }

    public function updateTemplate(Request $request, $id)
    {
        $sertifikat = Sertifikat::findOrFail($id);

        // dd($request->all());

        $sertifikat->update([
            'template' => $request->template,
        ]);

        return response()->json(['success' => true, 'message' => 'Template berhasil disimpan.']);
    }

    public function destroy($id)
    {
        Sertifikat::findOrFail($id)->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function preview($id)
    {
        $sertifikat = Sertifikat::with('ujian')->findOrFail($id);

        $templateData = null;
        $templateImage = null;

        if ($sertifikat->template) {
            $template = json_decode($sertifikat->template, true);
            $templateData = $template;

            // Check if template has image or HTML content
            if (isset($template['image'])) {
                $templateImage = $template['image'];
            } elseif (isset($template['html'])) {
                // For HTML content, we can create a preview
                $templateImage = 'data:text/html;base64,' . base64_encode($template['html']);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $sertifikat->id,
                'judul' => $sertifikat->judul,
                'ujian_nama' => $sertifikat->ujian ? $sertifikat->ujian->nama_ujian : 'Tanpa Ujian',
                'template' => $templateData,
                'template_image' => $templateImage,
                'created_at' => $sertifikat->created_at->format('d F Y')
            ]
        ]);
    }
}
