<?php

namespace App\Http\Controllers;

use App\Conversion;
use App\Services\Pandoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ConvertController extends Controller
{
    public function index(Request $request)
    {
        return view('convert');
    }

    public function convert(Request $request)
    {
//        $validated = $this->validate($request, [
//            'file' => 'required|file',
//            'from' => Rule::in([
//                'required', 'string', Rule::in(Pandoc::$inputFormats)
//            ]),
//            'to' => Rule::in([
//                'required', 'string', Rule::in(Pandoc::$outputFormats)
//            ]),
//        ]);

        $file = $request->file('file');
        $fileInfo = pathinfo($file->getClientOriginalName());
        $hashedFilename = base64_encode(Hash::make(Carbon::now() . $file->getClientOriginalName()));

        $filename = $hashedFilename . '.' . $fileInfo['extension'];
        $request->file('file')->storeAs('public', $filename);

        $conversion = Conversion::create([
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'filename' => $filename,
            'new_filename' => $hashedFilename . '.' . $request->input('to'),
        ]);

        Pandoc::convert($conversion->filename, $conversion->from, $conversion->to);

        return redirect()->back()->with([
            'conversion' => $conversion,
        ]);
    }
}
