<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ujian_pengaturan', function (Blueprint $table) {
            $table->boolean('lockscreen')->default(false)->after('lihat_pembahasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_pengaturan', function (Blueprint $table) {
            $table->dropColumn('lockscreen');
        });
    }
};
