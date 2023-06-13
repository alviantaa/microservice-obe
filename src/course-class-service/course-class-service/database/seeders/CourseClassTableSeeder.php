<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CourseClassTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$courseclasses = [
			[
				'id' => 1,
				'course_id' => 5,
				'name' => 'Pemrograman Web Lanjut A',
				'class_code' => 'PWL-A',
				'thumbnail_img' => 'https://via.placeholder.com/640x480.png/000088?text=cats',
				'creator_user_id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'syllabus_id' => 1,
			],
			[
				'id' => 5,
				'course_id' => 4,
				'name' => 'Pemrograman Web Lanjut B',
				'class_code' => 'PWL-B',
				'thumbnail_img' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.logique.co.id%2Fblog%2F2020%2F10%2F01%2Flaravel-8%2F&psig=AOvVaw25hbA_maofxtBgcDyJaZ_H&ust=1685351576316000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCID4p4HWl_8CFQAAAAAdAAAAABAE',
				'creator_user_id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'syllabus_id' => 1,
			],
			

		];
		foreach ($courseclasses as $courseclass) {
			DB::table('course_classes')->insert($courseclass);
		}
	}
}
