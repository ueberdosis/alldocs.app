@extends('layout.app')

@section('content')

    <h1>
        Convert All Docs To All Docs
    </h1>

    <p>
        Free, Secure, No Ads
    </p>

    <h2>
            <form action="{{ route('redirect-to-convertion') }}">
                Convert
                <select name="from">
                    <option value="">Select Format</option>
                    @foreach(\App\Services\Pandoc::inputFormatsData() as $format)
                        <option value="{{ $format['name'] ?? '' }}">
                            {{ $format['title'] }}
                        </option>
                    @endforeach
                </select>
                to
                <select name="to">
                    <option value="">Select Format</option>
                    @foreach(\App\Services\Pandoc::outputFormatsData() as $format)
                        <option value="{{ $format['name'] ?? '' }}">
                            {{ $format['title'] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">
                    Submit
                </button>
            </form>
        </h2>

    <h2>
        Most Used Convertions
    </h2>

    @foreach ($conversions->shuffle()->take(5) as $conversion)
        <a href="{{ $conversion->url }}">
            {{ $conversion->inputFormat->title }}
            &gt;
            {{ $conversion->outputFormat->title }}
        </a><br />
    @endforeach

@endsection
