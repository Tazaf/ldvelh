<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePossessionTable extends Migration {

    public function up() {
        Schema::create('possession', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 50)->unique();
            $table->integer('type_id')->unsigned();
        });
    }

    public function down() {
        Schema::drop('possession');
    }

}
