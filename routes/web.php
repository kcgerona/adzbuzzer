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
if (env('ENVIRONMENT_PRODUCTION','local') === 'heroku') {
    \URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function(){
    \Session::put('test', 'Yayeee works');
    return \Session::get('test');
})

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
