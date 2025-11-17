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
        Schema::table('audits', function (Blueprint $table) {
            $table->dateTime('schedule_date')->change();
        });

        Schema::table('actions', function (Blueprint $table) {
            $table->dateTime('due_date')->change();
            $table->dateTime('effectiveness_verification_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->date('schedule_date')->change();
        });

        Schema::table('actions', function (Blueprint $table) {
            $table->date('due_date')->change();
            $table->date('effectiveness_verification_date')->nullable()->change();
        });
    }
};