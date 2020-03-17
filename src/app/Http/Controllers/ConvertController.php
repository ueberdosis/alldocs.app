<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Hashids\Hashids;
use App\Models\Conversion;
use Illuminate\Support\Str;
use App\Services\FileFormat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ueberdosis\Pandoc\Facades\Pandoc;

class ConvertController extends Controller
{
    public function redirect(Request $request)
    {
        $request->validate([
            'from' => [
                'required', 'string', Rule::in(FileFormat::inputFormats()),
            ],
            'to' => [
                'required', 'string', Rule::in(FileFormat::outputFormats()),
            ],
        ]);

        $from = FileFormat::find($request->get('from'));
        $to = FileFormat::find($request->get('to'));

        return redirect()->action('ConvertController@landingPage', [
            'input' => $from['slug'],
            'output' => $to['slug'],
        ]);
    }

    public function landingPage($input, $output)
    {
        if (FileFormat::invalidConversion($input, $output)) {
            return 'invalid';
            abort(404);
        }

        $conversions = FileFormat::conversions();

        return view('pages.convert.landingpage', [
            'from' => FileFormat::find($input),
            'to' => FileFormat::find($output),
            'conversions' => $conversions,
        ]);
    }

    public function convert(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'file'],
            'from' => [
                'required', 'string', Rule::in(FileFormat::inputFormats()),
            ],
            'to' => [
                'required', 'string', Rule::in(FileFormat::outputFormats()),
            ],
        ]);

        try {
            $file = $request->file('file');
            $fileInfo = pathinfo($file->getClientOriginalName());

            $hashIds = new Hashids(Str::random(5), 5);
            $hashId = $hashIds->encode(Carbon::now()->timestamp);

            $conversion = Conversion::create([
                'hash_id' => $hashId,
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'file_original_name' => $fileInfo['filename'],
                'file_extension' => $fileInfo['extension'],
            ]);

            $request->file('file')->storeAs('public', $conversion->id);

            $file = storage_path("app/public/{$conversion->id}");
            $from = $conversion->from;
            $to = $conversion->to;
            $output = storage_path("app/public/{$hashId}");

            Pandoc::file($file)
                ->from($from)
                ->to($to)
                ->output($output)
                ->convert();

            return [
                'filename' => $conversion->newFileName,
                'download_url' => route('download', $hashId),
            ];
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while converting the file.',
            ], 500);
        }
    }

    public function download($hashId)
    {
        $conversion = Conversion::where('hash_id', $hashId)->firstOrFail();

        return response()->download(
            $conversion->storagePath,
            $conversion->newFileName,
        );
    }
}
