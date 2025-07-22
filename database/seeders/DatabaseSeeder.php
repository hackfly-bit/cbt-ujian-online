<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use PHPUnit\Event\Code\Test;

class DatabaseSeeder extends Seeder
{
     // update
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate([
            'email' => 'attex@coderthemes.com'
        ], [
            'name' => 'Attex',
            'email_verified_at' => now(),
            'role' => 'Super Admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // Call Bank Soal seeder
        $this->call([
            BankSoalSeeder::class,
            TestUjianSeeder::class,
            HasilUjianSeeder::class,
            UjianThemaSeeder::class,
        ]);
    }
}
