<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <header>
            <a href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </header>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main role="main">
            @yield('content')
        </main>
    </div>

    <footer class="text-muted">
        <div class="container">
            <h3>
                Alldocs — The text converter for all your documents
            </h3>
            <p>
                This is a super fancy text converter. Wow. Amaze.
            </p>
            <h4>
                Free
            </h4>
            <p>
                We thought about making a VERY expensive app with offline support later, but we’re lazy.
            </p>
            <h4>
                No Ads
            </h4>
            <p>
                We forgot to install ads. Good for you, there is no real tracking here. Sorry, Google.
            </p>
            <h4>
                Secure
            </h4>
            <p>
                After 12 hours your files are deleted from our server. We don’t have time to read them anyway.
            </p>
            <h4>
                Open Startup
            </h4>
            <p>
                We made a public dashboard that has all our numbers. Even the revenue, but surprisingly it’s $0.
            </p>
            <h4>
                Just Works
            </h4>
            <p>
                Upload a file & download the converted file. Like a good joke, it needs no further explanation.
            </p>
            <h4>
                Cool Design
            </h4>
            <p>
                We checked out every post on Dribbble, took the best out and here it is: The perfect design.
            </p>

            <ul>
                <li>
                    <a href="#">
                        Privacy
                    </a>
                </li>
                <li>
                    <a href="#">
                        Terms
                    </a>
                </li>
                <li>
                    <a href="https://ueber.io/impressum">
                        Impressum
                    </a>
                </li>
                <li>
                    <a href="#">
                        About
                    </a>
                </li>
                <li>
                    <a href="https://floatie.app/alldocs">
                        Public Metrics
                    </a>
                </li>
            </ul>

            <p>Made with 💙 by <a href="https://twitter.com/_ueberdosis">überclub</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    @if (config('app.env') === 'production')
        <script async defer src="https://data.alldocs.app/app.js"></script>
        <noscript><img src="https://data.alldocs.app/image.gif" alt=""></noscript>
    @endif

    @if (manifest('vendor.js'))
        <script defer src="{{ manifest('vendor.js') }}"></script>
    @endif
    @if (manifest('app.js'))
        <script defer src="{{ manifest('app.js') }}"></script>
    @endif
</body>
</html>
