<?php

class Possession extends Eloquent {

    protected $table = 'possessions';
    protected $appends = array('type');
    protected $hidden = array('type_id');
    public $timestamps = false;

    public function type() {
        return $this->belongsTo('Type');
    }

    public function effets() {
        return $this->belongsToMany('Effet');
    }
    
    public function getTypeAttribute() {
        return $this->type()->getResults()->nom;
    }
    
}
