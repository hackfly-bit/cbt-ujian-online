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
        Schema::create('ujian_section', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('ujian_id')->nullable()->index('ujian_id');
            $table->string('nama_section')->nullable();
            $table->decimal('bobot_nilai', 10, 0)->nullable();
            $table->text('instruksi')->nullable();
            $table->string('metode_penilaian')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujian_section');
    }
};
