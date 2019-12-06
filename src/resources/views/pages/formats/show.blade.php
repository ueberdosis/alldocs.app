@extends('layout.app')

@section('content')
<h1>
    <h1>
        <form action="{{ route('redirect-to-format') }}">
            <select name="format">
                @foreach(App\Services\Pandoc::outputFormats()->map(function($item) {
                    return App\Services\Pandoc::find($item);
                }) as $item)
                    <option value="{{ $item['name'] }}" {{ $item['name'] === $format['name'] ? 'selected' : '' }}>
                        {{ $item['title'] }}
                    </option>
                @endforeach
            </select>
            <button type="submit">
                Submit
            </button>
        </form>
    </h1>
</h1>

@isset($format['description'])
    <p>
        {{ $format['description'] }}
    </p>
@endisset

@if (App\Services\Pandoc::inputFormats()->contains($format['name']))
    <h2>
        Convert To
    </h2>
    @foreach (App\Services\Pandoc::outputFormats()->map(function($item) {
        return App\Services\Pandoc::find($item);
    }) as $outputFormat)
        <a href="{{ action('ConvertController@landingPage', [
            'input' => $format['slug'],
            'output' => $outputFormat['slug'],
        ]) }}">
            {{ $outputFormat['title'] }}
        </a>
    @endforeach
@endif

@if (App\Services\Pandoc::outputFormats()->contains($format['name']))
    <h2>
        Convert From
    </h2>
    @foreach (App\Services\Pandoc::inputFormats()->map(function($item) {
        return App\Services\Pandoc::find($item);
    }) as $inputFormat)
        <a href="{{ action('ConvertController@landingPage', [
            'input' => $inputFormat['slug'],
            'output' => $format['slug'],
        ]) }}">
            {{ $inputFormat['title'] }}
        </a>
    @endforeach
@endif
@endsection
