@extends('app')

@section('seo-subtitle'){{ __('Index') }} @endsection

@section('hero')
    <div id="page-hero" class="mt-5">
        <div class="container">
            <div class="rol">
                <div class="col-12">
                    <img class="img-fluid"
                         src="{{ asset('images/hero.png') }}" alt="hero">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="col-12">
            <h2>{{ __('Last news') }}</h2>
            <hr>
        </div>
        <div class="row">
            @forelse($news as $n)
                <div class="col-12 col-md-6 mb-3">
                    <article class="row">
                        <div class="col-12 col-xl-6">
                            <image-browser :url="'{{ url('image') }}'"
                                           :images='{{ $n->images }}'></image-browser>
                        </div>
                        <div class="col-12 col-xl-6">
                            <header>
                                <h2 class="mb-1">{{ $n->title }}</h2>
                                <p class="meta small mb-1">
                                    {{ $n->user->name }}
                                    , {{ $n->created_at->format('Y-m-d') }}
                                </p>
                            </header>
                            <p>{{ $n->message }}</p>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    {{ __('No active news.') }}
                </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-12 pagination-wrapper text-center">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection

