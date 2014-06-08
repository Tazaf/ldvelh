<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('possessions', function(Blueprint $table) {
			$table->foreign('type_id')->references('id')->on('type')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('effets', function(Blueprint $table) {
			$table->foreign('caracteristique_id')->references('id')->on('caracteristiques')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('effet_possession', function(Blueprint $table) {
			$table->foreign('effet_id')->references('id')->on('effets')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('effet_possession', function(Blueprint $table) {
			$table->foreign('possession_id')->references('id')->on('possessions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sac_a_dos', function(Blueprint $table) {
			$table->foreign('personnage_id')->references('id')->on('personnages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sac_a_dos', function(Blueprint $table) {
			$table->foreign('possession_id')->references('id')->on('possessions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('possessions', function(Blueprint $table) {
			$table->dropForeign('possessions_type_id_foreign');
		});
		Schema::table('effets', function(Blueprint $table) {
			$table->dropForeign('effets_caracteristique_id_foreign');
		});
		Schema::table('effet_possession', function(Blueprint $table) {
			$table->dropForeign('effet_possession_effet_id_foreign');
		});
		Schema::table('effet_possession', function(Blueprint $table) {
			$table->dropForeign('effet_possession_possession_id_foreign');
		});
		Schema::table('sac_a_dos', function(Blueprint $table) {
			$table->dropForeign('sac_a_dos_personnage_id_foreign');
		});
		Schema::table('sac_a_dos', function(Blueprint $table) {
			$table->dropForeign('sac_a_dos_possession_id_foreign');
		});
	}
}