<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<h1>Hi {{ $name }}</h1>
<p>{{ __('You are receiving this email because we received a password reset request for your account.') }}</p>
<br>
<p><a href="{{ $link }}">{{ $link }}</a></p>
<br>
<p>{{ __('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]) }}</p>
<p>{{ __('If you did not request a password reset, no further action is required.') }}</p>
</body>
</html>
