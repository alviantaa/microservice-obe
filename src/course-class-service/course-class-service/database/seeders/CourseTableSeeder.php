<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class CourseTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$courses = [
			[
				'id' => 1,
				'study_program_id' => 1,
				'creator_user_id' => 1,
				'name' => 'Pemrograman Web Lanjut',
				'code' => 'A123',
				'course_credit' => 3,
				'lab_credit' => 1,
				'type' => 'mandatory',
				'short_description' => 'Pemrograman Web tingkat Lanjut',
				'minimal_requirement' => 'Pemrograman Web',
				'study_material' => 'laravel',
				'learning_media' => 'slack',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 2,
				'study_program_id' => 1,
				'creator_user_id' => 1,
				'name' => 'Microservice Architecture',
				'code' => 'B123',
				'course_credit' => 3,
				'lab_credit' => 1,
				'type' => 'mandatory',
				'short_description' => 'Microservice',
				'minimal_requirement' => 'test',
				'study_material' => 'laravel',
				'learning_media' => 'slack',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 3,
				'study_program_id' => 3,
				'creator_user_id' => 2,
				'name' => 'Enterprise Architecture',
				'code' => 'C123',
				'course_credit' => 2,
				'lab_credit' => 0,
				'type' => 'elective',
				'short_description' => 'Mata kuliah pilihan',
				'minimal_requirement' => 'test',
				'study_material' => 'Archie',
				'learning_media' => 'Eling',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
		];
		foreach ($courses as $course) {
			DB::table('courses')->insert($course);
		}
	}
}
