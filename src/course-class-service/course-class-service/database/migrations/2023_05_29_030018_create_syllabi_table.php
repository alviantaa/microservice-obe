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
		Schema::create('syllabi', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->unsignedBigInteger('course_id');
			$table->string('title');
			$table->string('author');
			$table->string('head_of_study_program');
			$table->unsignedBigInteger('creator_user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::create('syllabi', function (Blueprint $table) {

			$table->dropColumn('course_id');
			$table->dropColumn('creator_user_id');

			Schema::dropIfExists('syllabi');
		});
	}
};
