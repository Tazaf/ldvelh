<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypeTable extends Migration {

    public function up() {
        Schema::create('type', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 50)->unique();
        });
    }

    public function down() {
        Schema::drop('type');
    }

}
