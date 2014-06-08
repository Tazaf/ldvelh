<?php

class Possession extends Eloquent {

    protected $table = 'possession';
    public $timestamps = false;

    public function type() {
        return $this->hasOne('Type');
    }

}
