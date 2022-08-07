@extends('home.home')

@section('seo-subtitle'){{ $news->title }} @endsection

@section('home')
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ session('previous_page') }}" class="btn btn-success">
                <i class="fa-solid fa-chevron-left"></i>
                {{ __('Back') }}
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <h3>{{ $news->title }}</h3>
        </div>
        <div class="col-12 mb-3">
            <image-browser :url="'{{ url('image') }}'"
                           :images='{{ $news->images }}'></image-browser>
        </div>
        <div class="col-12 mb-3">
            {!! nl2br($news->message) !!}
        </div>

    </div>
@endsection
