@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <h1 class="h3">
                    Convert {{ $from['title'] }} to {{ $to['title'] }}
                </h1>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">

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

            </div>
        </div>
    </div>

    @isset($from['description'])
        <div class="container">
            <div class="row my-4">
                <div class="col-md-12">
                    <h1>Converting from {{ $from['title'] }}</h1>
                    {{ $from['description'] }}
                </div>
            </div>
        </div>
    @endisset

    @isset($to['description'])
        <div class="container">
            <div class="row my-4">
                <div class="col-md-12">
                    <h2>Converting to {{ $to['title'] }}</h2>
                    {{ $to['description'] }}
                </div>
            </div>
        </div>
    @endisset

    @if(View::exists($path_to_view))
        <div class="container">
            <div class="row my-4">
                <div class="col-md-12">
                    @include($path_to_view)
                </div>
            </div>
        </div>
    @endif

@endsection
