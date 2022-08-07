<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<h1>{{ $subject }}</h1>
<h3>From: {{ $name }} {{ $email }}</h3>
<p>{!! $body !!}</p>
<p>{{ $ip }}</p>
</body>
</html>
