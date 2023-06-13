<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SyllabusTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$syllabus = [
			[
				'id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'course_id' => 2,
				'title' => 'Pemahaman Dasar Microservice',
				'author' => 'Amelia Kartika',
				'head_of_study_program' => 'Widhy Hayuhardika',
				'creator_user_id' => 1
			],
			[
				'id' => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'course_id' => 2,
				'title' => 'Pemahaman Dasar Microservice',
				'author' => 'Amelia Kartika',
				'head_of_study_program' => 'Widhy Hayuhardika',
				'creator_user_id' => 1
			],

		];
		foreach ($syllabus as $syllabi) {
			DB::table('syllabi')->insert($syllabi);
		}
	}
}
