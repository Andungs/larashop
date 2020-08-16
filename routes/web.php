<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::middleware('auth')->group(function () {
    Route::get('dashbord', 'DashbordController@index')->name('dashbord');

    Route::post('category/{id}', 'CategoryController@update');
    Route::resource('category', 'CategoryController')->except([
        'show', 'create', 'update'
    ]);
    Route::post('product/{id}', 'ProductController@update');
    Route::resource('product', 'ProductController')->except([
        'show', 'create', 'update'
    ]);
    Route::get('gallery-photo/{id}', 'GalleryProductController@getPhoto');
    Route::resource('gallery', 'GalleryProductController')->except([
        'show', 'create', 'update', 'edit'
    ]);
});

Auth::routes(['register' => false]);
