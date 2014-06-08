<?php

class TypeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('type')->delete();

		// BijouxSeeder
		Type::create(array(
				'nom' => 'bijoux'
			));

		// PotionSeeder
		Type::create(array(
				'nom' => 'potion'
			));
	}
}