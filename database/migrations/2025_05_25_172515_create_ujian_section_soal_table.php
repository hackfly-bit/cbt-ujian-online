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
        Schema::create('ujian_section_soal', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('soal_id')->nullable()->index('soal_id');
            $table->integer('ujian_section')->nullable()->index('ujian_section');
                  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujian_section_soal');
    }
};
