<?php

class Caracteristique extends Eloquent {

	protected $table = 'caracteristiques';
	public $timestamps = false;

	public function effets()
	{
		return $this->hasMany('Effet');
	}

}