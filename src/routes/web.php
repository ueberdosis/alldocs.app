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

// Content
Route::get('/', 'PageController@home')->name('page.home');
Route::view('/about', 'pages.about.index')->name('page.about');
Route::view('/privacy', 'pages.privacy.index')->name('page.privacy');
Route::view('/terms', 'pages.terms.index')->name('page.terms');

// Converters
Route::get('/redirect-to-conversion', 'ConvertController@redirect')->name('redirect-to-conversion');
Route::get('/redirect-to-format', 'FormatController@redirect')->name('redirect-to-format');
Route::post('/convert', 'ConvertController@convert')->name('convert');
Route::get('/download/{hashid}', 'ConvertController@download')->name('download');
Route::get('/convert-{input}-to-{output}', 'ConvertController@landingPage')->where([
    'input' => '[a-z0-9_-]+',
    'output' => '[a-z0-9_-]+',
]);
Route::get('/convert-{format}', 'FormatController@show')->where([
    'format' => '[a-z0-9_-]+',
]);

// Sitemap
Route::get('/sitemap.xml', 'SitemapController@index');
