<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use Pandoc\Facades\Pandoc;
use App\Services\FileFormat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        // try {
        list(
                'filename' => $filename,
                'extension' => $extension
            ) = pathinfo(
                $request->file('file')->getClientOriginalName()
            );

        $conversion = Conversion::create([
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'original_file_name' => $filename,
            'file_extension' => $extension,
        ]);

        $request->file('file')->storeAs('public', $conversion->id);

        Pandoc::inputFile($conversion->originalFile)
                ->from($conversion->from)
                ->to($conversion->to)
                ->output($conversion->convertedFile)
                ->run();

        return [
            'success' => true,
            'filename' => $conversion->convertedFileName,
            'download_url' => route('download', $conversion->hash_id),
        ];
        // } catch (\Exception $exception) {
        //     return response()->json([
        //         'success' => false,
        //         'error' => 'An error occurred while converting the file.',
        //     ], 500);
        // }
    }

    public function download($hashId)
    {
        $conversion = Conversion::where('hash_id', $hashId)->firstOrFail();

        return response()->download(
            $conversion->convertedFile,
            $conversion->convertedFileName,
        );
    }
}
