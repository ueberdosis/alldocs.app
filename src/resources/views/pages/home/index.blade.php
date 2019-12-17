@extends('layout.app', ['navigation_theme' => 'bright'])

@section('content')

  @component('components.section.index', ['color' => 'blue', 'wide' => true])
    <div class="u-centered">
      <h1 class="is-h0">
        Convert All Docs
        <br>
        To All Docs
      </h1>
      <p>
        Free, Secure, No Ads
      </p>
    </div>
  @endcomponent

  @component('components.section.index')
    <form action="{{ route('redirect-to-convertion') }}">
      <h2 class="is-h1 u-centered">
        Convert
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::inputFormatsData()) }}"
          name="from"
        >
        </select-format>
        <br>
        to
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::outputFormatsData()) }}"
          name="to"
        >
        </select-format>
      </h2>
    </form>
  @endcomponent

  @component('components.section.index')
    <h2 class="u-centered">
      Most Used Convertions
    </h2>
    @include('components.convertion-list.index', [
      'convertions' => $conversions->shuffle()->take(5)
    ])
  @endcomponent

@endsection
