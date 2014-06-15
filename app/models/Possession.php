<?php

class Possession extends Eloquent {

    protected $table = 'possessions';
    protected $appends = ['type'];
    protected $hidden = ['type_id'];
    public $timestamps = false;

    public function type() {
        return $this->belongsTo('Type');
    }

    public function effets() {
        return $this->belongsToMany('Effet');
    }
    
    public function personnages() {
        return $this->belongsToMany('Personnage', 'sac_a_dos');
    }
    
    public function getTypeAttribute() {
        return $this->type()->getResults()->nom;
    }
    
}
