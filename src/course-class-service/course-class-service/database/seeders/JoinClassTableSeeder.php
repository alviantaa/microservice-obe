<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JoinClassTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$joinclasses = [
			[
				'id' => 1,
				'course_class_id' => 1,
				'student_user_id' => 1
			],
			[
				'id' => 2,
				'course_class_id' => 1,
				'student_user_id' => 2
			],


		];
		foreach ($joinclasses as $joinclass) {
			DB::table('join_classes')->insert($joinclass);
		}
	}
}
