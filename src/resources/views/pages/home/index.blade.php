@extends('layout.app')

@section('content')

    @foreach ($conversions as $conversion)
        <a href="{{ $conversion->url }}">
            {{ $conversion->inputFormat->title }} to {{ $conversion->outputFormat->title }}
        </a><br />
    @endforeach

@endsection
