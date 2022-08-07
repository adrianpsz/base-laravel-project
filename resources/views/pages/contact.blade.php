@extends('app')

@section('seo-subtitle'){{ __('Contact') }} @endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{{ __('Contact') }}</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="mb-3">{{ __('About Us') }}</h3>
                <img class="img-fluid mb-3" src="{{ asset('images/about.png') }}" alt="{{ __('About Us') }}"/>
                <p class="mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi distinctio dolor ducimus
                    facilis fugiat harum necessitatibus nemo quibusdam quo repellendus saepe, sed ullam. Cumque facilis
                    fugiat itaque ratione ullam voluptatum.</p>
                <p class="mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi distinctio dolor ducimus
                    facilis fugiat harum necessitatibus nemo quibusdam quo repellendus saepe, sed ullam. Cumque facilis
                    fugiat itaque ratione ullam voluptatum.</p>
            </div>
            <div class="col-12 col-md-6">
                <contact-form :url="'{{ route('ajax.contact') }}'"></contact-form>
            </div>
        </div>
    </div>
@endsection
