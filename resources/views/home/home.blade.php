@extends('app')

@section('seo-subtitle'){{ __('Dashboard') }} @endsection

@section('content')
    <div class="container">
        @if (session('error'))
            <div id="error-message" class="row">
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif
        @if (session('success'))
            <div id="success-message" class="row">
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-md-4 col-xl-2 mb-3">
                <ul class="list-unstyled home-menu-list">
                    <li>
                        <a class="{{ Route::currentRouteNamed('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">{{ __('Start') }}</a>
                    </li>
                    <li>
                        <a class="{{ Route::currentRouteNamed('home.users.changePassword') ? 'active' : '' }}"
                           href="{{ route('home.users.changePassword') }}">{{ __('Change password') }}</a>
                    </li>
                    <li>
                        <a class="{{ Route::currentRouteNamed('home.news.index') ? 'active' : '' }}"
                           href="{{ route('home.news.index') }}">{{ __('Last news') }}</a>
                    </li>
                </ul>
                @if(Auth::user()->isAdmin())
                    <h4 class="mt-5">{{ __('Admin panel') }}</h4>
                    <ul class="list-unstyled home-menu-list">
                        <li>
                            <a class="{{ Route::currentRouteNamed('admin') ? 'active' : '' }}"
                               href="{{ route('admin') }}">{{ __('Start') }}</a>
                        </li>
                        <li>
                            <a class="{{ Route::currentRouteNamed('admin.users') ? 'active' : '' }}"
                               href="{{ route('admin.users') }}">{{ __('Users') }}</a>
                        </li>
                        <li>
                            <a class="{{ Route::currentRouteNamed('admin.news') ? 'active' : '' }}"
                               href="{{ route('admin.news') }}">{{ __('Last news') }}</a>
                        </li>
                    </ul>
                @endif
            </div>
            <div id="home-content" class="col-12 col-md-8 col-xl-10 border-start border-2 mb-5">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('Dashboard') }}, <small>{{ __('Hello') }} <strong>{{ Auth::user()->name }}</strong>
                                ({{ __('Roles') }}: {{ Auth::user()->rolesNames() }})</small></h2>
                        <hr>
                    </div>
                </div>
                @yield('home')
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent()

    <script>
		$(document).ready(function () {
			setTimeout(() => {
				$('#success-message').fadeOut();
				$('#error-message').fadeOut();
			}, 10000)
		});
    </script>
@endsection
