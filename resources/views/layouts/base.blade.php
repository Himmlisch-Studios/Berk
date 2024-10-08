<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) </title>
    <link rel="shortcut icon" href="{{ asset(config('app.icon')) }}" />
    <meta name='robots' content='noindex,nofollow' />
    @yield('head')
    @wireUiScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="@yield('body-classes', 'bg-gray-100')">
    <x-notifications />
    <x-dialog />
    @yield('content-base')
    @livewireScriptConfig
    @stack('scripts')
    @yield('footer')
</body>

</html>
