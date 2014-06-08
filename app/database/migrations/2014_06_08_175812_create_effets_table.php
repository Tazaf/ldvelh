<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEffetsTable extends Migration {

	public function up()
	{
		Schema::create('effets', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('modificateur', array('-', '+'));
			$table->tinyInteger('valeur')->unsigned();
			$table->integer('caracteristique_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('effets');
	}
}