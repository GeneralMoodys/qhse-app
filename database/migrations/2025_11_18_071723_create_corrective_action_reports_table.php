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
            $table->foreignId('root_cause_analysis_id')->constrained()->onDelete('cascade');
            $table->text('action_plan');
            $table->foreignId('person_in_charge')->constrained('users');
            $table->date('due_date');
            $table->string('status')->default('open'); // e.g., open, in_progress, closed, verified
            $table->text('effectiveness_review')->nullable();
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