<?php

Route::get('/', function () {
    return view('vue');
})->middleware('auth');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/{any}', 'VueController@index')->where('any', '.*')->middleware('auth');



