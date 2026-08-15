<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Handball Hub - Sports Competition & Tournament Management System">
    <title>@yield('title', 'Handball Hub — Sports Competition')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Assets in public/frontend/css/ and public/css/ -->
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Real-Time WebSockets Config -->
    <meta name="reverb-key" content="{{ config('broadcasting.connections.reverb.key', env('REVERB_APP_KEY', 'ebblun6tzqjoj7nqj3p3')) }}">
    <meta name="reverb-host" content="{{ config('broadcasting.connections.reverb.options.host', env('REVERB_HOST', '127.0.0.1')) }}">
    <meta name="reverb-port" content="{{ config('broadcasting.connections.reverb.options.port', env('REVERB_PORT', 8085)) }}">
    <meta name="reverb-scheme" content="{{ config('broadcasting.connections.reverb.options.scheme', env('REVERB_SCHEME', 'http')) }}">

    <!-- Real-Time WebSockets: Pusher & Laravel Echo Scripts -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script src="{{ asset('frontend/js/echo-init.js') }}"></script>
    @stack('styles')
</head>
<body>
