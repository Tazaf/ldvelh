<?php

class Type extends Eloquent {

    protected $table = 'type';
    public $timestamps = false;

    public function possessions() {
        return $this->hasMany('Possession');
    }

}
