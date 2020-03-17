@extends('layout.app')

@section('content')
  @component('components.section.index')
    <h1>
      About
    </h1>

    <p>
      Alldocs is a free online text converter that converts any text document format to any text document format. To be precise, we support not less than {{ \App\Services\FileFormat::conversions()->count() }} ways to convert files.
    </p>

    <h2>
      Why did you build this?
    </h2>
    <p>
      We needed to convert a bunch of files and stumbled upon <a href="https://pandoc.org/">Pandoc</a>. Pandoc is an amazing document converter, but you have to use it on the command line. There are a few online services that make Pandoc available in the browser, none felt right to us though.
    </p>
    <p>
      We want to make the power of Pandoc more accessible to others, maybe to people that don’t know how to use a command-line tool or to people that want something easy. Hope we did a good job on this.
    </p>
    <h2>
      Why is it free?
    </h2>
    <p>
      We’re building tools and web services on a regular basis. Some are free, some make money. We probably add Windows and macOS apps (for offline support) at some point. I think we would charge for the apps then.
    </p>
    <p>
      We have a few other ideas, but the main service will stay free. And by the way, we don’t think anyone should make money with your data. We don’t use your data for anything else than converting those files.
    </p>
    <p>
      That means: no tracking (Okay, SimpleAnalytics, but that doesn’t even use Cookies.), no ads, no data processing, no Facebook pixels, no machine learning, no AI, no cloud computing, nothing. Just the service.
    </p>

    <h2>
      You’re awesome. How can I support you?
    </h2>
    <p>
      Have a look at our other apps (<a href="https://mouseless.app">Mouseless</a>, <a href="https://www.glyphfinder.com">Glyphfinder</a>, <a href="https://skara.io">Skara</a> & <a href="https://scrumpy.io">Scrumpy</a>), maybe there is one for you.
    </p>
  @endcomponent
@endsection
