@extends('layout.app')

@section('page_title', "Convert {$from['long_title']} to {$to['long_title']} for free on " . config('app.name'))

@section('content')

  @component('components.section.index')
    <form action="{{ route('redirect-to-conversion') }}">
      <h1 class="u-centered">
        Convert
        <select-format
          :formats="{{ collect(\App\Services\FileFormat::inputFormatsData()) }}"
          selected="{{ $from['name'] }}"
          name="from"
          label="Input format"
        >
          {{ $from['title'] }}
        </select-format>
        <br>
        to
        <select-format
          :formats="{{ collect(\App\Services\FileFormat::outputFormatsData()) }}"
          selected="{{ $to['name'] }}"
          name="to"
          label="Output format"
        >
          {{ $to['title'] }}
        </select-format>
      </h1>
    </form>
    <p>
      Looking for a free text converter? Look no more, upload your {{ $from['long_title'] }} files and convert them to {{ $to['long_title'] }}. Yes, it’s that easy.
    </p>
  @endcomponent

  @component('components.section.index')
    <uploader
      action="{{ route('convert') }}"
      from="{{ $from['name'] }}"
      to="{{ $to['name'] }}"
      :accepted-files="{{ collect(data_get($from, 'extensions', ['.txt'])) }}"
    ></uploader>
  @endcomponent

  @component('components.section.index')
    <div class="grid">
      <div class="grid__item" data-grid--medium="6/12">
        <h2>
          Converting from {{ $from['long_title'] }}
        </h2>

        @isset($from['description'])
          <p>
            {{ $from['description'] }}
          </p>
        @endisset

        @isset($from['default_extension'])
          <p>
            The files end with <code>{{ $from['default_extension'] }}</code> by default.
          </p>
        @endisset

        <a class="o-small-button" href="{{ $from['url'] }}">
          <span>
            More about {{ $from['long_title'] }}
          </span>
          <icon name="arrow-right" size="small"></icon>
        </a>
      </div>

      <div class="grid__item" data-grid--medium="6/12">
        <h2>
          Converting to {{ $to['long_title'] }}
        </h2>

        @isset($to['description'])
          <p>
            {{ $to['description'] }}
          </p>
        @endisset

        @isset($to['default_extension'])
          The files end with <code>{{ $to['default_extension'] }}</code> by default.
        @endisset

        <a class="o-small-button" href="{{ $to['url'] }}">
          <span>
            More about {{ $to['long_title'] }}
          </span>
          <icon name="arrow-right" size="small"></icon>
        </a>
      </div>
    </div>
  @endcomponent

  @component('components.section.index')
    <h2 class="u-centered">
      More nerdy converters
    </h2>
    @include('components.conversion-list.index', [
      'conversions' => $conversions->shuffle()->take(10)
    ])
  @endcomponent

@endsection
