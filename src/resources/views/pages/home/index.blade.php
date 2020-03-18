@extends('layout.app', ['navigation_theme' => 'bright'])

@section('content')

  @component('components.section.index', ['color' => 'blue', 'wide' => true])
    <div class="u-centered">
      <h1 class="is-h0">
        Convert Any Text
        <br>
        To Any Format
      </h1>
      @include('components.banner-features.index')
    </div>
  @endcomponent

  @component('components.section.index')
    <form action="{{ route('redirect-to-conversion') }}">
      <h2 class="is-h1 u-centered">
        Convert
        <select-format
          :formats="{{ collect(\App\Services\FileFormat::inputFormatsData()) }}"
          name="from"
          label="Input format"
        >
        </select-format>
        <br>
        to
        <select-format
          :formats="{{ collect(\App\Services\FileFormat::outputFormatsData()) }}"
          name="to"
          label="Output format"
        >
        </select-format>
      </h2>
    </form>
  @endcomponent

  @component('components.section.index')
    <h2 class="u-centered">
      Most Used Conversions
    </h2>
    @include('components.conversion-list.index', [
      'conversions' => $mostUsedConversions,
    ])
  @endcomponent

@endsection
