<?php

class PersonnageTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('personnages')->delete();

		// mathias
		Personnage::create(array(
				'nom' => 'Mathias',
				'habilete_max' => 19,
				'endurance_max' => 10,
				'chance_max' => 7,
				'habilete' => 19,
				'endurance' => 10,
				'chance' => 7,
				'repas' => 5,
				'bourse' => 165444
			));
	}
}