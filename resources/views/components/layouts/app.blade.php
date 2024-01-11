<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')

        @stack('styles')

    </head>

    <body class="antialiased bg-fuchsia-100">
        <h1 class="justify-center w-full pt-4 text-4xl font-bold text-center md:text-5xl mb-3 lg:mb-7 text-fuchsia-500">Chá Fralda Manuela 🍼</h1>

        {{ $slot }}

        @livewire('notifications')

        @filamentScripts
        @vite('resources/js/app.js')
        @stack('scripts')
    </body>
</html>
