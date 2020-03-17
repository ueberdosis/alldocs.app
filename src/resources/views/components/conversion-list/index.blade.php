<ul class="c-conversion-list">
  @foreach ($conversions as $conversion)
    <li class="c-conversion-list__item">
      <a class="c-conversion-list__link" href="{{ $conversion->url }}">
        <span class="c-conversion-list__format">
          @component('components.format.index')
            {{ $conversion->inputFormat->title }}
          @endcomponent
        </span>
        <span class="c-conversion-list__divider">
          <icon class="c-conversion-list__icon" name="arrow-right"></icon>
          <span class="u-visually-hidden">
            to
          </span>
        </span>
        <span class="c-conversion-list__format">
          @component('components.format.index')
            {{ $conversion->outputFormat->title }}
          @endcomponent
        </span>
      </a>
    </li>
  @endforeach
</ul>
