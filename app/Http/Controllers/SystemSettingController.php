<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SystemSettingController extends Controller
{
    public function index()
    {
        // Ambil data profil
        $profil = [
            'nama' => Auth::user()->name ?? '',
            'email' => Auth::user()->email ?? '',
            'image' => Auth::user()->foto ?? '',
        ];
        // Ambil data logo
        $branding = [
            'logoPutih' => SystemSetting::where('group', 'branding')->where('key', 'logoPutih')->value('value') ?? '',
            'logoHitam' => SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ?? '',
            'favLogoPutih' => SystemSetting::where('group', 'branding')->where('key', 'favLogoPutih')->value('value') ?? '',
            'favLogoHitam' => SystemSetting::where('group', 'branding')->where('key', 'favLogoHitam')->value('value') ?? '',
        ];
        return view('pengaturan.index', compact('profil', 'branding'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('pengaturan.index')->with('error', 'User tidak ditemukan.');
        }

        if ($request->filled('nama')) {
            $user->name = $request->nama;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'profil_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image'), $filename);
            $user->foto = 'image/' . $filename;
        }
        $user->save();

        return redirect()->route('pengaturan.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logoPutih' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logoHitam' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favLogoPutih' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favLogoHitam' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($request->all());

        $logoTypes = ['logoPutih', 'logoHitam', 'favLogoPutih', 'favLogoHitam'];

        foreach ($logoTypes as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);
                $filename = strtolower($type) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('image'), $filename);
                $url = 'image/' . $filename;

                SystemSetting::updateOrCreate(
                    ['group' => 'branding', 'key' => $type],
                    ['value' => $url, 'type' => 'string']
                );
            }
        }

        return redirect()->route('pengaturan.index', ['tab' => 'branding'])->with('success', 'Logo berhasil diperbarui');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('pengaturan.index', ['#reset-password'])->with('error', 'User tidak ditemukan.');
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('pengaturan.index', ['#reset-password'])->with('error', 'Password saat ini salah.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('pengaturan.index', ['#reset-password'])->with('success', 'Password berhasil diubah.');
    }
}
