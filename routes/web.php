<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Current website has one real page to speak of, which is a registration
| page.
|
*/

Route::get('/', 'Auth\RegisterController@getRegister');

Route::get('register', 'Auth\RegisterController@getRegister');
Route::post('register', 'Auth\RegisterController@postRegister');

