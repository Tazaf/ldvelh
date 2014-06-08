<?php

class Effet extends Eloquent {

    protected $table = 'effets';
    //protected $appends = array('caracteristique');
    //protected $hidden = array('caracteristique_id', 'pivot');
    public $timestamps = false;

    public function caracteristique() {
        return $this->belongsTo('Caracteristique');
    }

    public function possessions() {
        return $this->belongsToMany('Possession');
    }

    public function getCaracteristiqueAttribute() {
        return $this->caracteristique()->getResults()->nom;
    }

}
