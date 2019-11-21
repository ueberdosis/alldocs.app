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
        $items = collect();

        collect(Pandoc::$inputFormats)->each(function ($inputFormat) use ($items) {
            collect(Pandoc::$outputFormats)->each(function ($outputFormat) use ($items, $inputFormat) {
                $slug = "{$inputFormat}-to-{$outputFormat}";

                $items->push(json_decode(json_encode([
                    'inputFormat' => $inputFormat,
                    'outputFormat' => $outputFormat,
                    'slug' => $slug,
                    'url' => action('ConvertController@landingPage', $slug),
                ])));
            });
        });

        return view('pages.home.index', [
            'items' => $items,
        ]);
    }
}
