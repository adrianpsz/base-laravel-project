<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.seo')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    @include('layouts.raw_css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('layouts.svg')
<div id="page-wrapper">
    @include('layouts.header')
    @yield('hero')
    <div id="app" class="py-5">
        @yield('content')
    </div>
    @include('layouts.footer')
</div>

<!-- Scripts -->
<script>
	window._locale = '{{ app()->getLocale() }}';
	window._translations = {!! cache('translations') !!};
</script>
<script src="{{ asset('js/app.js') }}"></script>
@include('layouts.scripts')
@yield('javascript')
@include('layouts.cookie_message')
</body>
</html>
