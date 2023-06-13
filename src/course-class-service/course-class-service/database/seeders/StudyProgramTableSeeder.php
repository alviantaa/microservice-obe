<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudyProgramTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$studyprograms = [
			[
				'id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'name' => 'Teknologi Informasi',
			],
			[
				'id' => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'name' => 'Sistem Informasi',
			],
			[
				'id' => 3,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'name' => 'Pendidikan Teknologi Informasi',
			],
			[
				'id' => 4,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'name' => 'Teknik Informatika',
			],
			[
				'id' => 5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'name' => 'Teknik Komputer',
			],
		];
		foreach ($studyprograms as $studyprogram) {
			DB::table('study_programs')->insert($studyprogram);
		}
	}
}
