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
    <div class="row mb-3">
        <div class="col-12 col-md-8 offset-md-4">
            <h3>
                {{ $news->title }}
                @include('home.news.is_active',[
                    'n' => $news,
                ])
            </h3>
        </div>
    </div>
    <form method="POST" action="{{ route('home.news.update',['news' => $news->id]) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="row mb-3">
            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
            <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                       name="title" value="{{ $news->title }}" required autocomplete="off" autofocus>

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
                                  name="message" required autocomplete="off" rows="5">{{ $news->message }}</textarea>

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

                <update-images
                        class="@error('images.*') is-invalid @enderror @error('images') is-invalid @enderror"
                        :max="{{ \App\Models\Image::MAX_IMAGES - count($news->images) }}"
                        :image-url="'{{ url('image') }}'"
                        :delete-url="'{{ url('/home/images/ajax') }}'"
                        :reorder-url="'{{ url('/home/images/ajax/reorder') }}'"
                        :models='{{ $news->images }}'></update-images>


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
                    {{ __('Update news') }}
                </button>
            </div>
        </div>
    </form>
@endsection
