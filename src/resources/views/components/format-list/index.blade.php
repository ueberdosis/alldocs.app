<div class="c-format-list">
  @foreach ($formats as $item)
    <a class="c-format-list__item" href="{{ action('ConvertController@landingPage', [
      'input' => $input ?? $item['slug'],
      'output' => $output ?? $item['slug'],
    ]) }}">
      @component('components.format.index')
        {{ $item['title'] }}
      @endcomponent
    </a>
  @endforeach
</div>
