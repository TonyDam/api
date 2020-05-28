<?php
use Illuminate\Support\Facades\Route;

Route::get('users' , 'UserController@index');
Route::resource('user', 'UserController');
