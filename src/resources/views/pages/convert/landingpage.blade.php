@extends('layout.app')

@section('page_title', "Convert {$from['long_title']} to {$to['long_title']} for free on " . config('app.name'))

@section('content')

  @component('components.section.index')
    <form action="{{ route('redirect-to-convertion') }}">
      <h1 class="u-centered">
        Convert
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::inputFormatsData()) }}"
          selected="{{ $from['name'] }}"
          name="from"
          label="Input format"
        >
          {{ $from['title'] }}
        </select-format>
        <br>
        to
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::outputFormatsData()) }}"
          selected="{{ $to['name'] }}"
          name="to"
          label="Output format"
        >
          {{ $to['title'] }}
        </select-format>
      </h1>
    </form>
  @endcomponent

  @component('components.section.index')
    <uploader
      action="{{ route('convert') }}"
      from="{{ $from['name'] }}"
      to="{{ $to['name'] }}"
      :accepted-files="{{ collect(data_get($from, 'extensions', ['.txt'])) }}"
    ></uploader>
    {{-- <form class="form" action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name="from" value="{{ $from['name'] }}">
      <input type="hidden" name="to" value="{{ $to['name'] }}">

      <input type="file" name="file">
      <input type="submit" value="Convert">
    </form>

    @if(session('hashId'))
      <a href="{{ route('download', session()->get('hashId')) }}">Download File</a>
    @endif --}}
  @endcomponent

  @if(isset($from['description']) || isset($to['description']))
    @component('components.section.index')
      <div class="grid">

        @isset($from['description'])
          <div class="grid__item" data-grid--medium="6/12">
            <h2>
              Converting from {{ $from['title'] }}
            </h2>

            @isset($from['description'])
              <p>
                {{ $from['description'] }}
              </p>
            @endisset

            <a class="o-small-button" href="{{ $from['url'] }}">
              <span>
                More
              </span>
              <icon name="arrow-right" size="small"></icon>
            </a>
          </div>
        @endisset

        @isset($to['description'])
          <div class="grid__item" data-grid--medium="6/12">
            <h2>
              Converting to {{ $to['title'] }}
            </h2>

            @isset($to['description'])
              <p>
                {{ $to['description'] }}
              </p>
            @endisset

            <a class="o-small-button" href="{{ $to['url'] }}">
              <span>
                More
              </span>
              <icon name="arrow-right" size="small"></icon>
            </a>
          </div>
        @endisset
      </div>
    @endcomponent
  @endif

  @component('components.section.index')
    <h2 class="u-centered">
      More nerdy converters
    </h2>
    @include('components.convertion-list.index', [
      'conversions' => $conversions->shuffle()->take(10)
    ])
  @endcomponent

@endsection
