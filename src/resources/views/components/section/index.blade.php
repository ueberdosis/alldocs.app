<section
  class="c-section c-section--{{ $color ?? 'white' }} {{ ($wide ?? false) ? 'c-section--wide' : null }}"
  @if(($color ?? 'white') === 'blue' && manifest('assets/images/banner.png'))
    style="background-image: url('{{ manifest('assets/images/banner.png') }}')"
  @endif
>
  <div class="c-section__inner">
    {{ $slot }}
  </div>

</section>
