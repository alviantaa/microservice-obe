<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('join_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_class_id');
            // $table->foreign('course_class_id')->references('id')->on('course_class')->onDelete('cascade');
            $table->unsignedBigInteger('student_user_id');
            // $table->foreign('student_user_id')->references('id')->on('user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('join_classes', function (Blueprint $table) {
            $table->dropForeign('course_class_id');
            $table->dropForeign('student_user_id');

            $table->dropColumn('course_class_id');
            $table->dropColumn('student_user_id');

            Schema::dropIfExists('join_classes');
        });
    }
};
