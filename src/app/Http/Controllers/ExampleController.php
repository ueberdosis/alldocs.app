<?php

namespace App\Http\Controllers;

use Pandoc\Facades\Pandoc;
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

        return Pandoc::dataDir(storage_path('app/data'))
            ->from('markdown')
            ->input($content)
            ->to('html')
            ->run();
    }
}
