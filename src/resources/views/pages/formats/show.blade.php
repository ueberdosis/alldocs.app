@extends('layout.app')

@section('content')

  @component('components.section.index')
    <form action="{{ route('redirect-to-format') }}">
      <h1>
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::outputFormatsData()) }}"
          :selected-format="{{ collect($format) }}"
          name="format"
        >
          {{ $format['title'] }}
        </select-format>
      </h1>
    </form>
  @endcomponent

  @isset($format['description'])
    @component('components.section.index')
      <p>
        {{ $format['description'] }}
      </p>
    @endcomponent
  @endisset

  @component('components.section.index')
    @if (App\Services\Pandoc::inputFormats()->contains($format['name']))
      <h2>
        Convert To
      </h2>
      @foreach (App\Services\Pandoc::outputFormatsData() as $outputFormat)
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
      @foreach (App\Services\Pandoc::inputFormatsData() as $inputFormat)
        <a href="{{ action('ConvertController@landingPage', [
          'input' => $inputFormat['slug'],
          'output' => $format['slug'],
        ]) }}">
          {{ $inputFormat['title'] }}
        </a>
      @endforeach
    @endif
  @endcomponent
@endsection
