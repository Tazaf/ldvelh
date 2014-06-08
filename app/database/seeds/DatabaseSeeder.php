<?php

class DatabaseSeeder extends Seeder {

    public function run() {
        Eloquent::unguard();

        $this->call('TypeTableSeeder');
        $this->command->info('Type table seeded!');

        $this->call('PossessionTableSeeder');
        $this->command->info('Possession table seeded!');
    }

}
