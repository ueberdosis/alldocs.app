@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <h1 class="h3">
                    Convert Any Text Document to Any Other Text Format
                </h1>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">

                <form class="form" action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <select name="from">
                        @foreach(\App\Services\Pandoc::inputFormats() as $inputFormat)
                            <option value="{{ $inputFormat['name'] }}" @if($inputFormat['name'] == 'markdown') selected @endif>{{ $inputFormat['title'] }}</option>
                        @endforeach
                    </select>

                    <select name="to">
                        @foreach(\App\Services\Pandoc::$outputFormats as $outputFormat)
                            <option value="{{ $outputFormat['name'] }}" @if($outputFormat['name'] == 'html') selected @endif>{{ $outputFormat['title'] }}</option>
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
    </div>

@endsection
