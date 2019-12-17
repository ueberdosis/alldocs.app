<div class="c-format-list">
  @foreach ($formats as $item)
    <a class="o-format c-format-list__item" href="{{ action('ConvertController@landingPage', [
      'input' => $input ?? $item['slug'],
      'output' => $output ?? $item['slug'],
    ]) }}">
      {{ $item['title'] }}
    </a>
  @endforeach
</div>
