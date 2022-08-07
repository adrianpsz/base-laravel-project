@extends('errors.error_base')

@section('seo-subtitle')404 @endsection

@section('body')
    <p class="error">
        <strong>404</strong> <br>
        <small>{{ __('Site Not Found') }}</small> <br>
        <small>
            <a href="/" style="color: #4a7a96">
                {{ __('Homepage') }}
            </a>
        </small>
    </p>
@endsection

