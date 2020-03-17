<?php

namespace App\Http\Controllers;

use App\Services\FileFormat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FormatController extends Controller
{
    public function redirect(Request $request)
    {
        $request->validate([
            'format' => [
                'required', 'string', Rule::in(FileFormat::outputFormats()),
            ],
        ]);

        return redirect(
            FileFormat::find($request->get('format'))['url']
        );
    }

    public function show($format)
    {
        $format = FileFormat::find($format);

        if (!$format) {
            abort(404);
        }

        return view('pages.formats.show', [
            'format' => $format,
        ]);
    }
}
