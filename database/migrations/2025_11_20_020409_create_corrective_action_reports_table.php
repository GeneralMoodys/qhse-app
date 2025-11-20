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
        Schema::create('corrective_action_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('root_cause_analysis_id')->constrained('root_cause_analyses')->cascadeOnDelete();
            $table->string('number')->unique();
            $table->enum('source_of_information', ['internal', 'external']);
            $table->unsignedBigInteger('issued_by');
            $table->date('issued_date');
            $table->enum('status', ['open', 'closed', 'continued'])->default('open');
            $table->text('management_notes')->nullable();
            $table->unsignedBigInteger('mr_approved_by')->nullable();
            $table->timestamp('mr_approved_at')->nullable();
            $table->unsignedBigInteger('director_approved_by')->nullable();
            $table->timestamp('director_approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrective_action_reports');
    }
};