<?php

namespace App\Http\Controllers;

use App\Services\FileFormat;

class SitemapController extends Controller
{
    public function index()
    {
        $conversions = FileFormat::conversions();

        return response()->view('pages.sitemap.index', [
            'conversions' => $conversions,
        ])->header('Content-Type', 'text/xml');
    }
}
