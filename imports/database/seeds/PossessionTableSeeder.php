<?php

class PossessionTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('possessions')->delete();

		// Emeraude
		Possession::create(array(
				'nom' => 'Émeraude',
				'type_id' => 1
			));

		// PotionAdresse
		Possession::create(array(
				'nom' => "Potion d'Adresse",
				'type_id' => 2
			));
	}
}