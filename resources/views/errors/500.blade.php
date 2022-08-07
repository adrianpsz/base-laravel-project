@extends('errors.error_base')

@section('seo-subtitle')500 @endsection

@section('body')
    <p class="error">
        <strong>500</strong> <br>
        <small>{{ __('Internal Server Error') }}</small> <br>
        <small>
            <a href="/" style="color: #4a7a96">
                {{ __('Homepage') }}
            </a>
        </small>
    </p>
@endsection
