<?php

class EffetTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('effets')->delete();

		// chance+2
		Effet::create(array(
				'modificateur' => '+',
				'valeur' => 2
			));
	}
}