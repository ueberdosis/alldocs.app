<?php

namespace App\Http\Controllers;

use App\Services\FileFormat;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $conversions = FileFormat::conversions();

        return view('pages.home.index', [
            'conversions' => $conversions,
        ]);
    }
}
