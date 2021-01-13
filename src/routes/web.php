<?php

use App\Http\Controllers\ConvertController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
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
Route::get('/', [PageController::class, 'home'])->name('page.home');
Route::view('/about', 'pages.about.index')->name('page.about');
Route::view('/privacy', 'pages.privacy.index')->name('page.privacy');
Route::view('/terms', 'pages.terms.index')->name('page.terms');

// Converters
Route::get('/redirect-to-conversion', [ConvertController::class, 'redirect'])->name('redirect-to-conversion');
Route::get('/redirect-to-format', [FormatController::class, 'redirect'])->name('redirect-to-format');
Route::post('/convert', [ConvertController::class, 'convert'])->name('convert');
Route::get('/download/{hashId}', [ConvertController::class, 'download'])->name('download');
Route::get('/convert-{input}-to-{output}', [ConvertController::class, 'landingPage'])->where([
    'input' => '[a-z0-9_-]+',
    'output' => '[a-z0-9_-]+',
]);
Route::get('/convert-{format}', [FormatController::class, 'show'])->where([
    'format' => '[a-z0-9_-]+',
]);

// Examples
Route::get('/examples/{file}', [ExampleController::class, 'show'])->where('file', '.*')->name('example.show');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
