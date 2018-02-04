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

Route::get('/', function () {
    return view('showcase', [
        'movies' => \MindGeekTest\Movie::query()->paginate(15)
    ]);
});

Route::get('movie/{movie}', 'MovieController@show')->name('movie');