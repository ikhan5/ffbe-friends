<?php

use Illuminate\Http\Request;

Route::resource('units', 'UnitController');
Route::resource('rankings', 'RankingController');
Route::resource('profile', 'ProfileController');
Route::resource('notifications', 'NotificationsController');
Route::resource('unit_requests', 'UnitRequestsController');

Route::get('/results', 'ResultController@index');
Route::patch('/updateOverall', 'ResultController@updateOverall');
Route::patch('/updateRole', 'ResultController@updateRole');

Route::get('/getRequests', 'UnitRequestsController@getUserRequests');
Route::get('/overallVote', 'RankingController@checkOverallVoteStatus');
Route::get('/roleVote', 'RankingController@checkRoleVoteStatus');
