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
        Schema::table('actions', function (Blueprint $table) {
            $table->foreignId('corrective_action_report_id')->nullable()->constrained('corrective_action_reports')->cascadeOnDelete();
            $table->text('verification_notes')->nullable();
            $table->string('verification_attachment_path')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropForeign(['corrective_action_report_id']);
            $table->dropColumn([
                'corrective_action_report_id',
                'verification_notes',
                'verification_attachment_path',
                'verified_by',
                'verified_at',
            ]);
        });
    }
};