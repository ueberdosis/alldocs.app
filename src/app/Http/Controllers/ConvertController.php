<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Conversion;
use Hashids\Hashids;
use App\Services\Pandoc;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConvertController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.convert.index');
    }

    public function redirect(Request $request)
    {
        $request->validate([
            'from' => [
                'required', 'string', Rule::in(Pandoc::inputFormats()),
            ],
            'to' => [
                'required', 'string', Rule::in(Pandoc::outputFormats()),
            ],
        ]);

        $from = Pandoc::find($request->get('from'));
        $to = Pandoc::find($request->get('to'));

        return redirect()->action('ConvertController@landingPage', [
            'input' => $from['slug'],
            'output' => $to['slug'],
        ]);
    }

    public function landingPage($input, $output)
    {
        if (Pandoc::invalidConversion($input, $output)) {
            return 'invalid';
            abort(404);
        }

        $conversions = Pandoc::conversions();

        return view('pages.convert.landingpage', [
            'from' => Pandoc::find($input),
            'to' => Pandoc::find($output),
            'conversions' => $conversions,
        ]);
    }

    public function convert(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'file'],
            'from' => [
                'required', 'string', Rule::in(Pandoc::inputFormats()),
            ],
            'to' => [
                'required', 'string', Rule::in(Pandoc::outputFormats()),
            ],
        ]);

        try {
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
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'error' => 'An error occurred while converting the file',
            ]);
        }
    }

    public function download($hashid)
    {
        $converstion = Conversion::where('hashId', $hashid)->first();
        return response()->download(storage_path('app/public/'.$converstion->hashId), $converstion->FileOriginalName.'.'.$converstion->to);
    }
}
