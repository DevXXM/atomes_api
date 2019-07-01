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

Route::get('/index','Index\IndexController@index')->name('index');



/*user*/
Route::group(['prefix'=>'user'],function(){
    Route::any('/userinfo', 'User\UserController@get_userinfo')->middleware("user_auth");
    Route::any('/update_userinfo', 'User\UserController@update_userinfo')->middleware("user_auth");
});

/*article*/
Route::group(['prefix'=>'event'],function(){
    Route::any('/info', 'Event\EventController@info')->middleware("user_auth");
    Route::any('/list', 'Event\EventController@lists');
    Route::any('/join', 'Event\EventController@join_event')->middleware("user_auth");
    Route::any('/my_project', 'Event\EventController@my_project')->middleware("user_auth");
});


/*article*/
Route::group(['prefix'=>'login_user'],function(){
    Route::any('/sendsms', 'User\LoginController@sendSMS');
    Route::any('/login_act', 'User\LoginController@login');
    Route::any('/reg_act', 'User\LoginController@reg');

});


