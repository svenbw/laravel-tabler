<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        @include('tabler::components.partials.common.theme')
        @if (! empty(config('tabler.vite')))
            @vite(config('tabler.vite'))
        @endif
    </head>

    <body class="d-flex flex-column">
        <div class="page page-center">
            @yield('page')
        </div>
        @stack('scripts')
        @livewireScriptConfig
    </body>
</html>
