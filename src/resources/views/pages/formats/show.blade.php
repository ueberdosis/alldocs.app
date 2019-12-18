@extends('layout.app')

@section('content')

  @component('components.section.index')
    <form action="{{ route('redirect-to-format') }}">
      <h1 class="u-centered">
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::outputFormatsData()) }}"
          selected="{{ $format['name'] }}"
          name="format"
        >
          {{ $format['title'] }}
        </select-format>
      </h1>

      @isset($format['description'])
        <p class="u-large">
          {{ $format['description'] }}
        </p>
      @endisset
    </form>
  @endcomponent

  @component('components.section.index')
    <div class="grid">

      @if (App\Services\Pandoc::inputFormats()->contains($format['name']))
        <div class="grid__item" data-grid--medium="6/12">
          <h2>
            Convert To
          </h2>
          @include('components.format-list.index', [
            'formats' => App\Services\Pandoc::outputFormatsData(),
            'input' => $format['slug'],
          ])
        </div>
      @endif

      @if (App\Services\Pandoc::outputFormats()->contains($format['name']))
        <div class="grid__item" data-grid--medium="6/12">
          <h2>
            Convert From
          </h2>
          @include('components.format-list.index', [
            'formats' => App\Services\Pandoc::inputFormatsData(),
            'output' => $format['slug'],
          ])
        </div>
      @endif

    </div>
  @endcomponent
@endsection
