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
    </head>

    <body class="antialiased bg-gray-100">
        <livewire:layout.navigation />
        <main class="w-full md:max-w-3xl lg:max-w-6xl mx-auto px-4 pt-6 pb-4">
            {{ $slot }}
        </main>

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
