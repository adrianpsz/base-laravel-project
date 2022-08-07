@extends('errors.error_base')

@section('seo-subtitle')403 @endsection

@section('body')
    <p class="error">
        <strong>403</strong> <br>
        <small>{{ __('This Action Is Unauthorized') }}</small> <br>
        <small>
            <a href="/" style="color: #4a7a96">
                {{ __('Homepage') }}
            </a>
        </small>
    </p>
@endsection

