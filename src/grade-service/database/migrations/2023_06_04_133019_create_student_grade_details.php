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
        Schema::create('student_grade_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_grade_id')->constrained('student_grades');
            $table->integer('assignment_plan_task_id');
            $table->integer('criteria_level_id');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grade_details');
    }
};
