<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonnagesTable extends Migration {

	public function up()
	{
		Schema::create('personnages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('nom', 140);
			$table->tinyInteger('habilete_max')->unsigned();
			$table->tinyInteger('endurance_max')->unsigned();
			$table->tinyInteger('chance_max')->unsigned();
			$table->tinyInteger('habilete')->unsigned();
			$table->tinyInteger('endurance')->unsigned();
			$table->tinyInteger('chance')->unsigned();
			$table->tinyInteger('repas')->unsigned();
			$table->integer('bourse')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('personnages');
	}
}