@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <h2>
                    <form action="{{ route('redirect-to-convertion') }}">
                        Convert
                        <select name="from">
                            <option value="">Select Format</option>
                            @foreach(\App\Services\Pandoc::inputFormatsData() as $format)
                                <option value="{{ $format['name'] ?? '' }}" {{ $from['name'] === $format['name'] ? 'selected' : '' }}>
                                    {{ $format['title'] }}
                                </option>
                            @endforeach
                        </select>
                        to
                        <select name="to">
                            <option value="">Select Format</option>
                            @foreach(\App\Services\Pandoc::outputFormatsData() as $format)

                                <option value="{{ $format['name'] ?? '' }}" {{ $to['name'] === $format['name'] ? 'selected' : '' }}>
                                    {{ $format['title'] }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">
                            Submit
                        </button>
                    </form>
                </h2>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">

                <form class="form" action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="from" value="{{ $from['name'] }}">
                    <input type="hidden" name="to" value="{{ $to['name'] }}">

                    <input type="file" name="file">
                    <input type="submit" value="Convert">
                </form>

                @if(session('hashId'))
                    <a href="{{ route('download', session()->get('hashId')) }}">Download File</a>
                @endif

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <h1>Converting from {{ $from['title'] }}</h1>
                @isset($from['description'])
                    {{ $from['description'] }}
                @endisset
                <a href="{{ $from['url'] }}">
                    More
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <h2>Converting to {{ $to['title'] }}</h2>
                @isset($to['description'])
                    {{ $to['description'] }}
                @endisset
                <a href="{{ $to['url'] }}">
                    More
                </a>
            </div>
        </div>
    </div>

@endsection
