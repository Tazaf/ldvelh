<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

    public function up() {
        Schema::table('possession', function(Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('type')
            ->onDelete('restrict')
            ->onUpdate('restrict');
        });
    }

    public function down() {
        Schema::table('possession', function(Blueprint $table) {
            $table->dropForeign('possession_type_id_foreign');
        });
    }

}
