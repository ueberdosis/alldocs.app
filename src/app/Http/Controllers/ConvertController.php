<?php

namespace App\Http\Controllers;

use App\Conversion;
use App\Services\Pandoc;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ConvertController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.convert.index');
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

        $hashIds = new Hashids(Str::random(5), 5);
        $hashId = $hashIds->encode(Carbon::now()->timestamp);

        $conversion = Conversion::create([
            'hashId' => $hashId,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'FileOriginalName' => $fileInfo['filename'],
            'fileExtension' => $fileInfo['extension'],
        ]);

        $request->file('file')->storeAs('public', $conversion->id);
        Pandoc::convert($conversion->id, $conversion->from, $conversion->to, $hashId);

        return redirect()->back()->with([
            'hashId' => $hashId,
        ]);
    }
}
