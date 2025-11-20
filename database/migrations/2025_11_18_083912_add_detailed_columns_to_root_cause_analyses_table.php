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
        Schema::table('root_cause_analyses', function (Blueprint $table) {
            // Existing columns: id, accident_id, analysis_method, analysis_data, root_cause_summary, timestamps

            // New columns from CSV analysis
            $table->string('root_cause_category')->nullable()->after('root_cause_summary'); // Maps to 'Penyebab dasar' text
            $table->boolean('is_human_factor')->default(false)->after('root_cause_category');
            $table->boolean('is_equipment_factor')->default(false)->after('is_human_factor');
            $table->boolean('is_material_factor')->default(false)->after('is_equipment_factor');
            $table->boolean('is_method_factor')->default(false)->after('is_material_factor');
            $table->boolean('is_environment_factor')->default(false)->after('is_method_factor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('root_cause_analyses', function (Blueprint $table) {
            $table->dropColumn([
                'root_cause_category',
                'is_human_factor',
                'is_equipment_factor',
                'is_material_factor',
                'is_method_factor',
                'is_environment_factor',
            ]);
        });
    }
};