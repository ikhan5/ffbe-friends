<?php

use Illuminate\Http\Request;

Route::resource('units', 'UnitController');
Route::resource('profile', 'ProfileController');
Route::resource('notifications', 'NotificationsController');