<div id="page-footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <hr>
                <ul class="list-unstyled list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('index') }}"
                           class="{{ Route::currentRouteNamed('index') ? 'active' : '' }}">
                            {{ __('Homepage') }}
                        </a>
                    </li>
                    <li class="list-inline-item text-black-50">|</li>
                    <li class="list-inline-item">
                        <a href="{{ route('privacy') }}"
                           class="{{ Route::currentRouteNamed('privacy') ? 'active' : '' }}">
                            {{ __("Privacy Policy") }}
                        </a>
                    </li>
                    <li class="list-inline-item text-black-50">|</li>
                    <li class="list-inline-item">
                        <a href="{{ route('terms') }}"
                           class="{{ Route::currentRouteNamed('terms') ? 'active' : '' }}">
                            {{ __("Terms") }}
                        </a>
                    </li>
                    <li class="list-inline-item text-black-50">|</li>
                    <li class="list-inline-item">
                        <a href="{{ route('contact') }}"
                           class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">
                            {{ __("Contact") }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
