<div class="c-page-footer">
  @component('components.section.index', ['color' => 'black'])
    <div class="c-page-footer__section">
      <h2>
        Alldocs — The text converter for all your documents
      </h2>
      <p>
        The internet is full of weird text formats, but finally you can convert any format in any other format. That’s worth a bookmark for sure.
      </p>
      <p>
        Converted {{ number_format(\App\Models\Conversion::count()) }} files.
      </p>
    </div>

    <div class="c-page-footer__section">
      <div class="grid">

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="money" size="small"></icon>
            <span>
              Free
            </span>
          </h3>
          <p class="u-small">
            We thought about making a VERY expensive app with offline support later, but we’re lazy.
          </p>
        </div>

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="block" size="small"></icon>
            <span>
              No Ads
            </span>
          </h3>
          <p class="u-small">
            We forgot to install ads. Good for you, there is no real tracking here. Sorry, Google.
          </p>
        </div>

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="shield" size="small"></icon>
            <span>
              Secure
            </span>
          </h3>
          <p class="u-small">
            After 12 hours your files are deleted from our server. We don’t have time to read them anyway.
          </p>
        </div>

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="stats" size="small"></icon>
            <span>
              Promotions
            </span>
          </h3>
          <p class="u-small">
            Check out our other open-source software frameworks <a href="https://tiptap.dev/">Tiptap</a> and <a href="https://tiptap.dev/hocuspocus">Hocuspocus</a>.
          </p>
        </div>

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="check" size="small"></icon>
            <span>
              Open Source
            </span>
          </h3>
          <p class="u-small">
            You probably think it’s too good to be true, but yes, <a href="https://github.com/ueberdosis/alldocs">this website is open source</a>.
          </p>
        </div>

        <div class="grid__item" data-grid--small="6/12" data-grid--medium="4/12">
          <h3>
            <icon name="fire" size="small"></icon>
            <span>
              Cool Design
            </span>
          </h3>
          <p class="u-small">
            We checked out every post on Dribbble, took the best out and here it is: The perfect design.
          </p>
        </div>

      </div>
    </div>

    <div class="c-page-footer__section">
      <div class="c-page-footer__links">
        <div class="grid" data-grid="narrow" data-grid--medium="normal">
          <div class="grid__item" data-grid--medium="4/12">
            <ul class="u-small">
              <li>
                <a href="{{ route('page.privacy') }}">
                  Privacy
                </a>
              </li>
              <li>
                <a href="{{ route('page.terms') }}">
                  Terms
                </a>
              </li>
              <li>
                <a href="https://ueber.io/impressum">
                  Impressum
                </a>
              </li>
            </ul>
          </div>

          <div class="grid__item" data-grid--medium="4/12">
            <ul class="u-small">
              <li>
                <a href="{{ route('page.about') }}">
                  About
                </a>
              </li>
              <li>
                <a href="mailto:support@alldocs.app">
                  Support
                </a>
              </li>
            </ul>
          </div>

          <div class="grid__item" data-grid--medium="4/12">
            <small>
              Made with 💙 by <a href="https://ueberdosis.io">überdosis</a>
            </small>
          </div>
        </div>
      </div>
    </div>
  @endcomponent
</div>
