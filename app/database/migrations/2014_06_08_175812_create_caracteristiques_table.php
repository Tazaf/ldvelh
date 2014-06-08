<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaracteristiquesTable extends Migration {

	public function up()
	{
		Schema::create('caracteristiques', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom', 50)->unique();
		});
	}

	public function down()
	{
		Schema::drop('caracteristiques');
	}
}