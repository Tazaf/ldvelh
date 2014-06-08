<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePossessionsTable extends Migration {

	public function up()
	{
		Schema::create('possessions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nom', 50)->unique();
			$table->integer('type_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('possessions');
	}
}