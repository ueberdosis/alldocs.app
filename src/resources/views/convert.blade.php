<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alldocs</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">

        <form action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
            @csrf

            <select name="from">
                @foreach(\App\Services\Pandoc::$inputFormats as $inputFormat)
                    <option value="{{ $inputFormat }}" @if($inputFormat == 'markdown') selected @endif>{{ $inputFormat }}</option>
                @endforeach
            </select>

            <select name="to">
                @foreach(\App\Services\Pandoc::$outputFormats as $outputFormat)
                    <option value="{{ $outputFormat }}" @if($outputFormat == 'html') selected @endif>{{ $outputFormat }}</option>
                @endforeach
            </select>

            <input type="file" name="file">
            <input type="submit" value="Convert">
        </form>

        @if(session('hashId'))
            <a href="{{ route('download', session()->get('hashId')) }}">Download File</a>
        @endif

    </div>
</div>
</body>
</html>
