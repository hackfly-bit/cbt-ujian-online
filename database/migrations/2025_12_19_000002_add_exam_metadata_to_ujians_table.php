<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ujian', function (Blueprint $table) {
            if (!Schema::hasColumn('ujian', 'exam_metadata')) {
                $table->json('exam_metadata')->nullable()->after('scoring_formula');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ujian', function (Blueprint $table) {
            if (Schema::hasColumn('ujian', 'exam_metadata')) {
                $table->dropColumn('exam_metadata');
            }
        });
    }
};