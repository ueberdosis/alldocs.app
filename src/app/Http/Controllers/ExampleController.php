<?php

namespace App\Http\Controllers;

use Ueberdosis\Pandoc\Facades\Pandoc;
use Illuminate\Support\Facades\Storage;

class ExampleController extends Controller
{
    public function show($file)
    {
        $path = "examples/{$file}";

        if (!Storage::exists($path)) {
            abort(404);
        }

        $content = Storage::get($path);

        return Pandoc::from('markdown')
            ->input($content)
            ->to('html')
            ->run();
    }
}
