<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEffetPossessionTable extends Migration {

	public function up()
	{
		Schema::create('effet_possession', function(Blueprint $table) {
			$table->integer('effet_id')->unsigned();
			$table->integer('possession_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('effet_possession');
	}
}