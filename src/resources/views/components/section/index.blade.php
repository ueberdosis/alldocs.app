<section class="c-section c-section--{{ $color ?? 'transparent' }} {{ ($wide ?? false) ? 'c-section--wide' : null }}" >
  <div class="c-section__inner">
    {{ $slot }}
  </div>
</section>
