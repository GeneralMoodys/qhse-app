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
        Schema::create('root_cause_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accident_id')->constrained()->onDelete('cascade');
            $table->string('analysis_method')->nullable()->comment('Contoh: 5 Whys, Fishbone');
            $table->json('analysis_data')->nullable()->comment('Menyimpan detail analisis terstruktur');
            $table->text('root_cause_summary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('root_cause_analyses');
    }
};