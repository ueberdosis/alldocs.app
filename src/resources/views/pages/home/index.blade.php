@extends('layout.app')

@section('content')

    @foreach ($items as $item)
        <a href="{{ $item->url }}">
            {{ $item->inputFormat }} to {{ $item->outputFormat }}
        </a><br />
    @endforeach

@endsection
