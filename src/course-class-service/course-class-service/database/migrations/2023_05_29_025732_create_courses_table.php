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
		Schema::create('courses', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('study_program_id');
			$table->unsignedBigInteger('creator_user_id');
			$table->string('name');
			$table->string('code');
			$table->integer('course_credit');
			$table->integer('lab_credit');
			$table->enum('type', ['mandatory', 'elective']);
			$table->string('short_description');
			$table->string('minimal_requirement');
			$table->string('study_material')->nullable();
			$table->string('learning_media');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::create('courses', function (Blueprint $table) {
			$table->dropColumn('study_program_id');
			$table->dropColumn('creator_class_id');

			Schema::dropIfExists('courses');
		});
	}
};
