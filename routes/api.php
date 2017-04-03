<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login','API\AuthenticateController@login')->name('login');

Route::post('/register','API\RegisterController@register')->name('register');

Route::get('/PrivacyPolicy', function(){
    $filename = 'PrivacyPolicy.pdf';
    $path = public_path() . "/images/PrivacyPolicy.pdf" ;

    return Response::make(file_get_contents($path), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="'.$filename.'"'
    ]);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('users','API\UserController',['only' => [
    'index', 'show','update','destroy']]);
    
    Route::resource('messages','API\MessageController',['only' => [
    'index', 'show']]);
    
    Route::get('/logout','API\AuthenticateController@logout')->name('logout');
    
    //Firebase API request
    Route::get('/firebase/notify', 'API\FirebaseController@notifyChanges')->name('firebase.notify');
    Route::post('/firebase/messageuser', 'API\FirebaseController@sendUserMessage')->name('firebase.messageuser');
    Route::post('/firebase/messagechatroom', 'API\FirebaseController@sendChatroomMessage')->name('firebase.messagechatroom');
});
