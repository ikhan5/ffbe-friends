<?php

Route::get('/', function () {
    return view('vue');
});


Route::get('/unit/add', function () {
    return view('vue');
})->middleware('auth');

Route::get('/profile', function () {
    return view('vue');
})->middleware('auth');

Route::get('/home', function () {
    return redirect('/');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/{any}', 'VueController@index')->where('any', '.*');
