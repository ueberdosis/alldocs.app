<ul class="c-format-list">
  @foreach ($formats as $item)
    <li class="c-format-list__item">
      <a class="c-format-list__link" href="{{ action('ConvertController@landingPage', [
        'input' => $input ?? $item['slug'],
        'output' => $output ?? $item['slug'],
      ]) }}">
        @component('components.format.index')
          {{ $item['title'] }}
        @endcomponent
      </a>
    </li>
  @endforeach
</ul>
