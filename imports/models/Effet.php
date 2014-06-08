<?php

class Effet extends Eloquent {

	protected $table = 'effets';
	public $timestamps = false;

	public function caracteristique()
	{
		return $this->belongsTo('Caracteristique');
	}

	public function possessions()
	{
		return $this->hasMany('Possession');
	}

}