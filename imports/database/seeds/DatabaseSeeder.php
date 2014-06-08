<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('TypeTableSeeder');
		$this->command->info('Type table seeded!');

		$this->call('PossessionTableSeeder');
		$this->command->info('Possession table seeded!');

		$this->call('CaracteristiqueTableSeeder');
		$this->command->info('Caracteristique table seeded!');

		$this->call('EffetTableSeeder');
		$this->command->info('Effet table seeded!');

		$this->call('EffetPossessionTableSeeder');
		$this->command->info('EffetPossession table seeded!');

		$this->call('PersonnageTableSeeder');
		$this->command->info('Personnage table seeded!');

		$this->call('SacADosTableSeeder');
		$this->command->info('SacADos table seeded!');
	}
}