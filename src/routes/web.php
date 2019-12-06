<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PageController@home');
Route::get('/redirect-to-convertion', 'ConvertController@redirect')->name('redirect-to-convertion');
Route::get('/redirect-to-format', 'FormatController@redirect')->name('redirect-to-format');
Route::get('/convert', 'ConvertController@index');
Route::post('/convert', 'ConvertController@convert')->name('convert');
Route::get('/download/{hashid}', 'ConvertController@download')->name('download');
Route::get('/convert-{input}-to-{output}', 'ConvertController@landingPage')->where([
    'input' => '[a-z0-9_-]+',
    'output' => '[a-z0-9_-]+',
]);
Route::get('/convert-{format}', 'FormatController@show')->where([
    'format' => '[a-z0-9_-]+',
]);

Route::get('/sitemap.xml', 'SitemapController@index');
