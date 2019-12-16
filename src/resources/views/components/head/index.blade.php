<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="format-detection" content="telephone=no">

<title>{{ config('app.name') }}</title>

@if (manifest('app.css'))
	<link rel="stylesheet" type="text/css" href="{{ manifest('app.css') }}">
@endif

@stack('head')
