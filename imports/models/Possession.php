<?php

class Possession extends Eloquent {

	protected $table = 'possessions';
	public $timestamps = false;

	public function type()
	{
		return $this->belongsTo('Type');
	}

	public function effets()
	{
		return $this->hasMany('Effet');
	}

	public function personnages()
	{
		return $this->hasMany('Personnage')->withPivot('SacADos');
	}

}