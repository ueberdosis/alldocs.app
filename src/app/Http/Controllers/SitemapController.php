<?php

namespace App\Http\Controllers;

use App\Services\Pandoc;

class SitemapController extends Controller
{
    public function index()
    {
        $conversions = Pandoc::conversions();

        return response()->view('pages.sitemap.index', [
            'conversions' => $conversions,
        ])->header('Content-Type', 'text/xml');
    }
}
