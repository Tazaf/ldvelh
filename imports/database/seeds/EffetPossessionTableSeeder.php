<?php

class EffetPossessionTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('effet_possession')->delete();

		// bijouchance
		EffetPossession::create(array(
				'effet_id' => 1,
				'possession_id' => 1
			));
	}
}