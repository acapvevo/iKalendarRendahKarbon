<footer class="footer-admin mt-auto footer-{{ $colour ?? 'light' }}">
    <div class="container-xl px-4">
        <div class="row">
            <div class="col-md-4 small d-flex justify-content-center align-items-center">Copyright &copy; Your Website
                2021</div>
            <div class="col-md-4 d-flex justify-content-center align-items-center dropdown">
                <label for="lang">{{ __('Language') }}:</label> &nbsp;
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    id="lang">
                    {{ LaravelLocalization::getCurrentLocaleNative() }}
                </button>
                <ul class="dropdown-menu">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            @php
                                if (isset($attributes) && !strpos(LaravelLocalization::getLocalizedURL($localeCode, null, [], true), '?')) {
                                    $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true) . '?';
                                    foreach ($attributes as $key => $value) {
                                        $url = $url . $key . '=' . $value . '&';
                                    }
                                } else {
                                    $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true);
                                }
                            @endphp
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ $url }}">
                                {{ __($properties['native']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4 text-md-end small d-flex justify-content-center align-items-center">
                <a href="#!">Privacy Policy</a>
                &middot;
                <a href="#!">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
