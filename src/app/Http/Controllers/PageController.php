<?php

namespace App\Http\Controllers;

use App\Services\Pandoc;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $conversions = Pandoc::conversions();

        return view('pages.home.index', [
            'conversions' => $conversions,
        ]);
    }
}
