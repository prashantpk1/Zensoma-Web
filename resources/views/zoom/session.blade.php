<!DOCTYPE html>
<html>
<head>
    <title>Zoom Session</title>
</head>
<body>
    <h1>Zoom Session Created</h1>
    <p><strong>Session Name:</strong> {{ $session['name'] }}</p>
    <p><strong>Session ID:</strong> {{ $session['id'] }}</p>
    <p><strong>Password:</strong> {{ $session['password'] }}</p>
    <p><strong>Join URL:</strong> <a href="{{ $session['join_url'] }}">{{ $session['join_url'] }}</a></p>
</body>
</html>
