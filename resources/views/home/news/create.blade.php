@extends('home.home')

@section('seo-subtitle'){{ __('New news') }} @endsection

@section('home')
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home.news.index') }}" class="btn btn-success">
                <i class="fa-solid fa-chevron-left"></i>
                {{ __('Back') }}
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12 col-md-8 offset-md-4">
            <h3>{{ __('New news') }}</h3>
        </div>
    </div>
    <form method="POST" action="{{ route('home.news.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
            <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                       name="title" value="{{ old('title') }}" required autocomplete="off" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="message" class="col-md-4 col-form-label text-md-end">{{ __('Message') }}</label>
            <div class="col-md-6">
                        <textarea id="message" type="text" class="form-control @error('message') is-invalid @enderror"
                                  name="message" required autocomplete="off" rows="5">{{ old('message') }}</textarea>

                @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="message" class="col-md-4 col-form-label text-md-end">{{ __('Images') }}</label>
            <div class="col-md-6">

                <upload-images
                        :max="{{ \App\Models\Image::MAX_IMAGES  }}"
                        class="@error('images.*') is-invalid @enderror @error('images') is-invalid @enderror"></upload-images>

                @error('images.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('images')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6 offset-md-4">
                <button type="submit" class="btn btn-success">
                    {{ __('Add news') }}
                </button>
            </div>
        </div>
    </form>
@endsection
