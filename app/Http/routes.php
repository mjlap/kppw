<?php




Route::get('/', 'HomeController@index');

Route::get('/changeCate/{id}', 'HomeController@changeCate');
