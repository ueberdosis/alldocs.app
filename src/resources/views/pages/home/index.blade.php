@extends('layout.app')

@section('content')

  @component('components.section.index')
    <h1>
      Convert All Docs To All Docs
    </h1>

    <p>
      Free, Secure, No Ads
    </p>
  @endcomponent

  @component('components.section.index')
    <form action="{{ route('redirect-to-convertion') }}">
      <h2 class="is-h1">
        Convert
        <select-format
          :formats="{{ collect(\App\Services\Pandoc::inputFormatsData()) }}"
          name="from"
        >
        </select-format>
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
  @endcomponent

@endsection
