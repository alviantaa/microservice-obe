<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$users = [
			[
				'id' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 3,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 4,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 6,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 7,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 8,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 9,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'id' => 10,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
		];

		foreach ($users as $user) {
			DB::table('users')->insert($user);
		}
	}
}
