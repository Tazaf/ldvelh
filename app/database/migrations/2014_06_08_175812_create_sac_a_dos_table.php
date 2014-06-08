<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSacADosTable extends Migration {

	public function up()
	{
		Schema::create('sac_a_dos', function(Blueprint $table) {
			$table->integer('personnage_id')->unsigned();
			$table->integer('possession_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('sac_a_dos');
	}
}