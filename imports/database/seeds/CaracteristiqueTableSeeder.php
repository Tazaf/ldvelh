<?php

class CaracteristiqueTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('caracteristiques')->delete();

		// Chance
		Caracteristique::create(array(
				'nom' => 'chance'
			));
	}
}