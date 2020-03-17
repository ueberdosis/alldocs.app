@extends('layout.app')

@section('content')
  @component('components.section.index')
    <h1>
      Terms
    </h1>

    <p>
      This service is free. You can use it and we expect it to work it properly, but if it doesn’t we can’t really do something about it.
    </p>
    <p>
      We don’t have ads, use only cookie-free tracking for pageviews and don’t do any data processing besides actually converting the files. Those files are deleted after a few hours. Easy like that.
    </p>
  @endcomponent
@endsection
