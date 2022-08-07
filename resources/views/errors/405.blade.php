@extends('errors.error_base')

@section('seo-subtitle')405 @endsection

@section('body')
    <p class="error">
        <strong>405</strong> <br>
        <small>{{ __('Method Not Allowed') }}</small> <br>
        <small>
            <a href="/" style="color: #4a7a96">
                {{ __('Homepage') }}
            </a>
        </small>
    </p>
@endsection
