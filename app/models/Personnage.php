<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Personnage extends Eloquent {

    protected $table = 'personnages';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function possessions() {
        return $this->hasMany('Possession')->withPivot('SacADos');
    }

}
