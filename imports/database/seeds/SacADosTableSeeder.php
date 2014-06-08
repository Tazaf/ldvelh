<?php

class SacADosTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('sac_a_dos')->delete();

		// seed1
		SacADos::create(array(
				'personnage_id' => 1,
				'possession_id' => 1
			));
	}
}