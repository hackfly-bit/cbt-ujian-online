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
     */    public function up()
    {
        Schema::table('jawaban_pesertas', function (Blueprint $table) {
            if (!Schema::hasColumn('jawaban_pesertas', 'answer_tracking')) {
                $table->json('answer_tracking')->nullable();
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
        Schema::table('jawaban_pesertas', function (Blueprint $table) {
            if (Schema::hasColumn('jawaban_pesertas', 'answer_tracking')) {
                $table->dropColumn('answer_tracking');
            }
        });
    }
};