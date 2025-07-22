<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UjianThema;
use App\Models\Ujian;

class UjianThemaSeeder extends Seeder
{
     // update
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing ujian records
        $ujians = Ujian::all();

        $themes = ['classic', 'modern', 'glow', 'minimal'];

        foreach ($ujians as $index => $ujian) {
            // Skip if theme already exists
            if ($ujian->ujianThema) {
                continue;
            }

            $theme = $themes[$index % count($themes)];

            UjianThema::create([
                'ujian_id' => $ujian->id,
                'theme' => $theme,
                'institution_name' => 'Universitas Contoh',
                'welcome_message' => 'Selamat datang di ujian online. Pastikan Anda sudah mempersiapkan diri dengan baik.',
                'use_custom_color' => false,
                'background_color' => '#ffffff',
                'header_color' => '#f8f9fa',
            ]);
        }
    }
}
