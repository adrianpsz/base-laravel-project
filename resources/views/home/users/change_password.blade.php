@extends('home.home')

@section('seo-subtitle'){{ __('Change password') }} @endsection

@section('home')
    <h3>{{ __('Change password') }}</h3>
    <form method="POST" action="{{ route('home.users.updatePassword') }}">
        @csrf

        <div class="row mb-3">
            <label for="current-password"
                   class="col-md-4 col-form-label text-md-end">{{ __('Current password') }}</label>

            <div class="col-md-6">
                <input id="current-password" type="password"
                       class="form-control @error('current-password') is-invalid @enderror"
                       name="current-password" required autocomplete="off">

                @error('current-password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="new-password"
                   class="col-md-4 col-form-label text-md-end">{{ __('New password') }}</label>

            <div class="col-md-6">
                <input id="new-password" type="password"
                       class="form-control @error('new-password') is-invalid @enderror" name="new-password"
                       required autocomplete="off">

                @error('new-password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="new-password-confirm"
                   class="col-md-4 col-form-label text-md-end">{{ __('Confirm new password') }}</label>

            <div class="col-md-6">
                <input id="new-password-confirm" type="password" class="form-control"
                       name="new-password_confirmation" required autocomplete="off">
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Change password') }}
                </button>
            </div>
        </div>
    </form>
@endsection
