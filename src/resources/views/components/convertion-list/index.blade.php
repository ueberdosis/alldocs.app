<ul class="c-convertion-list">
  @foreach ($conversions->shuffle()->take(5) as $conversion)
    <li class="c-convertion-list__item">
      <a class="c-convertion-list__link" href="{{ $conversion->url }}">
        <span class="c-convertion-list__format">
          <span class="o-format">
            {{ $conversion->inputFormat->title }}
          </span>
        </span>
        <span class="c-convertion-list__divider">
          <span class="u-visually-hidden">
            to
          </span>
        </span>
        <span class="c-convertion-list__format">
          <span class="o-format">
            {{ $conversion->outputFormat->title }}
          </span>
        </span>
      </a>
    </li>
  @endforeach
</ul>
