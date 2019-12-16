@extends('layout.app')

@section('content')

  @component('components.section.index')
    <h1>
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
    </h1>
  @endcomponent

  @component('components.section.index')
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
  @endcomponent

  @component('components.section.index')
    <div class="grid">
      <div class="grid__item" data-grid--medium="6/12">
        <h2>
          Converting from {{ $from['title'] }}
        </h2>

        @isset($from['description'])
          <p>
            {{ $from['description'] }}
          </p>
        @endisset

        <a href="{{ $from['url'] }}">
          More
        </a>
      </div>

      <div class="grid__item" data-grid--medium="6/12">
        <h2>
          Converting to {{ $to['title'] }}
        </h2>

        @isset($to['description'])
          <p>
            {{ $to['description'] }}
          </p>
        @endisset

        <a href="{{ $to['url'] }}">
          More
        </a>
      </div>
    </div>
  @endcomponent

@endsection
