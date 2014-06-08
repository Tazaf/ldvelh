<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Personnage extends Eloquent {

    protected $table = 'personnages';
    protected $hidden = ['created_at', 'deleted_at'];
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function possessions() {
        return $this->belongsToMany('Possession', 'sac_a_dos');
    }

}
