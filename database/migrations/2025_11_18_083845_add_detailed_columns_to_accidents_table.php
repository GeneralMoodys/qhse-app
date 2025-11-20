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
        Schema::table('accidents', function (Blueprint $table) {
            // Existing columns: id, user_id, location, accident_date, description, initial_action, timestamps

            // New columns from CSV analysis
            $table->string('division')->nullable()->after('accident_date');
            $table->string('employee_name')->nullable()->after('user_id'); // Assuming user_id is for the reporter, this is the involved employee
            $table->string('employee_age_group')->nullable()->after('employee_name'); // e.g., '21 - 25'
            $table->string('equipment_type')->nullable()->after('employee_age_group');
            $table->string('accident_time_range')->nullable()->after('accident_date'); // e.g., '06.01 - 12.00'
            $table->text('consequence')->nullable()->after('description'); // Maps to 'Akibat'
            $table->decimal('financial_loss', 15, 2)->nullable()->after('consequence'); // Maps to 'Jumlah Kerugian (Rp)'
            $table->json('injured_body_parts')->nullable()->after('financial_loss'); // Maps to 'Bagian Organ Tubuh Cedera' flags
            $table->json('accident_types')->nullable()->after('injured_body_parts'); // Maps to 'Jenis Kecelakaan' flags
            $table->integer('lost_work_days')->nullable()->after('accident_types'); // Maps to 'Jumlah Hari Kerja Hilang (Hari)'
            $table->string('photo_path')->nullable()->after('lost_work_days'); // Maps to 'Foto Kejadian'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accidents', function (Blueprint $table) {
            $table->dropColumn([
                'division',
                'employee_name',
                'employee_age_group',
                'equipment_type',
                'accident_time_range',
                'consequence',
                'financial_loss',
                'injured_body_parts',
                'accident_types',
                'lost_work_days',
                'photo_path',
            ]);
        });
    }
};