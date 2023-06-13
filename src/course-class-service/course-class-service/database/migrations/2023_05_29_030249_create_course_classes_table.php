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
		Schema::create('course_classes', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('course_id');
			$table->string('name');
			$table->string('thumbnail_img');
			$table->string('class_code');
			$table->unsignedBigInteger('creator_user_id');
			$table->timestamps();
			$table->unsignedBigInteger('syllabus_id');
		});
	}
	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::create('course_classes', function (Blueprint $table) {

			$table->dropColumn('course_id');
			$table->dropColumn('creator_user_id');
			$table->dropColumn('syllabus_id');

			Schema::dropIfExists('course_classes');
		});
	}
};
