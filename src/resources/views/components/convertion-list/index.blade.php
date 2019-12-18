<ul class="c-convertion-list">
  @foreach ($conversions as $conversion)
    <li class="c-convertion-list__item">
      <a class="c-convertion-list__link" href="{{ $conversion->url }}">
        <span class="c-convertion-list__format">
          @component('components.format.index')
            {{ $conversion->inputFormat->title }}
          @endcomponent
        </span>
        <span class="c-convertion-list__divider">
          <icon class="c-convertion-list__icon" name="arrow-right"></icon>
          <span class="u-visually-hidden">
            to
          </span>
        </span>
        <span class="c-convertion-list__format">
          @component('components.format.index')
            {{ $conversion->outputFormat->title }}
          @endcomponent
        </span>
      </a>
    </li>
  @endforeach
</ul>
