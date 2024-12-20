<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			EmailTemplateSeeder::class,
			NotifyTemplateSeeder::class,
			CountrySeeder::class,
			StateSeeder::class,
			CitySeeder::class,
		]);
	}
}
