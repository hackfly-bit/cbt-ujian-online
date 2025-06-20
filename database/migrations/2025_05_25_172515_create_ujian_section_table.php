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
            $table->integer('id', true);
            $table->integer('ujian_id')->nullable()->index('ujian_id');
            $table->string('nama_section')->nullable();
            $table->float('bobot_nilai', 10, 0)->nullable();
            $table->integer('kategori_id')->nullable()->index('kategori_id');
            // $table->string('instruksi', 65535)->nullable();
            $table->text('instruksi')->nullable();
            $table->string('formula_type')->nullable();
            $table->string('operation_1')->default('*');
            $table->decimal('value_1', 8, 2)->default(1);
            $table->string('operation_2')->default('*');
            $table->decimal('value_2', 8, 2)->default(1);
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
        Schema::dropIfExists('ujian_section');
    }
};
