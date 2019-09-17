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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('categories','CategoriesController')->middleware('auth');
Route::resource('posts','PostController')->middleware('auth');
Route::get('trashed-posts','PostController@trash')->name('trashed-posts')->middleware('auth');
Route::put('restore-posts/{post}','PostController@restore')->name('restore-posts')->middleware('auth');
