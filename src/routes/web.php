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

Route::get('/convert', 'ConvertController@index');
Route::post('/convert', 'ConvertController@convert')->name('convert');

Route::get('download/{filename}', function($filename) {
    return response()->download(storage_path('app/public/' . $filename));
})->name('download');
