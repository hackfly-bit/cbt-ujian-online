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
        Schema::dropIfExists('ujian_themas');
        Schema::create('ujian_themas', function (Blueprint $table) {
            $table->id();
            $table->integer('ujian_id')->nullable()->index('ujian_id');
            $table->string('theme')->default('classic'); // classic, modern, glow, minimal
            $table->string('logo_path')->nullable();
            $table->string('background_image_path')->nullable();
            $table->string('header_image_path')->nullable();
            $table->string('institution_name')->nullable();
            $table->text('welcome_message')->nullable();
            // Default theme colors
            $table->string('background_color')->default('#ffffff')->nullable();
            $table->string('header_color')->default('#f8f9fa')->nullable(); // Default header color
            // Custom color settings
            $table->boolean('use_custom_color')->default(false)->nullable();
            $table->string('primary_color')->nullable(); // Primary color
            $table->string('secondary_color')->nullable(); // Secondary color
            $table->string('tertiary_color')->nullable(); // Accent color
            $table->string('font_color')->default('#000000')->nullable(); // Default font color
            $table->string('button_color')->default('#007bff')->nullable(); // Default button color
            $table->string('button_font_color')->default('#ffffff')->nullable(); // Default button font color
            $table->timestamps();

            // Foreign key constraint
            $table->foreign(['ujian_id'], 'ujian_thema_ibfk_1')->references(['id'])->on('ujian')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_themas');
    }
};
