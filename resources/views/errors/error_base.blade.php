<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.seo')

    <title>{{ config('app.name') }}</title>

    @include('layouts.raw_css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .error {
            font-size: 3rem;
            text-align: center;
            padding: 5rem;
            margin: 5rem;
            line-height: 3rem;
        }
    </style>
</head>
<body>
@yield('body')

@include('layouts.footer')
@include('layouts.scripts')
@yield('javascript')
@include('layouts.cookie_message')
</body>
</html>
