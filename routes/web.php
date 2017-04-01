<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@showProfile');
Route::get('/chat/{chatname}', 'HomeController@showChat');
Route::post('/chat/login', 'HomeController@login');
Route::post('/chat/register', 'HomeController@register');
Route::get('/logout', 'HomeController@logout');
Route::get('/messageschat/{chatname}', 'HomeController@messagesForChat');