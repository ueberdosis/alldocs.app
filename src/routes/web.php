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

Route::view('/', 'pages.home.index');

Route::get('/convert', 'ConvertController@index');
Route::post('/convert', 'ConvertController@convert')->name('convert');

Route::get('download/{hashid}', function ($hashid) {
    $converstion = \App\Conversion::where('hashId', $hashid)->first();

    return response()->download(storage_path('app/public/'.$converstion->hashId), $converstion->FileOriginalName.'.'.$converstion->to);
})->name('download');
