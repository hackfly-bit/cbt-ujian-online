<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Ujian;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikats = Sertifikat::with('ujian')->latest()->get();
        return view('sertifikat.index', compact('sertifikats'));
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
        $sertifikat = Sertifikat::findOrFail($id);
        return view('sertifikat.template', compact('sertifikat'));
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
}
