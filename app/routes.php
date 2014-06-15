<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', function() {
    return View::make('hello');
});

Route::get('test', function() {
    return 'test';
});

Route::get('1', function() {
    return Type::with('possessions')->get();
});

Route::get('2', function() {
    return Possession::with('effets')->get();
});

Route::get('3', function() {
    return Effet::with('caracteristique')->get();
});

Route::get('4', function() {
    return Personnage::with('possessions.effets.caracteristique', 'possessions.type')->get();
});

Route::get('5', function() {
    return Possession::with('type', 'effets.caracteristique', 'personnages')->get();
});