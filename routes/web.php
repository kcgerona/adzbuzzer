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
    session()->put('test', 'Yayeee works');
    return redirect()->route('test2');
});
Route::get('test2', function(){
    return [session()->get('test'), session()->has('test')];
})->name('test2');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
